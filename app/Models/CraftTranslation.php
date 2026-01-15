<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CraftTranslation extends Model
{
    public function craft() {
        return $this->hasOne(Craft::class);
    }
}
