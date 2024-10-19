<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes, HasTimestamps;

    protected $table = 'games';

    protected $fillable = [
        'theme',
        'keyword',
        'correct_letters',
        'user_id',
    ];



}
