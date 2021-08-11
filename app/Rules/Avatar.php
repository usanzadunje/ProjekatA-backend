<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Avatar implements Rule
{
    /**
     * All formats that will pass validation
     *
     * @var string
     */
    protected $supportedFormats = '';


    /**
     * Create a new rule instance.
     * @param string $supportedFormats
     * @return void
     */
    public function __construct(string $supportedFormats)
    {
        $this->supportedFormats = $supportedFormats;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match("#\b($this->supportedFormats)\b#", $value, $matchedFormat) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.encoded-image', ['values' => str_replace('|', ', ', $this->supportedFormats)]);
    }
}
