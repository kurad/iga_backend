<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable =[
        'topic_title',
        'instructional_objectives',
        'topic_content',
        'unit_id',
        'video_link'
    ];

    public function units()
    {
        return $this->belongsTo(Unit::class);
    }

    public function resource()
    {
        return $this->hasMany(TopicResource::class);
    }
}