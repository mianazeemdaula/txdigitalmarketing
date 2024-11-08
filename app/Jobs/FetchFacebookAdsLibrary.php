<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Models\TermTrend;
use Carbon\Carbon;

class FetchFacebookAdsLibrary implements ShouldQueue
{
    use Queueable, Dispatchable;

    private TermTrend $termTrend;
    private $nextPageCursor;
    /**
     * Create a new job instance.
     */
    public function __construct($termTrend, $next)
    {
        $this->termTrend = $termTrend;
        $this->nextPageCursor = $next;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fb = new \Facebook\Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => config('facebook.graph_version'),
            'default_access_token' => env('FACEBOOK_ACCESS_TOKEN'),
        ]);
        try {
            // terms =  String of terms with AND operator from the array
            $terms  = implode(" AND ",$this->termTrend->terms);
            $countries = "['".implode("','",$this->termTrend->countries)."']";
            $start = Carbon::parse($this->termTrend->start_date)->format('Y-m-d');
            $end = Carbon::parse($this->termTrend->end_date)->format('Y-m-d');
            $endPoint = "/ads_archive?ad_delivery_date_max=${end}&ad_delivery_date_min=${start}&search_terms='{$terms}'&ad_reached_countries={$countries}&fields=ad_creation_time,ad_creative_bodies,ad_creative_link_captions,ad_creative_link_descriptions,ad_creative_link_titles,ad_delivery_start_time,ad_delivery_stop_time,ad_snapshot_url,ad_id,ad_impressions,ad_spend,page_id,page_name";
            if($this->nextPageCursor){
                $endPoint .= "&after={$this->nextPageCursor}";
            }
            $response = $fb->get($endPoint);
            $rows = $response->getGraphEdge();
            foreach($rows as $row){
                // save the data to the database
                $data = $row->asArray();
                $data['term_trend_id'] = $this->termTrend->id;
                $data['ad_id'] = $data['id'] ?? null;
                if(\App\Models\FBAds::where('ad_id', $data['ad_id'])->exists()){
                    continue;
                }
                \App\Models\FBAds::create($data);
            }
            $nextPageCursor = $rows->getMetaData()['paging']['cursors']['after'] ?? null;
            // save the next page cursor to the database
            $this->termTrend->next_page_cursor = $nextPageCursor;
            $this->termTrend->save();
            // dispatch the job again
            if($nextPageCursor){
                self::dispatch($this->termTrend, $nextPageCursor)->delay(now()->addSeconds(20));
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }
}
