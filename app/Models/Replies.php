<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    use HasFactory;


    protected $table = 'Replies';
    protected $fillable = ['category_id', 'sub_category_id', 'topic_id', 'reply_id', 'text', 'creator_id', 'is_deleted', 'deleted_at'];





}
