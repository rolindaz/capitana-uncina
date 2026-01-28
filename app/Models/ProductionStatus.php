<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionStatus extends Model
{
    protected $appends = [
        'label'
    ];

    public function translations() {
        return $this->hasMany(ProductionStatusTranslation::class);
    }

    public function translation() {
        return $this->hasOne(ProductionStatusTranslation::class)
        ->where('locale', app()->getLocale());
    }

    public function getLabelAttribute() {
        return $this->translation?->label;
    }
}
