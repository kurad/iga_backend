<?php

namespace App\Models;

use App\Models\User;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $fillable =['name','type','sector_id'];

    public $timestamps = false;
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Sector::class);
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }
}