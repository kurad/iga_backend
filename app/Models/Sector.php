<?php

namespace App\Models;

use App\Models\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sector extends Model
{
    use HasFactory;

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}