<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    public function attribute_translations() {
        return $this->hasMany(AttributeTranslation::class);
    }
}
