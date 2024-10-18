<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jogo extends Model
{
    use HasFactory, SoftDeletes, HasTimestamps;

    protected $table = 'jogos';

    protected $fillable = [
        'palavra_chave',
        'letras-corretas',
        'user_id',
    ];



}
