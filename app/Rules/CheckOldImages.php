<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckOldImages implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $oldImageIds, Closure $fail): void
    {
        $imageIds = request()->author->files->pluck('id')->toArray();

        $remainImages = array_diff($oldImageIds, $imageIds);

        if ($remainImages) {
            $fail("The selected old images do not belong to this item.");
        }
    }
}
