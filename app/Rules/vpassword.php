<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class vpassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public string $cin)
    {
        $this->cin = $cin;
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
        $user = User::where('cin',$this->cin)->firstOrfail();
        return Hash::check($value, $user->$attribute);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The password is invalid';
    }
}
