<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ColorwayYarn extends Pivot
{
    protected $table = 'colorway_yarn';

    public $timestamps = true;

    public function yarns() {
        return $this->BelongsToMany(Yarn::class);
    }

    public function colorways() {
        return $this->BelongsToMany(Colorway::class);
    }
}
