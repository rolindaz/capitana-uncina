<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yarn extends Model
{
    public function fibers() {
        return $this->belongsToMany(Fiber::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    public function yarn_translations() {
        return $this->hasMany(YarnTranslation::class);
    }
}
