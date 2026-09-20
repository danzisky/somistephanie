<?php

namespace App\Services;

use Statamic\Contracts\Data\Augmentable;
use Statamic\Facades\Entry;
use Statamic\Facades\Term;
use Statamic\Query\Builder;

/**
 * Reads content directly through Statamic's core query builders (free,
 * included in every edition) instead of the REST/GraphQL Content APIs,
 * which require a Pro license (https://statamic.dev/backend-apis/data).
 *
 * Entries/terms are augmented and normalized into plain arrays with the
 * same shape the REST API would have returned, so callers can consume
 * them identically.
 */
class StatamicContentRepository
{
    /**
     * @param  array<string, mixed>  $wheres
     * @return array<int, array<string, mixed>>
     */
    public function articles(array $wheres = [], ?int $limit = null): array
    {
        /** @var Builder $query */
        $query = Entry::query();
        $query->where('collection', 'articles');

        foreach ($wheres as $field => $value) {
            $query->where($field, $value);
        }

        $query->orderBy('date', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get()
            ->map(fn (Augmentable $entry) => $this->augment($entry))
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function articleBySlug(string $slug): ?array
    {
        /** @var Builder $query */
        $query = Entry::query();
        $query->where('collection', 'articles');

        $entry = $query->where('slug', $slug)->first();

        return $entry ? $this->augment($entry) : null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function categoryTerms(?int $limit = null): array
    {
        /** @var Builder $query */
        $query = Term::query();
        $query->where('taxonomy', 'categories');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get()
            ->map(fn (Augmentable $term) => $this->augment($term))
            ->values()
            ->all();
    }

    /**
     * Augment a Statamic entry/term and normalize it into a plain array,
     * matching the shape produced by the Content API's JSON resources.
     *
     * @return array<string, mixed>
     */
    protected function augment(Augmentable $item): array
    {
        return json_decode(json_encode($item->toAugmentedArray()), true) ?? [];
    }
}
