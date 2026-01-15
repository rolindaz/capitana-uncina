<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorwayTranslation extends Model
{
    public function colorway() {
        return $this->hasOne(Colorway::class);
    }
}
