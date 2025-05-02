<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    public function generateResponse($prompt)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/engines/text-davinci-003/completions', [
            'prompt' => $prompt,
            'max_tokens' => 150,
        ]);
        

        return $response->json();
    }
}
