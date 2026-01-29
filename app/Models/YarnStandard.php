<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YarnStandard extends Model
{
    protected $appends = ['label'];
    
    public function yarnStandardSpec() {
        return $this->hasOne(YarnStandardSpec::class);
    }

    public function yarnTypes() {
        return $this->hasMany(YarnType::class);
    }

    public function translations() {
        return $this->hasMany(YarnStandardTranslation::class);
    }

    public function translation() {
        return $this->hasOne(YarnStandardTranslation::class)
        ->where('locale', app()->getLocale());
    }

    public function getLabel() {
        return $this->translation?->label;
    }
}
