<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YarnType extends Model
{
    public function yarnStandard() {
        return $this->hasOne(YarnStandard::class);
    }

    public function yarns() {
        return $this->hasMany(Yarn::class);
    }
}
