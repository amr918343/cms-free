<?php

namespace App\Observers;

use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BlogObserver
{
    public function saving(Blog $blog) {
        $oldImg = 'app/public/' . $blog->getOriginal('img');
        $oldImgPath = storage_path($oldImg);
        if(file_exists($oldImgPath)) {
            // File::delete($oldImgPath);
        }
        // dd(file_exists($oldImgPath), $oldImgPath);
    }

    public function forceDeleting(Blog $blog) {
        $oldImg = 'app/public/' . $blog->getOriginal('img');
        $oldImgPath = storage_path($oldImg);
        if(file_exists($oldImgPath)) {
            File::delete($oldImgPath);
        }
    }
}
