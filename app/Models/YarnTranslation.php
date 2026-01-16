<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YarnTranslation extends Model
{

    protected $fillable = [
        'locale',
        'color_type',
        'slug'
    ];

    public function yarn() {
        return $this->belongsTo(Yarn::class);
    }
}
