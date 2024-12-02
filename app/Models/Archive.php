<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    protected $table = 'archives';
    protected $primaryKey = 'id_archives';
    protected $casts = [
        'upload_date' => 'datetime', 
    ];
    protected $fillable = [
        'id_users',
        'id_images',
        'caption',
        'upload_date',
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
