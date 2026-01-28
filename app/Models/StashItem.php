<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StashItem extends Pivot
{
    protected $table = 'stash_items';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'colorway_yarn_id',
        'quantity',
        'meterage',
        'weight'
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function colorwayYarns() {
        return $this->belongsTo(ColorwayYarn::class);
    }
}
