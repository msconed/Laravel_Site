<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    
    protected $table = 'SubCategory';
    
    protected $fillable = ['category_id', 'sub_category_id',  'name', 'description', 'is_deleted', 'deleted_at'];

    protected function casts(): array
    {
        return [
            'is_deleted' => 'boolean',
        ];
    }


}
