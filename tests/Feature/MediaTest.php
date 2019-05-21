<?php

namespace Tests\Feature;

use App\Media;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    public function testGetFile()
    {
        $filename = UploadedFile::fake()->image('file.png')->store('/');
        $media = factory(Media::class)->create([
            'filename' => $filename,
            'original_filename' => 'file.png',
        ]);

        $this->get("/media/{$filename}")
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'image/png')
            ->assertHeader('Content-Disposition', "filename='file.png'");

        Storage::delete($filename);
    }
}
