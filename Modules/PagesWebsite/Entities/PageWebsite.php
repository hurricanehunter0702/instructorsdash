<?php
namespace Modules\PagesWebsite\Entities;

use Illuminate\Database\Eloquent\Model;

class PageWebsite extends Model
{

    protected $fillable = [
        'title',
        'description',
        'slug',
        'is_active',
        'is_shown_on_header'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
