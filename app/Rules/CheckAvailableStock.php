<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Product;

class CheckAvailableStock implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

     protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $a = Product::find($this->id);
        return ($value<=$a['available_stock']) ? true : false ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Failed to order  this product due to unavailablity of the stock';
    }
}
