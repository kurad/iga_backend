<?php

namespace App\Models;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;
    protected $fillable = ['name','level_id'];

    public function levels()
    {
        return $this->belongsTo(Level::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}