<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YarnTranslation extends Model
{
    public function yarn() {
        return $this->belongsTo(Yarn::class);
    }
}
