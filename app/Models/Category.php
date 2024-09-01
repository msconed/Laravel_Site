<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'is_deleted', 'deleted_at'];

    protected $table = 'category';

    protected function casts(): array
    {
        return [
            'is_deleted' => 'boolean',
        ];
    }

}
