<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiberYarn extends Model
{
    protected $table = 'fiber_yarn';

    public function fiber() {
        return $this->belongsTo(Fiber::class);
    }

    public function yarn() {
        return $this->belongsTo(Yarn::class);
    }
}
