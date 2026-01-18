<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function category_translations() {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // collego la categoria alla sua traduzione per la lingua corrente

    public function translation() {
        return $this->hasOne(CategoryTranslation::class)->where('locale', app()->getLocale());
    }

    // funzioni di accesso alle proprietà specifiche delle traduzioni:

    public function getNameAttribute() {
        return $this->translation?->name;
    }

    public function getSlugAttribute() {
        return $this->translation?->slug;
    }

    public function ancestorsAndSelf() {
        $nodes = collect();

        $current = $this;
        while ($current) {
            $nodes->prepend($current);
            if (empty($current->parent_id)) {
                break;
            }

            $current->loadMissing('parent.translation');
            $current = $current->parent;
        }

        return $nodes;
    }

    public function getBreadcrumbAttribute() {
        return $this->ancestorsAndSelf()
            ->map(function ($category) {
                return $category->name
                    ?? (isset($category->key) ? Str::of($category->key)->replace('_', ' ')->headline()->toString() : null);
            })
            ->filter()
            ->values()
            ->join(' -> ');
    }
}
