<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FBAds extends Model
{

    protected $fillable = [
        'term_trend_id',
        'ad_creation_time',
        'ad_creative_bodies',
        'ad_creative_link_captions',
        'ad_creative_link_descriptions',
        'ad_creative_link_titles',
        'ad_delivery_start_time',
        'ad_delivery_stop_time',
        'ad_snapshot_url',
        'ad_id',
        'ad_impressions',
        'ad_spend',
        'page_id',
        'page_name',
    ];

    protected $casts = [
        'ad_creative_bodies' => 'array',
        'ad_creative_link_captions' => 'array',
        'ad_creative_link_descriptions' => 'array',
        'ad_creative_link_titles' => 'array',
    ];
}
