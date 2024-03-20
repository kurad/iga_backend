<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function combination()
    {
        return $this->hasMany(Combination::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}