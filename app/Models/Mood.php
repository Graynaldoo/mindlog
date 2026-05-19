<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'emoji', 'color', 'score'];

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
