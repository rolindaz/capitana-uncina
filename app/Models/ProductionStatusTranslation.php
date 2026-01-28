<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionStatusTranslation extends Model
{
    public function productionStatus() {
        return $this->hasOne(ProductionStatus::class);
    }
}
