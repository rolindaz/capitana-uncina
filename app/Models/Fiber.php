<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fiber extends Model
{

    protected $appends = [
        'name',
        'slug'
    ];

    public function yarns() {
        return $this->belongsToMany(Yarn::class)
        ->using(FiberYarn::class)
        ->withPivot('percentage')
        ->withTimestamps();
    }

    public function fiber_translations() {
        return $this->hasMany(FiberTranslation::class);
    }

    // collego la fibra alla sua traduzione per la lingua corrente

    public function translation() {
        return $this->hasOne(FiberTranslation::class)->where('locale', app()->getLocale());
    }

    // funzioni di accesso alle proprietà specifiche delle traduzioni:

    public function getNameAttribute() {
        return $this->translation?->name;
    }

    public function getSlugAttribute() {
        return $this->translation?->slug;
    }
}
