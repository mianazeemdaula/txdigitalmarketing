<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermTrend extends Model
{
    protected $fillable = ['terms', 'countries', 'impressions', 'start_date', 'end_date', 'is_active', 'next_page_cursor', 'app'];

    protected $casts = [
        'is_active' => 'boolean',
        'terms' => 'array',
        'countries' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFacebook($query)
    {
        return $query->where('app', 'facebook');
    }

    public function fbAds()
    {
        return $this->hasMany(FBAds::class);
    }
}
