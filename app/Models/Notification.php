<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'from_user_id',
        'to_user_id',
        'status',
        'post_id',
        'group_id',
        'group_image',
        'group_name',
        'comment_id',
        'reply_comment_id',
        'story_id'
    ];

}
