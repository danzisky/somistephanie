<?php

namespace App\Http\Controllers;

use App\Services\StatamicContentRepository;
use App\Support\SiteUrl;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SeoController extends Controller
{
    public function __construct(
        protected StatamicContentRepository $content,
        protected SiteUrl $siteUrl,
    ) {}

    public function sitemap(): Response
    {
        $staticPaths = ['/', '/contents', '/subscribe'];
        $urls = collect($staticPaths)
            ->map(fn (string $path) => [
                'loc' => $this->siteUrl->absolute($path),
                'lastmod' => null,
            ])
            ->merge(collect($this->content->articles())->map(fn (array $article) => [
                'loc' => $this->siteUrl->absolute('/article/'.rawurlencode($article['slug'])),
                'lastmod' => $this->lastModified($article),
            ]))
            ->values();

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /cp/',
            'Disallow: /!/',
            'Disallow: /dashboard',
            'Disallow: /settings/',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /forgot-password',
            'Disallow: /reset-password',
            'Disallow: /verify-email',
            'Disallow: /two-factor-challenge',
            'Sitemap: '.$this->siteUrl->absolute('/sitemap.xml'),
        ];

        return response(implode("\n", $lines)."\n")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /** @param array<string, mixed> $article */
    protected function lastModified(array $article): ?string
    {
        $updatedAt = $article['updated_at'] ?? $article['date'] ?? null;

        if ($updatedAt === null || $updatedAt === '') {
            return null;
        }

        return is_numeric($updatedAt)
            ? Carbon::createFromTimestamp((int) $updatedAt)->toAtomString()
            : Carbon::parse($updatedAt)->toAtomString();
    }
}