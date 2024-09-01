<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    use HasFactory;
    
    protected $table = 'topics';
    protected $fillable = ['category_id', 'sub_category_id', 'topic_id', 'header', 'text', 'creator_id', 'is_pinned', 'is_deleted', 'deleted_at'];




}
