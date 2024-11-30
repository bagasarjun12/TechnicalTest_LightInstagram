<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    protected $table = 'archives';
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
}
