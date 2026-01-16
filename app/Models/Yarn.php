<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yarn extends Model
{

    protected $fillable = [
        'name',
        'brand',
        'weight',
        'category',
        'image_path',
        'ply',
        'unit_weight',
        'meterage',
        'fiber_types_number',
        'min_hook_size',
        'max_hook_size',
        'min_needle_size',
        'max_needle_size'
    ];

    public function fibers() {
        return $this->belongsToMany(Fiber::class);
    }

    public function colorways() {
        return $this->belongsToMany(Colorway::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class)
        ->using(ProjectYarn::class);
    }

    public function projectYarns() {
        return $this->hasMany(ProjectYarn::class);
    }

    public function yarn_translations() {
        return $this->hasMany(YarnTranslation::class);
    }

    // collego il filato alla sua traduzione per la lingua corrente

    public function translation() {
        return $this->hasOne(YarnTranslation::class)->where('locale', app()->getLocale());
    }

    // funzioni di accesso alle proprietà specifiche delle traduzioni:

    public function getColorTypeAttribute() {
        return $this->translation?->color_type;
    }

    public function getSlugAttribute() {
        return $this->translation?->slug;
    }
}
