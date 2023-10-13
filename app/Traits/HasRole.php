<?php
/**
 * Created by PhpStorm.
 * User: hassan
 * Date: 12/7/19
 * Time: 11:19 AM
 */

namespace App\Traits;


use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Trait HasRole
 * @package App\Traits
 */
trait HasRole
{
    /**
     * @return BelongsToMany
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * @param string $role
     * @return void
     */
    public function actAs(string $role): void
    {
        $role = Role::whereName($role)->firstOrFail();

        if (!$this->role->contains('id', $role->id)) {
            $this->role()->sync($role);
        }
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->role->contains('name', $role);
        }
        return !!$role->intersect([$this->role])->count();
    }

    /**
     * @param string $model
     * @return bool
     */
    public function hasRoleOnModel(string $model): bool
    {
        $roles = $this->role->with('permissions')->get();

        foreach ($roles as $role) {
            return $role->permissions->contains('model', strtolower($model));
        }

        return false;
    }
}
