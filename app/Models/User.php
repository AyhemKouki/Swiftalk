<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relations pour les messages envoyés
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    /**
     * Relations pour les messages reçus
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'receiver_id');
    }

    /**
     * Relation Many-to-Many avec les groupes
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_members')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    /**
     * Groupes créés par cet utilisateur
     */
    public function createdGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'created_by');
    }
}
