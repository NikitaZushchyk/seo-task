<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchSerpRequest;
use Illuminate\Support\Facades\Http;

class SerpController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function search(SearchSerpRequest $request)
    {
        $validated = $request->validated();
        $targetDomain = strtolower($validated['domain']);

        $payload = [[
            "keyword" => $validated['keyword'],
            "location_code" => (int) $validated['location_code'],
            "language_code" => $validated['language_code']
        ]];
        $response = Http::withBasicAuth(config('services.dataforseo.login'), config('services.dataforseo.password'))
            ->post('https://api.dataforseo.com/v3/serp/google/organic/live/regular', $payload);

        if ($response->failed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'DataForSEO API Error: ' . $response->status()
            ], 500);
        }

        $data = $response->json();

        $items = $data['tasks'][0]['result'][0]['items'] ?? null;

        if (!$items) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API response or no search results found.'
            ], 400);
        }

        foreach ($items as $item) {
            if (isset($item['type']) && $item['type'] === 'organic' && isset($item['domain'])) {
                if (str_contains(strtolower($item['domain']), $targetDomain)) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Site found',
                        'data' => [
                            'rank' => $item['rank_group'],
                            'absolute_rank' => $item['rank_absolute'],
                            'url' => $item['url'],
                            'title' => $item['title']
                        ]
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 'not_found',
            'message' => "The site <b>{$targetDomain}</b> was not found in the Top 100 organic results for this query."
        ]);
    }
}
