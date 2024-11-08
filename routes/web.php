<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Arr;


Route::get('/', function () {
    return view('welcome');
});

Route::group([], function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
    
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::resource('terms', 'App\Http\Controllers\User\TermController');
    });
});

Route::get('/fbgraphql', [AuthController::class,'graphQL']);
Route::get('/facebook/redirect', [AuthController::class,'facebookRedirect']);
Route::get('/facebook/callback', [AuthController::class,'facebookCallback']);
Route::get('fbsearch', [AuthController::class,'searchTrend']);

Route::get('/test', function(){
    
    // return \App\Models\TermTrend::all();
    $term = \App\Models\TermTrend::find(3);
    if(!$term){
        $term = \App\Models\TermTrend::create([
                'terms' => ['Soap'],
                'countries' => ['PK'],
                'impressions' => 1000,
                'start_date' => now()->subDays(10),
                'end_date' => now()->subDays(1),
            ]);
    }
    // return "['".implode("','",$term->countries)."']";
    \App\Jobs\FetchFacebookAdsLibrary::dispatch($term, $term->next_page_cursor);
});


Route::get('/terms/{id}', function($id){
    $term =  \App\Models\TermTrend::findOrFail($id);
    $flattenedSites = Arr::flatten($term->fbAds()->select('ad_creative_link_captions')->distinct()->whereNotNull('ad_creative_link_captions')->get()->pluck('ad_creative_link_captions'));
    return [
        'total_ads' => $term->fbAds()->count(),
        'pages' => $term->fbAds()->select('page_name')->distinct()->get()->pluck('page_name'),
        'links' => array_count_values($flattenedSites),
    ];
});
