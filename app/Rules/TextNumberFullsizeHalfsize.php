<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TextNumberFullsizeHalfsize implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return preg_match('/^[a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠、。\n\r\'@`!" #$%&\'()*+,-.\\/:;[{<\|=\]}>\^~? _]+$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '全角文字、半角英数字、記号で入力してください';
    }
}
