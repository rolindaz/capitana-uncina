<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function category_translations() {
        return $this->hasMany(CategoryTranslation::class);
    }

    // collego la categoria alla sua traduzione per la lingua corrente

    public function translation() {
        return $this->hasOne(CategoryTranslation::class)->where('locale', app()->getLocale());
    }

    // funzioni di accesso alle proprietà specifiche delle traduzioni:

    public function getNameAttribute() {
        return $this->translation?->name;
    }

    public function getSlugAttribute() {
        return $this->translation?->slug;
    }
}
