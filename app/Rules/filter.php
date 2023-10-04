<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class filter implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
     protected $words;
     protected $filterd;


    public function __construct($words)
    {
        $this->words=$words;
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
        foreach($this->words as $word)

        if(stripos($value,$word)!==false){
            $this->filterd=$word;
            return false;


         }
         return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'warrning:Please adhere to public etiquette:you cant use word:'. $this->filterd ." ".'in this app';
    }
}
