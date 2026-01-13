<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colorway extends Model
{
    public function yarns() {
        return $this->belongsToMany(Yarn::class);
    }

    public function project_yarn() {
        return $this->hasMany(ProjectYarn::class);
    }
}
