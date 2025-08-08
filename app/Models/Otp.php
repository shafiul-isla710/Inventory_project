<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
    ];

    /**
     * Check if the OTP is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->expires_at > now();
    }
}
