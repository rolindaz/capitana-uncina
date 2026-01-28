<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ColorwayYarn extends Pivot
{
    protected $table = 'colorway_yarn';

    public $timestamps = true;

    public function yarns() {
        return $this->BelongsTo(Yarn::class);
    }

    public function colorways() {
        return $this->BelongsTo(Colorway::class);
    }

    public function productionStatuses() {
        return $this->BelongsTo(ProductionStatus::class);
    }

}
