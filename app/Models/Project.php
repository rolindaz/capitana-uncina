<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function yarns() {
        return $this->belongsToMany(Yarn::class);
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function project_translations() {
        return $this->hasMany(ProjectTranslation::class);
    }
}
