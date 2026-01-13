<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiberTranslation extends Model
{
    public function fiber() {
        return $this->hasOne(Fiber::class);
    }
}
