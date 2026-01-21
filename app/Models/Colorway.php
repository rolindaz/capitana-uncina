<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colorway extends Model
{

    protected $appends = [
        'name',
        'slug'
    ];

    public function yarns() {
        return $this->belongsToMany(Yarn::class);
    }

    public function project_yarn() {
        return $this->hasMany(ProjectYarn::class);
    }

    // collego il colore alla sua traduzione per la lingua corrente

    public function translation() {
        return $this->hasOne(ColorwayTranslation::class)->where('locale', app()->getLocale());
    }

    // funzioni di accesso alle proprietà specifiche delle traduzioni:

    public function getNameAttribute() {
        return $this->translation?->name;
    }

    public function getSlugAttribute() {
        return $this->translation?->slug;
    }
}
