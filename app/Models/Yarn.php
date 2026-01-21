<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yarn extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'brand',
        'weight',
        'category',
        'image_path',
        'ply',
        'unit_weight',
        'meterage',
        'fiber_types_number',
        'min_hook_size',
        'max_hook_size',
        'min_needle_size',
        'max_needle_size'
    ];

    public function fibers() {
        return $this->belongsToMany(Fiber::class)
            ->using(FiberYarn::class)
            ->withPivot(['percentage'])
            ->withTimestamps();
    }

    public function colorways() {
        return $this->belongsToMany(Colorway::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class)
            ->using(ProjectYarn::class)
            ->withPivot([
                'colorway_id',
                'quantity',
                'meterage',
                'weight'
            ])
            ->withTimestamps();
    }

    public function projectYarns() {
        return $this->hasMany(ProjectYarn::class);
    }

    public function fiberYarns() {
        return $this->hasMany(FiberYarn::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)
            ->orWhere($this->getKeyName(), $value)
            ->first();
    }
}
