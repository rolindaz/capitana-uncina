<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectYarn extends Pivot
{
    protected $table = 'project_yarn';
    
    public $timestamps = true;

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function yarn() {
        return $this->belongsTo(Yarn::class);
    }

    public function colorway() {
        return $this->belongsTo(Colorway::class);
    }
}
