<?php

namespace App\Models;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'level_id',
        'user_id'
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}