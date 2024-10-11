<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'last_name',
        'middle_name',
        'gender',
        'phone',
        'avatar',
        'birth_day',
        'password',
        'description',
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
            'birth_day' => 'date',
            'password' => 'hashed',
        ];
    }

    public function trainers(): HasMany
    {
        return $this->hasMany(Trainer::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_user');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(RoleEnum::ADMIN->value);
    }

    public function isManager(): bool
    {
        return $this->hasRole(RoleEnum::MANAGER->value);
    }

    public function isClient(): bool
    {
        return $this->hasRole(RoleEnum::CLIENT->value);
    }

    public function isTrainer(): bool
    {
        return $this->hasRole(RoleEnum::TRAINER->value);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name.' '.$this->last_name;
    }

    public function hasActivity($id): bool
    {
        $activityIds = $this->activities->pluck('id')->toArray();
        return in_array($id, $activityIds);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->hasRole(RoleEnum::dashboardAllowedRoles());
        }

        return true;
    }
}
