<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atribut extends Model
{
    use HasFactory;
    protected $table = 'atributs';
    protected $primaryKey = 'id_atributs';
    protected $fillable = [
        'id_reels',
        'id_users',
        'type',
        'desc',
    ];

    public function reel()
    {
        return $this->belongsTo(Reel::class, 'id_reels');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}