<?php

declare(strict_types=1);

namespace Tests\Architect;

use Tests\TestCase;
use Coeliac\Common\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JPeters\Architect\TestHelpers\Traits\LogsInUsers;

class ImageManagerApiCallTest extends TestCase
{
    use RefreshDatabase;
    use LogsInUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logIn(factory(User::class)->create(['email' => 'jamie@jamie-peters.co.uk']));
    }

    /** @test */
    public function itUploadsAnImage()
    {
        $image = UploadedFile::fake()->image('_test_image.png');

        $request = $this->post('/cs-adm/api/external/image-manager/upload', [
            'files' => [$image],
        ]);

        $request->assertStatus(200)
            ->assertJsonStructure([
                ['path', 'filename', 'width', 'height'],
            ])
            ->assertJsonFragment(['path' => 'cs-adm-uploads/_test_image.png'])
            ->assertJsonFragment(['filename' => '_test_image.png']);
    }
}
