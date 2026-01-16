<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FiberYarn extends Pivot
{
    protected $table = 'fiber_yarn';

    public $timestamps = true;

    public function fiber() {
        return $this->belongsTo(Fiber::class);
    }

    public function yarn() {
        return $this->belongsTo(Yarn::class);
    }
}
