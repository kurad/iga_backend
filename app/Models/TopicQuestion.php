<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TopicQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'topic_id',
        'question',
        'user_id'
    ];
}