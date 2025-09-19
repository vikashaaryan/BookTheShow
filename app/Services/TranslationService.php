<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    public function translateToHindi($text)
    {
        if (empty($text)) {
            return '';
        }

        try {
            $response = Http::timeout(10)->retry(2, 100)->post('https://libretranslate.de/translate', [
                'q' => $text,
                'source' => 'en',
                'target' => 'hi',
                'format' => 'text',
            ]);

            if ($response->successful()) {
                $result = $response->json();
                return $result['translatedText'] ?? $text;
            }

            Log::error('LibreTranslate API error: ' . $response->body());
            throw new \Exception('Translation API request failed.');
        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage());
            throw $e; // Rethrow to allow component to handle the error
        }
    }
}