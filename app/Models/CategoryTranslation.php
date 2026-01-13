<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public function category() {
        return $this->hasOne(Category::class);
    }
}
