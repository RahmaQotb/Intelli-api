<?php

namespace App\Services;

use GuzzleHttp\Client;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Illuminate\Support\Facades\Log;

class RecommendationService
{
    protected $apiConfig;
    protected $productData = [];

    public function __construct()
    {
        $this->apiConfig = [
            'getAllProducts' => env('API_PRODUCTS_URL', 'http://127.0.0.1:8000/api/products'),
            'getAllCategories' => env('API_CATEGORIES_URL', 'http://127.0.0.1:8000/api/categories/get-categories'),
        ];
    }

    public function loadData()
    {
        $client = new Client(['verify' => false]); // TODO: Enable SSL in production
        try {
            $products = json_decode($client->get($this->apiConfig['getAllProducts'])->getBody(), true);
            $categories = json_decode($client->get($this->apiConfig['getAllCategories'])->getBody(), true);
            Log::info('Fetched products:', $products);
            Log::info('Fetched categories:', $categories);
        } catch (\Exception $e) {
            Log::error('API fetch failed: ' . $e->getMessage());
            return [];
        }

        $categoryMap = [];
        foreach ($categories['data'] ?? [] as $cat) {
            $categoryMap[$cat['id']] = $cat['name'];
        }

        $this->productData = array_map(function ($product) use ($categoryMap) {
            return [
                'id' => $product['id'],
                'name' => $product['name'] ?? '',
                'description' => $product['description'] ?? '',
                'category' => $categoryMap[$product['category_id']] ?? 'Unknown',
                'brand' => $product['brand']['name'] ?? '',
                'features' => json_encode($product['features'] ?? []),
            ];
        }, $products['data'] ?? []);

        return $this->productData;
    }

    public function recommendBySearch($query, $n = 5)
    {
        $this->loadData();

        $documents = array_map(function ($item) {
            return $item['name'] . ' ' . $item['description'] . ' ' . $item['category'] . ' ' . $item['brand'] . ' ' . $item['features'];
        }, $this->productData);

        $queryDoc = array_merge($documents, [$query]);
        $vectorizer = new TfIdfTransformer();
        $vectorizer->fit($queryDoc);
        $vectorizer->transform($queryDoc);

        $queryVector = array_pop($queryDoc);
        $scores = [];

        foreach ($queryDoc as $index => $docVector) {
            $scores[$index] = 1 - $this->cosineSimilarity($queryVector, $docVector);
        }

        asort($scores);
        $topIndices = array_keys(array_slice($scores, 0, $n, true));

        return array_map(fn($i) => $this->productData[$i], $topIndices);
    }

    private function cosineSimilarity($vec1,$vec2)
    {
        $dot = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        foreach ($vec1 as $i => $v) {
            $dot += $v * ($vec2[$i] ?? 0);
            $normA += $v * $v;
        }

        foreach ($vec2 as $v) {
            $normB += $v * $v;
        }

        return ($normA && $normB) ? $dot / (sqrt($normA) * sqrt($normB)) : 0;
    }
}