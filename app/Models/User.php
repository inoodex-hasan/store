<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'verification_code',
        'role_id',
        'is_verified'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];




    // app/Models/User.php relation

    public function role()
    {
        return $this->belongsTo(Role::class);
    }



   // ****NaYeem*****  one Sop show Transfer Create New Transfer-Stock

    /**
     * Defines a many-to-many relationship with Shop via the user_manages pivot table.
     * Includes role_id from the pivot table for additional access control.
     */
    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'user_manages', 'user_id', 'shop_id')
            ->withPivot('role_id');
    }

    /**
     * Returns the user's primary (first assigned) shop.
     * Used to restrict stock transfers to only the shop the user manages.
     */
    public function primaryShop()
    {
        return $this->shops()->first(); // Returns null if no shop is assigned
    }

  // ****NaYeem*****  one Sop show Transfer Create New Transfer-Stock


}
