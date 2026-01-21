<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /* // Salvo le date di inizio e completamento come istanze Carbon, non stringhe

    protected $casts = [
        'started' => 'datetime',
        'completed' => 'datetime',
    ]; */

    // Implemento uno strato di salvaguardia per l'assegnazione di massa di valori alle colonne della tabella nel db - intesa cioè come effettuata attraverso create(), update() o fill() - l'assegnazione manuale funziona comunque!
    protected $fillable = [
        'designer_name',
        'pattern_name',
        'pattern_url',
        'category_id',
        'image_path',
        'started',
        'completed',
        'execution_time',
        'size',
        'correct'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function yarns() {
        return $this->belongsToMany(Yarn::class)
            ->withPivot(['colorway_id', 'quantity']);
    }

    public function crafts() {
        return $this->belongsToMany(Craft::class);
    }

    public function projectYarns() {
        return $this->hasMany(ProjectYarn::class);
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function project_translations() {
        return $this->hasMany(ProjectTranslation::class);
    }

    // funzione che collega il progetto alla traduzione per la lingua corrente

    public function translation() {
        return $this->hasOne(ProjectTranslation::class)->where('locale', app()->getLocale());
    }

    // funzioni di accesso alle proprietà di Project translation:

    public function getNameAttribute() {
        return $this->translation?->name;
    }

    public function getNotesAttribute() {
        return $this->translation?->notes;
    }

    public function getStatusAttribute() {
        return $this->translation?->status;
    }

    public function getDestinationUseAttribute() {
        return $this->translation?->destination_use;
    }

    public function getSlugAttribute() {
        return $this->translation?->slug;
    }

    public function getRouteKey()
    {
        return $this->slug ?? $this->getKey();
    }
}
