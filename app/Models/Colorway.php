<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colorway extends Model
{
    public function yarns() {
        return $this->belongsToMany(Yarn::class);
    }
}
