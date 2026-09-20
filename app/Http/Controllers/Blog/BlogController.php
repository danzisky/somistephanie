<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Services\StatamicApiClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use League\CommonMark\CommonMarkConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
    public function __construct(protected StatamicApiClient $api) {}

    public function home(): Response
    {
        $featuredEntries = $this->api->get('/collections/articles/entries', [
            'filter' => ['featured:is' => 'true'],
            'limit' => 1,
        ])['data'] ?? [];

        $featured = $featuredEntries[0] ?? null;

        $latestEntries = $this->api->get('/collections/articles/entries', [
            'limit' => 10,
        ])['data'] ?? [];

        $latest = collect($latestEntries)
            ->reject(fn (array $entry) => $featured && $entry['id'] === $featured['id'])
            ->take(4)
            ->map(fn (array $entry) => $this->formatArticle($entry))
            ->values()
            ->all();

        $topics = $this->fetchTopics();

        return Inertia::render('Blog/Home', [
            'featured' => $featured ? $this->formatArticle($featured, withContent: false) : null,
            'latest' => $latest,
            'topics' => $topics,
        ]);
    }

    /**
     * The header's "Featured" link points here without a slug (matching the
     * reference design). We resolve it to whichever article is currently
     * marked as featured and redirect to its real permalink.
     */
    public function featured(): RedirectResponse
    {
        $entries = $this->api->get('/collections/articles/entries', [
            'filter' => ['featured:is' => 'true'],
            'limit' => 1,
        ])['data'] ?? [];

        $entry = $entries[0] ?? $this->api->get('/collections/articles/entries', ['limit' => 1])['data'][0] ?? null;

        if (! $entry) {
            throw new NotFoundHttpException('No articles are available yet.');
        }

        return redirect()->route('blog.article', $entry['slug']);
    }

    public function contents(Request $request): Response
    {
        $entries = $this->api->get('/collections/articles/entries', [
            'limit' => 100,
        ])['data'] ?? [];

        $articles = collect($entries)
            ->map(fn (array $entry) => $this->formatArticle($entry, withContent: false))
            ->values()
            ->all();

        return Inertia::render('Blog/Contents', [
            'articles' => $articles,
            'categories' => $this->fetchTopics(),
            'initialCategory' => $request->query('category'),
        ]);
    }

    public function article(string $slug): Response
    {
        $entries = $this->api->get('/collections/articles/entries', [
            'filter' => ['slug:is' => $slug],
            'limit' => 1,
        ])['data'] ?? [];

        $entry = $entries[0] ?? null;

        if (! $entry) {
            throw new NotFoundHttpException("Article [{$slug}] was not found.");
        }

        $others = $this->api->get('/collections/articles/entries', [
            'limit' => 10,
        ])['data'] ?? [];

        $related = collect($others)
            ->reject(fn (array $other) => $other['id'] === $entry['id'])
            ->take(2)
            ->map(fn (array $other) => $this->formatArticle($other, withContent: false))
            ->values()
            ->all();

        return Inertia::render('Blog/Article', [
            'article' => $this->formatArticle($entry, withContent: true),
            'related' => $related,
        ]);
    }

    public function subscribe(): Response
    {
        return Inertia::render('Blog/Subscribe');
    }

    public function shop(): Response
    {
        return Inertia::render('Blog/Shop');
    }

    /**
     * Fetch the "categories" taxonomy terms, used for the homepage topic
     * cloud and the archive's category filter pills.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function fetchTopics(): array
    {
        $terms = $this->api->get('/taxonomies/categories/terms', [
            'limit' => 50,
        ])['data'] ?? [];

        return collect($terms)
            ->map(fn (array $term) => [
                'title' => $term['title'],
                'slug' => $term['slug'],
                'description' => $term['description'] ?? '',
            ])
            ->values()
            ->all();
    }

    /**
     * Normalize a raw Statamic API entry into the flat shape the Vue
     * components expect, rendering the markdown body to HTML server-side.
     *
     * @param  array<string, mixed>  $entry
     * @return array<string, mixed>
     */
    protected function formatArticle(array $entry, bool $withContent = true): array
    {
        $category = $this->firstRelation($entry['category'] ?? null);
        $heroImage = $this->firstRelation($entry['hero_image'] ?? null);
        $date = isset($entry['date']) ? Carbon::parse($entry['date']) : null;

        $article = [
            'id' => $entry['id'],
            'slug' => $entry['slug'],
            'title' => $entry['title'],
            'standfirst' => $entry['standfirst'] ?? '',
            'author' => $entry['author'] ?? 'Somi',
            'category' => $category['title'] ?? null,
            'category_slug' => $category['slug'] ?? null,
            'date' => $date?->toIso8601String(),
            'date_formatted' => $date?->format('d F Y'),
            'read_time' => (int) ($entry['read_time'] ?? 0),
            'views' => (int) ($entry['views'] ?? 0),
            'comments_count' => (int) ($entry['comments_count'] ?? 0),
            'featured' => (bool) ($entry['featured'] ?? false),
            'hero_image' => $heroImage['permalink'] ?? $heroImage['url'] ?? null,
            'hero_image_caption' => $entry['hero_image_caption'] ?? null,
        ];

        if ($withContent) {
            $article['content_html'] = $this->renderMarkdown($entry['content'] ?? '');
        }

        return $article;
    }

    /**
     * Normalize a `max_items: 1` / `max_files: 1` relationship field value.
     *
     * With a max of 1, Statamic's API augments the field directly to a single
     * associative array (or null when empty) rather than wrapping it in a
     * list. This defensively also handles a list-wrapped value, in case the
     * field is ever reconfigured to allow more than one item.
     *
     * @param  array<string, mixed>|list<array<string, mixed>>|null  $value
     * @return array<string, mixed>|null
     */
    protected function firstRelation(?array $value): ?array
    {
        if ($value === null) {
            return null;
        }

        return array_is_list($value) ? ($value[0] ?? null) : $value;
    }

    protected function renderMarkdown(string $markdown): string
    {
        static $converter;

        $converter ??= new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return (string) $converter->convert($markdown);
    }
}
