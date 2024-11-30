<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    use HasFactory;
    
    protected $table = 'reels';
    protected $primaryKey = 'id_reels';
    protected $fillable = [
        'id_users',
        'id_images',
        'caption',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'id_images');
    }

    public function likesCount()
    {
        return $this->hasMany(Atribut::class, 'id_reels')->where('type', 'like')->count();
    }
}