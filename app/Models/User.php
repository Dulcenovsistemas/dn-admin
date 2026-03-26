<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use App\Models\Area;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function modulePermissions()
    {
        return $this->hasMany(ModulePermission::class);
    }

    public function hasModulePermission($moduleSlug, $permission)
    {
        return DB::table('module_permissions')
            ->join('modules', 'modules.id', '=', 'module_permissions.module_id')
            ->where('user_id', $this->id)
            ->where('modules.slug', $moduleSlug)
            ->where("can_$permission", 1)
            ->exists();
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'user_branches', 'user_id', 'branch_id');
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'user_areas', 'user_id', 'area_id');
    }


}
