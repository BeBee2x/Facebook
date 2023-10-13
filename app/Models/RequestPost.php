<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPost extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','caption','image','type','group_id'];
}
