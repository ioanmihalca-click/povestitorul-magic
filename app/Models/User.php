<?php

namespace App\Models;

use Filament\Panel;
use App\Models\Story;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

    class User extends Authenticatable implements FilamentUser
    {
        use HasFactory, Notifiable, Billable;
    
        protected $fillable = [
            'name',
            'email',
            'password',
            'credits',
        ];
    
        protected $hidden = [
            'password',
            'remember_token',
        ];
    
        protected $casts = [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'credits' => 'integer',
        ];
    
        protected $attributes = [
            'credits' => 3, // 3 credite gratuite la înregistrare
        ];
    
        public function hasSufficientCredits($amount = 1)
        {
            return $this->credits >= $amount;
        }
    
        public function deductCredits($amount = 1)
        {
            if ($this->hasSufficientCredits($amount)) {
                $this->decrement('credits', $amount);
                return true;
            }
            return false;
        }
    
        public function addCredits($amount)
        {
            $this->increment('credits', $amount);
        }
    
        public function getRemainingCreditValueAttribute()
        {
            return $this->credits * 0.50; // 0.50 RON per credit
        }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, 'contact@povestitorulmagic.ro');
    }
}