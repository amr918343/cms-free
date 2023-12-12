<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'desc',
        'img',
        'alt_img'
    ];

    public function getImgUrlAttribute() : string
    {
        return $this->img ? asset('storage/' . $this->img) : '';
    }


}
