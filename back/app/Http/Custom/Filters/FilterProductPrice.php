<?php


namespace App\Http\Custom\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterProductPrice implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function ($query) use($value) {

            $query
                ->where([
                    ['product_type' ,'=', 'simple'],
                    ['price','>=',$value[0]],
                    ['price','<=',$value[1]]
                ])
                ->orWhere(function (Builder $query) use ($value){
                    $query->where('product_type' ,'=', 'variation')
                        ->whereHas('inventories', function ($query) use ($value) {
                            $query->where([
                                ['price','>=',$value[0]],
                                ['price','<=',$value[1]]
                            ]);
                        });
                });
        });


    }
}
