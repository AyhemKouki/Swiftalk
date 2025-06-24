<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'created_by'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function admins(): BelongsToMany
    {
        return $this->members()->wherePivot('role', 'admin');
    }

    public function isAdmin(User $user): bool
    {
        return $this->members()->wherePivot('user_id', $user->id)
            ->wherePivot('role', 'admin')->exists();
    }

    public function isMember(User $user): bool
    {
        return $this->members()->wherePivot('user_id', $user->id)->exists();
    }
}
