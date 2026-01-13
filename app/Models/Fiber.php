<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fiber extends Model
{
    public function yarns() {
        return $this->belongsToMany(Yarn::class);
    }

    public function fiber_translations() {
        return $this->hasMany(FiberTranslation::class);
    }
}
