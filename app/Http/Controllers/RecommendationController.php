<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RecommendationController extends Controller
{
    protected $products;
    protected $categories;
    protected $tfidf = [];

    public function __construct()
    {
        $this->loadData();
    }

    private function loadData()
    {
        $this->categories = Cache::remember('categories', 3600, function () {
            try {
                $res = Http::timeout(10)->get(env('API_CATEGORIES_URL', 'http://127.0.0.1:8000/api/categories/get-categories'));
                if ($res->successful()) {
                    return collect($res['data'])->pluck('name', 'id');
                }
                Log::warning('Categories API returned non-200 status: ' . $res->status());
                return collect([]);
            } catch (\Illuminate\Http\Client\RequestException $e) {
                Log::error('Failed to fetch categories: ' . $e->getMessage());
                return collect([]);
            }
        });
    
        $this->products = Cache::remember('products', 3600, function () {
            $categories = $this->categories;
            try {
                $res = Http::timeout(10)->get(env('API_PRODUCTS_URL', 'http://127.0.0.1:8000/api/products'));
                if ($res->successful()) {
                    return collect($res['data'])->map(function ($item) use ($categories) {
                        $item['category'] = $categories[$item['category_id']] ?? 'Uncategorized';
                        $item['content'] = Str::lower(
                            ($item['name'] ?? '') . ' ' .
                            ($item['description'] ?? '') . ' ' .
                            ($item['brand']['name'] ?? '') . ' ' .
                            ($item['category'] ?? '') . ' ' .
                            json_encode($item['features'] ?? [])
                        );
                        return $item;
                    });
                }
                Log::warning('Products API returned non-200 status: ' . $res->status());
                return collect([]);
            } catch (\Illuminate\Http\Client\RequestException $e) {
                Log::error('Failed to fetch products: ' . $e->getMessage());
                return collect([]);
            }
        });
    
        $this->buildTfidf();
    }

    private function buildTfidf()
    {
        $allWords = collect();
        $documents = [];

        foreach ($this->products as $product) {
            if (empty($product['content'])) {
                $documents[] = collect([]);
                continue;
            }
            $words = collect(str_word_count($product['content'], 1));
            $documents[] = $words;
            $allWords = $allWords->merge($words);
        }

        $vocabulary = $allWords->unique()->values();

        foreach ($documents as $docIndex => $words) {
            foreach ($vocabulary as $word) {
                $tf = $words->filter(fn($wenco) => $wenco === $word)->count() / max(count($words), 1);
                $df = collect($documents)->filter(fn($doc) => $doc->contains($word))->count();
                $idf = log(max(count($documents) / ($df ?: 1), 1));
                $this->tfidf[$docIndex][$word] = $tf * $idf;
            }
        }
    }

    private function cosineSimilarity($vec1, $vec2)
    {
        $dot = 0;
        $mag1 = 0;
        $mag2 = 0;

        foreach ($vec1 as $k => $v) {
            $dot += $v * ($vec2[$k] ?? 0);
            $mag1 += $v * $v;
        }

        foreach ($vec2 as $v) {
            $mag2 += $v * $v;
        }

        return $mag1 && $mag2 ? $dot / (sqrt($mag1) * sqrt($mag2)) : 0;
    }

    public function search(Request $request)
    {
        $request->validate(['query' => 'required|string|max:255']);
        $query = strtolower($request->query('query', ''));
        $queryWords = collect(str_word_count($query, 1));
        $vocabulary = collect($this->tfidf[0] ?? [])->keys();

        $queryVec = [];
        foreach ($vocabulary as $word) {
            $tf = $queryWords->filter(fn($w) => $w === $word)->count() / max(count($queryWords), 1);
            $df = collect($this->tfidf)->filter(fn($doc) => isset($doc[$word]))->count();
            $idf = log(max(count($this->tfidf) / ($df ?: 1), 1));
            $queryVec[$word] = $tf * $idf;
        }

        $similarities = [];
        foreach ($this->tfidf as $index => $docVec) {
            $similarities[$index] = $this->cosineSimilarity($queryVec, $docVec);
        }

        arsort($similarities);
        $topIndices = array_slice(array_keys($similarities), 0, 5);
        return response()->json($this->products->only($topIndices)->values());
    }

    public function similar($id)
    {
        $productIndex = $this->products->search(fn($p) => $p['id'] == $id);
        if ($productIndex === false) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $similarities = [];
        foreach ($this->tfidf as $index => $docVec) {
            if ($index != $productIndex) {
                $similarities[$index] = $this->cosineSimilarity($this->tfidf[$productIndex], $docVec);
            }
        }

        arsort($similarities);
        $topIndices = array_slice(array_keys($similarities), 0, 5);
        return response()->json($this->products->only($topIndices)->values());
    }
}