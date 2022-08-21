<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Carbon\Carbon;
use Coeliac\Common\Models\TemporaryFileUpload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class WhereToEatReviewImageUploadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('uploads');
    }

    protected function makeRequest($images = null): TestResponse
    {
        return $this->post('/api/wheretoeat/review/image-upload', ['images' => $images]);
    }

    /** @test */
    public function itErrorsWithoutAnyImages(): void
    {
        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfImagesIsntAnArray(): void
    {
        $this->makeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfTheArrayHasMoreThanSixItems(): void
    {
        $this->makeRequest([1, 2, 3, 4, 5, 6, 7])->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfTheImageItemsArentFiles(): void
    {
        $this->makeRequest(['foo'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfTheImagesArentValidImageFiles(): void
    {
        $this->makeRequest([
            UploadedFile::fake()->create('foo.txt', 1, 'text/plain'),
        ])->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfTheImagesArentAValidMimeType(): void
    {
        $this->makeRequest([UploadedFile::fake()->image('foo.svg')])->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfTheImagesAreGreaterThan5mbInSize(): void
    {
        $this->makeRequest([
            UploadedFile::fake()->create('foo.jpg', 5121),
        ])->assertStatus(422);
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $this->makeRequest([UploadedFile::fake()->image('foo.jpg')])->assertOk();
    }

    /** @test */
    public function itStoresTheImageInTheFileUploadsBucket(): void
    {
        Storage::disk('uploads')->assertDirectoryEmpty('/');

        $this->makeRequest([UploadedFile::fake()->image('foo.jpg')]);

        $this->assertNotEmpty(Storage::disk('uploads')->allFiles('/'));
    }

    /** @test */
    public function itStoresImagesWithARandomName(): void
    {
        $this->makeRequest([UploadedFile::fake()->image('foo.jpg')]);

        Storage::disk('uploads')->assertMissing('foo.jpg');
    }

    /** @test */
    public function itStoresUploadedImagesInTheDatabase(): void
    {
        $this->assertEmpty(TemporaryFileUpload::all());

        $this->makeRequest([UploadedFile::fake()->image('foo.jpg')]);

        $this->assertNotEmpty(TemporaryFileUpload::all());
    }

    /** @test */
    public function itStoresTheCorrectImageUploadProperties(): void
    {
        TestTime::freeze();

        $this->makeRequest([$file = UploadedFile::fake()->image('foo.jpg')]);

        $fileUpload = TemporaryFileUpload::query()->first();

        $this->assertEquals($file->hashName(), $fileUpload->filename);
        $this->assertEquals($file->getSize(), $fileUpload->filesize);
        $this->assertEquals($file->getMimeType(), $fileUpload->mime);
        $this->assertEquals('wte-review-image', $fileUpload->source);
        $this->assertEquals(Carbon::now()->addMinutes(15)->toDateTimeString(), $fileUpload->delete_at);
    }

    /** @test */
    public function itReturnsAnImagesArray(): void
    {
        $this->makeRequest([UploadedFile::fake()->image('foo.jpg')])->assertJsonStructure(['images']);
    }

    /** @test */
    public function itReturnsAObjectForEachImage(): void
    {
        $this->makeRequest([
            UploadedFile::fake()->image('foo.jpg'),
            UploadedFile::fake()->image('bar.jpg'),
        ])->assertJsonCount(2, 'images');
    }

    /** @test */
    public function itReturnsAFormattedObjectForEachImage(): void
    {
        $this->makeRequest([
            UploadedFile::fake()->image('foo.jpg'),
            UploadedFile::fake()->image('bar.jpg'),
        ])->assertJsonStructure([
            'images' => [['id', 'path']],
        ]);
    }

    /** @test */
    public function itReturnsTheIdFromTheDatabase(): void
    {
        $response = $this->makeRequest([UploadedFile::fake()->image('foo.jpg')])->json();

        $fileUpload = TemporaryFileUpload::query()->first();

        $this->assertEquals($fileUpload->id, $response['images'][0]['id']);
    }

    /** @test */
    public function itReturnsAImagePathFromTheDatabase(): void
    {
        TestTime::freeze();

        $response = $this->makeRequest([UploadedFile::fake()->image('foo.jpg')])->json();

        $fileUpload = TemporaryFileUpload::query()->first();

        $this->assertEquals(
            Storage::temporaryUrl($fileUpload->path, Carbon::now()->addMinute()),
            $response['images'][0]['path']
        );
    }
}
