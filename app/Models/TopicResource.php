<?php

namespace App\Models;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicResource extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillables = [
        'topic_id',
        'video_link',
        'file_name',
        'file_path'
    ];

    public function topics()
    {
        return $this->belongsTo(Topic::class);
    }
}