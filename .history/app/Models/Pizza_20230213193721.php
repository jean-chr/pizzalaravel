<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'ingredients',
        'imageurl',
        'prix',
        'user_id',
        'description'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
