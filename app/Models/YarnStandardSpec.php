<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YarnStandardSpec extends Model
{
    public function yarnStandard() {
        return $this->hasOne(YarnStandard::class);
    }
}
