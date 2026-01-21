<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FiberYarn extends Pivot
{
    // Laravel deduce da FiberYarn come nome del modello 'fiber_yarns' come nome della relativa tabella, per cui è importante che gli specifico il nome corretto

    protected $table = 'fiber_yarn';

    public $timestamps = true;

    public function fiber() {
        return $this->belongsTo(Fiber::class);
    }

    public function yarn() {
        return $this->belongsTo(Yarn::class);
    }
}
