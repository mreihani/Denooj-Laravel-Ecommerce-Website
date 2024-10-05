<?php


namespace App\Http\Custom\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterProductAttribute implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        $attrCode = explode('-',$property)[1];
        if (is_array($value)){
            // multiple attributes
            foreach ($value as $attrString){
                $attrVal = explode(',',$attrString);
                $valuesArray = $attrVal;
                foreach ($valuesArray as $val){
                    $query->whereJsonContains('total_attributes', ['code' => $attrCode,'value' => $val],'or');
                }
            }

        }else{

            // single attribute
            $attrVal = explode(',',$value);
            $valuesArray = $attrVal;
            foreach($valuesArray as $val) {
                $query->whereJsonContains('total_attributes', ['code' => $attrCode,'value' => $val]);
            }
        }


    }
}
