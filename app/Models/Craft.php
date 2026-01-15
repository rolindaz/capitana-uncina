<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Craft extends Model
{
    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    public function translations() {
        return $this->hasMany(CraftTranslation::class);
    }
}
