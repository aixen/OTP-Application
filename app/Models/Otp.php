<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'code', 'expires_at', 'used_at'];

    protected $dates = ['expires_at', 'used_at'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function isValid(): bool
    {
        return !$this->used_at && $this->expires_at->isFuture();
    }
}
