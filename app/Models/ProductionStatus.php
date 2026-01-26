<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionStatus extends Model
{
    public function translations() {
        return $this->hasMany(ProductionStatusTranslation::class);
    }

    public function translation() {
        return $this->hasOne(ProductionStatusTranslation::class);
    }
}
