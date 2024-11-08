<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = \App\Models\TermTrend::latest()->paginate();
        return view('user.terms.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = [
            'US' => 'United States',
            'PK' => 'Pakistan',
        ];
        return view('user.terms.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'term' => 'required',
            'country' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        $term = new \App\Models\TermTrend;
        $term->terms = [$request->term];
        $term->countries = [$request->country];
        $term->start_date = $request->start_date;
        $term->end_date = $request->end_date;
        $term->impressions = 1000;
        $term->save();
        \App\Jobs\FetchFacebookAdsLibrary::dispatch($term, $term->next_page_cursor);
        return redirect()->route('user.terms.index')->with('success', 'Term added to queue successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $term =  \App\Models\TermTrend::findOrFail($id);
        $flattenedSites = Arr::flatten($term->fbAds()->select('ad_creative_link_captions')->distinct()->whereNotNull('ad_creative_link_captions')->get()->pluck('ad_creative_link_captions'));
        $data =  [
            'total_ads' => $term->fbAds()->count(),
            'pages' => $term->fbAds()->select('page_name')->distinct()->get()->pluck('page_name'),
            'links' => array_count_values($flattenedSites),
        ];
        return view('user.terms.show', compact('term', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
