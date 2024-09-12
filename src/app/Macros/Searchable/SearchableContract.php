<?php

namespace App\Macros\Searchable;

use Illuminate\Contracts\Database\Eloquent\Builder;

interface SearchableContract
{
    public function search(Builder $query, ?string $searchText): void;
}
