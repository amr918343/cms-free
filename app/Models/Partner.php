<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = [
        'link',
        'alt_img',
        'img'
    ];

    public function getImgUrlAttribute() : string
    {
        return $this->img ? asset('storage/' . $this->img) : '';
    }
}
