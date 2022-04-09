<?php

namespace Tests\Feature\Modules\EatingOut\WhereToEat\Events;

use Coeliac\Common\Models\TemporaryFileUpload;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PrepareWhereToEatReviewImages;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReviewImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Tests\TestCase;

class ProcessWhereToEatReviewImagesTest extends TestCase
{
    protected WhereToEatReview $review;
    protected TemporaryFileUpload $upload;
    protected UploadedFile $file;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('uploads');
        Storage::fake('review-images');

        $eatery = $this->create(WhereToEat::class);

        $this->review = $this->build(WhereToEatReview::class)->on($eatery)->create();
        $this->file = UploadedFile::fake()->image('foo.jpg', 500, 500);
        $this->upload = TemporaryFileUpload::createFromReviewImageUpload(
            $this->file,
            Storage::disk('uploads')->putFile('/', $this->file),
        );
    }

    /** @test */
    public function itCopiesTheImageFromTheUploadsDiskToTheReviewDisk(): void
    {
        Storage::disk('review-images')->assertDirectoryEmpty('/');

        Event::dispatch(new PrepareWhereToEatReviewImages($this->review, [$this->upload->id]));

        $this->assertNotEmpty(Storage::disk('review-images')->allFiles('/'));
        Storage::disk('review-images')->assertExists($this->upload->filename);

        $file = Storage::disk('review-images')->get($this->upload->filename);

        $this->assertSame($file, $this->file->get());
    }

    /** @test */
    public function itCreatesAThumbnailInTheThumbsDirectory(): void
    {
        Storage::disk('review-images')->assertDirectoryEmpty('thumbs');

        Event::dispatch(new PrepareWhereToEatReviewImages($this->review, [$this->upload->id]));

        $this->assertNotEmpty(Storage::disk('review-images')->allFiles('thumbs'));
        Storage::disk('review-images')->assertExists('thumbs/' . $this->upload->filename);
    }

    /** @test */
    public function itCreatesTheThumbnailAtASmallerSize(): void
    {
        Event::dispatch(new PrepareWhereToEatReviewImages($this->review, [$this->upload->id]));

        $thumbnail = app(ImageManager::class)->make(Storage::disk('review-images')->get('thumbs/' . $this->upload->filename));

        $this->assertEquals(250, $thumbnail->width());
    }

    /** @test */
    public function itCreatesAReviewImageRow(): void
    {
        $this->assertEmpty(WhereToEatReviewImage::all());

        Event::dispatch(new PrepareWhereToEatReviewImages($this->review, [$this->upload->id]));

        $this->assertNotEmpty(WhereToEatReviewImage::all());
        $this->assertCount(1, WhereToEatReviewImage::all());
        $this->assertCount(1, $this->review->images);
    }

    /** @test */
    public function itStoresTheImagePathAndThumbnailPathOnTheImageRow(): void
    {
        Event::dispatch(new PrepareWhereToEatReviewImages($this->review, [$this->upload->id]));

        /** @var WhereToEatReviewImage $image */
        $image = $this->review->images()->first();

        $this->assertNotNull($image->thumb);
        $this->assertNotNull($image->path);

        Storage::disk('review-images')->assertExists($image->path);
        Storage::disk('review-images')->assertExists($image->thumb);
    }
}
