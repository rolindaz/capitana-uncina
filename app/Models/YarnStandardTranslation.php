<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YarnStandardTranslation extends Model
{
    public function yarnStandard() {
        return $this->hasOne(YarnStandard::class);
    }
}
