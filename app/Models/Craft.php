<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Craft extends Model
{
    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    public function translations() {
        return $this->hasMany(CraftTranslation::class);
    }

    // collego la tecnica alla sua traduzione per la lingua corrente

    public function translation() {
        return $this->hasOne(CraftTranslation::class)
        ->where('locale', app()->getLocale());
    }

    // funzioni di accesso alle proprietà specifiche delle traduzioni:

    public function getNameAttribute() {
        return $this->translation?->name;
    }

    public function getSlugAttribute() {
        return $this->translation?->slug;
    }
}
