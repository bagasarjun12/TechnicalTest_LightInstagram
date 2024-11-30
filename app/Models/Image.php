<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $fillable = [
        'file',
    ];

    public function reels()
    {
        return $this->hasMany(Reel::class, 'id_images');
    }

    public function archives()
    {
        return $this->hasMany(Archive::class, 'id_images');
    }
}
