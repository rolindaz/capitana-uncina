<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    public function tag_translations() {
        return $this->hasMany(TagTranslation::class);
    }
}
