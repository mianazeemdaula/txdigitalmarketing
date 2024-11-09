<?php

namespace App\Services;

class FacebookService
{
    protected $facebook;
    protected $adAccountId = '';

    public function __construct()
    {
        $this->adAccountId = env('FACEBOOK_AD_ACCOUNT_ID');
        $this->facebook = new \Facebook\Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => config('facebook.graph_version'),
            'default_access_token' => env('FACEBOOK_ACCESS_TOKEN'),
        ]);
    }

    public function getKeywordTrends($keyword)
    {
        try {
            $response = $this->facebook->get(
                "/{$this->adAccountId}/insights?fields=ad_name,impressions,spend,clicks,cost_per_action_type&level=ad"
            );
            return $response->getDecodedBody();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getKeywordAudience($keyword)
    {
        try {
            $response = $this->facebook->get(
                "/{$this->adAccountId}/insights?fields=reach,frequency&level=ad&filtering=[{'field':'ad.name','operator':'CONTAIN','value':'$keyword'}]"
            );
            return $response->getDecodedBody();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
