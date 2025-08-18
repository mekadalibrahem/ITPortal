<?php

namespace App\Classes\Export;

use MSA\LaravelGrapes\Models\Page;

class GrapesJsTemplateRenderer
{
    public function render(Page $page, array $data): array
    {
        $json = json_decode($page->page_data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decoding page_data JSON: ' . json_last_error_msg());
        }

        $htmlContent = $json['gjs-html'] ?? '';
        $cssContent = $json['gjs-css'] ?? '';

        if (empty($htmlContent)) {
            throw new \Exception('HTML content (gjs-html) not found in page_data.');
        }

        // Handle assets
        $assets = $json['gjs-assets'] ?? [];
        if (is_string($assets)) {
            $assets = json_decode($assets, true) ?? []; // Decode if string, fallback to empty array
        }
        if (!empty($assets) && is_array($assets)) {
            $htmlContent = $this->processAssets($htmlContent, $assets);
        }
        // Replace placeholders
        $renderedHtml = $this->replacePlaceholders($htmlContent, $data);

        return [
            'htmlContent' => $renderedHtml,
            'cssContent' => $cssContent
        ];
    }

    private function replacePlaceholders(string $html, array $data, string $prefix = ''): string
    {
        $renderedHtml = $html;

        foreach ($data as $key => $value) {
            $fullKey = $prefix ? "{$prefix}.{$key}" : $key;

            if (is_array($value)) {
                $renderedHtml = $this->replacePlaceholders($renderedHtml, $value, $fullKey);
            } else {
                $placeholder = '{{$' . $fullKey . '}}';
                $renderedHtml = str_replace($placeholder, e($value), $renderedHtml);
            }
        }

        return $renderedHtml;
    }

    private function processAssets(string $html, array $assets): string
    {
        $baseUrl = config('app.url');
        foreach ($assets as $asset) {
            if (isset($asset['src']) && !str_starts_with($asset['src'], 'http') && !str_starts_with($asset['src'], 'data:')) {
                $absoluteSrc = $baseUrl . '/storage/' . ltrim($asset['src'], '/');
                $html = str_replace($asset['src'], $absoluteSrc, $html);
            }
        }

        return $html;
    }
}