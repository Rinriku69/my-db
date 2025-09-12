<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Psr\Http\Message\ServerRequestInterface;

abstract class SearchableController extends Controller
{
    // Keyword abstract means MUST be overridden later.
    abstract function getQuery(): Builder | Relation;


    function prepareCriteria(array $criteria): array
    {
        return [
            'term' => null,
            ...$criteria,
        ];
    }

    function applyWhereToFilterByTerm(Builder $query, string $word): void
    {
        $query
            ->where('code', 'LIKE', "%{$word}%")
            ->orWhere('name', 'LIKE', "%{$word}%");
    }

    function filterByTerm(Builder | Relation $query, ?string $term): Builder | Relation
    {
        if (!empty($term)) {
            foreach (\preg_split('/\s+/', \trim($term)) as $word) {
                $query->where(function (Builder $innerQuery) use ($word) { //php cannot use variable outside function so we do 'use ($variable_name)' to refer outside-function variable
                    $this->applyWhereToFilterByTerm($innerQuery, $word);
                });
            }
        }

        return $query;
    }

    function filterByPrice(
        Builder | Relation $query,
        ?float $minPrice,
        ?float $maxPrice
    ): Builder | Relation {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }

    function filter(Builder | Relation $query, array $criteria): Builder | Relation
    {
        return $this->filterByTerm($query, $criteria['term']);
    }

    function search(array $criteria): Builder
    {
        $query = $this->getQuery();
        return $this->filter($query, $criteria);
    }

    // For easily searching by code.
    function find(string $code): Model
    {
        return $this->getQuery()->where('code', $code)->firstOrFail();
    }
}
