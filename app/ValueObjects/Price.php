<?php
namespace App\ValueObjects;

use Stringable;
use App\Traits\Makeable;
use InvalidArgumentException;



class Price implements Stringable
{

    use Makeable;

    private array $currenccies =[
        'RUB' => '₽'
    ];

    public function __construct(
        private readonly int $value, 
        private readonly string $currency = 'RUB',
        private readonly int $precesion = 100,
    ){
        if($value < 0){
            throw new InvalidArgumentException('Price must be more than zero');
        }

        if( !isset($this->currenccies[$currency] )){
            throw new InvalidArgumentException('Currency not allowed');
        }
    }

    public function raw(): int 
    {
        return $this->value;
    }

    public function setValue(): int
    {
        return $this->value * $this->precesion;
    }

    public function value(): float|int
    {
        return $this->value / $this->precesion;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return $this->currenccies[$this->currency];
    }

    public function __toString(): string
    {
        return number_format( $this->value(), 2, ',', ' ' ) . ' ' . $this->symbol();
    }
}