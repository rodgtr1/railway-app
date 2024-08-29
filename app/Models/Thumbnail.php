<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}