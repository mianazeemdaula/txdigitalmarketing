<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FacebookService;

class FacebookAdsController extends Controller
{
    protected $fb;

    public function __construct(FacebookService $facebookService)
    {
        $this->fb = $facebookService;
    }

    public function getKeywordData(Request $request)
    {
        $keyword = $request->input('keyword');
        // Fetch keyword trends
        $trendData = $this->fb->getKeywordTrends($keyword);
        // Fetch keyword audience
        $audienceData = $this->fb->getKeywordAudience($keyword);
        return response()->json([
            'trendData' => $trendData,
            'audienceData' => $audienceData,
        ]);
    }
}
