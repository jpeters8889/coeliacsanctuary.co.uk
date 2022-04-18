<?php

namespace Tests\Unit\Common\Models;

use Carbon\Carbon;
use Coeliac\Common\Models\TemporaryFileUpload;
use Illuminate\Http\UploadedFile;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class TemporaryFileUploadModelTest extends TestCase
{
    /** @test */
    public function itCanBeCreatedFromAnHelperFunction(): void
    {
        $this->assertEmpty(TemporaryFileUpload::all());

        TemporaryFileUpload::createFrom($file = UploadedFile::fake()->create('foo.pdf'), 'foo');

        $this->assertNotEmpty(TemporaryFileUpload::all());
        $this->assertCount(1, TemporaryFileUpload::all());

        $fileUpload = TemporaryFileUpload::query()->first();

        $this->assertEquals($file->hashName(), $fileUpload->filename);
        $this->assertEquals($file->getSize(), $fileUpload->size);
        $this->assertEquals($file->getMimeType(), $fileUpload->mime);
    }

    /** @test */
    public function itHasADefaultSource(): void
    {
        TemporaryFileUpload::createFrom(UploadedFile::fake()->create('foo.pdf'), 'foo');

        $fileUpload = TemporaryFileUpload::query()->first();

        $this->assertEquals('upload', $fileUpload->source);
    }

    /** @test */
    public function itCanHaveACustomSourceSet(): void
    {
        TemporaryFileUpload::createFrom(UploadedFile::fake()->create('foo.pdf'), 'foo', 'test');

        $fileUpload = TemporaryFileUpload::query()->first();

        $this->assertEquals('test', $fileUpload->source);
    }

    /** @test */
    public function itHasADefaultDeleteAtOfOneDay(): void
    {
        TestTime::freeze();

        TemporaryFileUpload::createFrom(UploadedFile::fake()->create('foo.pdf'), 'foo');

        $fileUpload = TemporaryFileUpload::query()->first();

        $this->assertEquals(Carbon::now()->addDay()->toDateTimeString(), $fileUpload->delete_at);
    }

    /** @test */
    public function itCanHaveACustomDeletedAtSet(): void
    {
        $deleteAt = Carbon::now()->addMinute();

        TemporaryFileUpload::createFrom(UploadedFile::fake()->create('foo.pdf'), 'foo', deleteAt: $deleteAt);

        $fileUpload = TemporaryFileUpload::query()->first();

        $this->assertEquals($deleteAt->toDateTimeString(), $fileUpload->delete_at);
    }

    /** @test */
    public function itCanHaveAReviewImageCreated(): void
    {
        TestTime::freeze();

        $this->assertEmpty(TemporaryFileUpload::all());

        TemporaryFileUpload::createFromReviewImageUpload($file = UploadedFile::fake()->image('foo.jpg'), 'foo');

        $this->assertNotEmpty(TemporaryFileUpload::all());
        $this->assertCount(1, TemporaryFileUpload::all());

        $fileUpload = TemporaryFileUpload::query()->first();

        $this->assertEquals('wte-review-image', $fileUpload->source);
        $this->assertEquals(Carbon::now()->addMinutes(15)->toDateTimeString(), $fileUpload->delete_at);
    }
}
