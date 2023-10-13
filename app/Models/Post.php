<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','caption','image','like','share','type','shared_user_id','shared_post_id','shared_caption','video','group_id'];
}
