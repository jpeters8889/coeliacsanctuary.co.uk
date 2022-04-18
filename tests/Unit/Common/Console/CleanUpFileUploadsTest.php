<?php

namespace Tests\Unit\Common\Console;

use Coeliac\Common\Models\TemporaryFileUpload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class CleanUpFileUploadsTest extends TestCase
{
    protected TemporaryFileUpload $upload;

    protected UploadedFile $file;

    protected function setUp(): void
    {
        parent::setUp();

        TestTime::freeze();
        Storage::fake('uploads');

        $this->file = UploadedFile::fake()->image('foo.jpg');

        Storage::disk('uploads')->putFile('/', $this->file);

        $this->upload = TemporaryFileUpload::createFrom($this->file, '/' . $this->file->hashName());
    }

    /** @test */
    public function itDoesntDeleteUploadsBeforeTheDeletedAtTimestamp(): void
    {
        $this->artisan('coeliac:clean_file_uploads');

        $this->assertModelExists($this->upload);
        Storage::disk('uploads')->assertExists($this->upload->path);
    }

    /** @test */
    public function itDeletesFilesWhenTheDeletedAtTimestampHasPassed(): void
    {
        TestTime::addDay()->addHour();

        $this->assertNotEmpty(Storage::disk('uploads')->allFiles('/'));

        $this->artisan('coeliac:clean_file_uploads');

        Storage::disk('uploads')->assertDirectoryEmpty('/');
    }

    /** @test */
    public function itDeletedTheTemporaryFileUploadRowWhenTheFileIsDeleted(): void
    {
        TestTime::addDay()->addHour();

        $this->assertNotEmpty(TemporaryFileUpload::all());

        $this->artisan('coeliac:clean_file_uploads');

        $this->assertEmpty(TemporaryFileUpload::all());
    }
}
