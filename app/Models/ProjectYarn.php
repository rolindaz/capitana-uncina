<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectYarn extends Model
{
    protected $table = 'project_yarn';

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
