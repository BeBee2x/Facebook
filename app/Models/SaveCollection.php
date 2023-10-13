<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveCollection extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','collection_name','collection_image'];
}
