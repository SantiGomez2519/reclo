<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PexelsImageService
{
    private string $apiUrl;
    private string $apiKey;
    private int $cacheTtl;

    public function __construct()
    {
        $this->apiUrl = config('services.pexels.url');
        $this->apiKey = config('services.pexels.key');
        $this->cacheTtl = config('services.pexels.cache_ttl', 3600);
    }

    public function searchImages(string $query, int $perPage = 5): array
    {
        if (empty($this->apiKey) || empty($this->apiUrl)) {
            Log::warning('Pexels API credentials not configured');
            return [];
        }

        $cacheKey = 'pexels_images_' . md5($query . '_' . $perPage);

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($query, $perPage) {
            try {
                $searchUrl = rtrim($this->apiUrl, '/') . '/search';

                $httpClient = Http::timeout(10)
                    ->withHeaders([
                        'Authorization' => $this->apiKey,
                    ]);

                if (app()->environment('local')) {
                    $httpClient = $httpClient->withoutVerifying();
                }

                $response = $httpClient->get($searchUrl, [
                    'query' => $query,
                    'per_page' => min($perPage, 80),
                    'orientation' => config('services.pexels.orientation', 'portrait'),
                ]);

                if (!$response->successful()) {
                    Log::warning('Pexels API request failed', [
                        'status' => $response->status(),
                        'query' => $query,
                        'response' => $response->body(),
                    ]);
                    return [];
                }

                return $this->extractImageUrls($response->json());
            } catch (\Exception $e) {
                Log::error('Pexels API exception', [
                    'message' => $e->getMessage(),
                    'query' => $query,
                ]);
                return [];
            }
        });
    }

    public function buildSearchQuery(string $title, string $category): string
    {
        $categoryMap = config('services.pexels.category_map', []);
        $categoryTerm = $categoryMap[$category] ?? $category;
        $titleWords = explode(' ', strtolower($title));
        $titleTerm = implode(' ', array_slice($titleWords, 0, 3));

        return trim($categoryTerm . ' ' . $titleTerm);
    }

    private function extractImageUrls(array $data): array
    {
        if (!isset($data['photos']) || empty($data['photos'])) {
            return [];
        }

        $imageUrls = [];
        foreach ($data['photos'] as $photo) {
            if (isset($photo['src']['large'])) {
                $imageUrls[] = $photo['src']['large'];
            }
        }
        return $imageUrls;
    }
}

