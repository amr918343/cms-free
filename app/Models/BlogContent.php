<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class BlogContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'title',
        'desc',
        'img',
        'alt_img',
        'order'
    ];

    public $translatable = [
        'title',
        'desc',
        'alt_img'
    ];

    public function blog() : BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function getImgUrlAttribute() : string
    {
        return $this->img ? asset('storage/' . $this->img) : '';
    }

    public function getShortContentAttribute() : string
    {
        return substr($this->content, 0, 100);
    }

    public function getShortContentWithDotsAttribute() : string
    {
        return $this->short_content . '...';
    }



}
