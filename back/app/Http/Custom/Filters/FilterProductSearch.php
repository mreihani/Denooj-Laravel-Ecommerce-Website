<?php


namespace App\Http\Custom\Filters;


use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterProductSearch implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function ($query) use($value) {
            $query->where('title', 'like', '%' . $value . '%')
                ->orWhere('title_latin', 'like', '%' . $value . '%');
        });

    }
}
