<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTranslation extends Model
{

    protected $fillable = [
        'locale',
        'name',
        'notes',
        'craft',
        'status',
        'destination_use',
        'slug'
    ];

    public function project() {
        return $this->hasOne(Project::class);
    }
}
