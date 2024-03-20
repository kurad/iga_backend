<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable =[
        'unit_title', 
        'key_unit_competence',
        'subject_id'
    ];

    public $timestamps = false;
    
    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}