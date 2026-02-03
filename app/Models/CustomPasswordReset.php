<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CustomPasswordReset extends Model
{
    use HasFactory;

    protected $table = 'custom_password_resets';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'used',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used' => 'boolean',
        ];
    }

    /**
     * Get the user associated with this reset token
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * VULNERABLE: Generate predictable token (A04 demonstration)
     * Uses simple random numbers that are easily guessable
     */
    public static function createVulnerableToken(User $user): self
    {
        // VULNERABILITY: Predictable token using simple random number
        $token = rand(1000, 9999);

        return self::create([
            'user_id' => $user->id,
            'token' => (string) $token,
            'expires_at' => now()->addHours(24), // Too long expiration
            'used' => false,
        ]);
    }

    /**
     * SECURE: Generate cryptographically secure token
     */
    public static function createSecureToken(User $user): self
    {
        // SECURE: Cryptographically secure random token
        $token = Str::random(64);

        return self::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $token),
            'expires_at' => now()->addMinutes(15), // Short expiration
            'used' => false,
        ]);
    }

    /**
     * Check if token is valid and not expired
     */
    public function isValid(): bool
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Mark token as used
     */
    public function markAsUsed(): void
    {
        $this->update(['used' => true]);
    }
}
