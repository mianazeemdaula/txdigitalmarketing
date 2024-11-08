<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function graphQL()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => config('facebook.graph_version'),
            'config_id' => '1945834042584711',
            'default_access_token' => env('FACEBOOK_ACCESS_TOKEN'),
        ]);

        $response = $fb->get("/ads_archive?ad_delivery_date_max=2024-11-05&ad_delivery_date_min=2024-10-07&search_terms='Perfume'&ad_reached_countries=['PK']&fields=ad_creation_time,ad_creative_bodies,ad_creative_link_captions,ad_creative_link_descriptions,ad_creative_link_titles,ad_delivery_start_time,ad_delivery_stop_time,ad_snapshot_url,ad_id,ad_impressions,ad_spend,page_id,page_name");

        // create a job to handle the data and save it to the database with pagination
        

        // go for all the data with pagination
        $data = $response->getGraphEdge();
        $allData = $data->asArray();
        dd($data);
        // while ($data = $fb->next($data)) {
        //     $allData = array_merge($allData, $data->asArray());
        // }

        // dd(count($allData));

    }

    public function facebookRedirect()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => config('facebook.graph_version'),
            'config_id' => '1945834042584711',
            'default_access_token' => env('FACEBOOK_ACCESS_TOKEN'),
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(config('facebook.redirect_uri'), $permissions);

        return redirect()->away($loginUrl);
    }

    public function facebookCallback(Request $request)
    {
        $fb = new \Facebook\Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => config('facebook.graph_version'),
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            dd('Graph returned an error: ' . $e->getMessage());
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            dd('Facebook SDK returned an error: ' . $e->getMessage());
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                dd("Error: " . $helper->getError() . "\n");
                dd("Error Code: " . $helper->getErrorCode() . "\n");
                dd("Error Reason: " . $helper->getErrorReason() . "\n");
                dd("Error Description: " . $helper->getErrorDescription() . "\n");
            } else {
                header('HTTP/1.0 400 Bad Request');
                dd('Bad request');
            }
        }

        // Logged in
        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId(config('facebook.app_id'));
        // If you know the user ID this access token belongs to, you can validate it here
        // $tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                dd($accessToken->getValue());
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                dd("Error getting long-lived access token: " . $helper->getMessage());
            }

        }
    }

    public function searchTrend(){
         $fb = new \Facebook\Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => config('facebook.graph_version'),
            'default_access_token' => env('FACEBOOK_ACCESS_TOKEN'),
        ]);
        $keyword = "Perfume";
        $response = $fb->get("/search?type=adinterest&q=${keyword}");
        $data = $response->getGraphEdge();
        $rows = $data->asArray();
        $collection = [];
        foreach($rows as $row){
            $res2 =  $fb->get('/act_1081928960003927/delivery_estimate?targeting_spec='.json_encode([
                'geo_locations' => ['countries' => ['PK']],
                'interests' => [$row['id']],
            ]). '&optimization_goal=REACH');
            $data2 = $res2->getGraphEdge();
            $collection[] = [
                'name' => $row['name'],
                'audience_size' => $data2->asArray()
            ];
        }
        dd($collection);

        // create a job to handle the data and save it to the database with pagination
        
        // go for all the data with pagination
        $data = $response->getGraphEdge();
        $rows = $data->asArray();
        return view('user.trends.index', compact('rows'));
    }
}
