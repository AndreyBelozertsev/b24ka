<?php
namespace App\Casts;



use App\ValueObjects\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PriceCast implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes): Price | null
    {

        if($value){
            return Price::make($value);
        }
        return null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        
        if(! $value instanceof Price){
            $value = Price::make((int)$value); 
        }
        return $value->setValue() ;
    }
}
