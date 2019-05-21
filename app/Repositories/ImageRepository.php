<?php

namespace App\Repositories;

use App\Image;

class ImageRepository
{
    protected $repo;

    public function __construct(Image $repo)
    {
        $this->repo = $repo;
    }

    public function remove($id)
    {
        $image = $this->repo->find($id);
        $paths = [
            $image->actual,
            $image->large,
            $image->medium,
            $image->small,
            $image->tiny,
        ];
        foreach ($paths as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $image->delete();
    }
}
