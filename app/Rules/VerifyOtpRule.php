<?php

namespace App\Rules;

use App\Models\Otp;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VerifyOtpRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function __construct(protected $email){}
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $getOtp = Otp::where('email',$this->email)
                ->where('status',false)
                ->where('otp',$value)
                ->where('created_at','>',now()->subMinutes(30))
                ->first();

        if(!$getOtp){
            $fail('Invalid or Expired Otp');
        }
    }
}
