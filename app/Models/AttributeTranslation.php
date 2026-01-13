<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeTranslation extends Model
{
    public function attribute() {
        return $this->hasOne(Attribute::class);
    }
}
