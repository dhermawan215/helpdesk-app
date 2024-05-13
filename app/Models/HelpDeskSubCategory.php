<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpDeskSubCategory extends Model
{
    use HasFactory;

    protected $table = 'help_desk_sub_categories';

    protected $fillable = ['category_id', 'sub_category_name', 'created_by'];
}
