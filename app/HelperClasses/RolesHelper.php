<?php
/**
 * Created by PhpStorm.
 * User: hassan
 * Date: 12/7/19
 * Time: 5:26 PM
 */

namespace App\HelperClasses;


use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RolesHelper
{
    /**
     *  Define basic operations to be used for each model permissions.
     */
    const BASIC_ROLES = ['admin', 'user'];

    /**
     *  Define basic operations to be used for each model permissions.
     */
    const BASIC_OPERATIONS = ['create', 'read', 'update', 'delete'];

    /**
     *  Define custom models.
     */
    const ADDITIONAL_MODELS = ['dashboard'];

    /**
     *  Define additional operations to be used for specific model permissions.
     */
    const ADDITIONAL_MODEL_OPERATIONS = [
        ['name' => 'dashboard', 'operations' => ['read']]
    ];

    /**
     * Fetch all current models.
     *
     * @param $exceptions
     * @return Collection
     */
    public static function GetModels(...$exceptions): Collection
    {
        return collect(scandir(app_path()))->filter(function ($file_or_directory) {
            return Str::contains($file_or_directory, 'php');
        })->map(function ($file) {
            return strtolower(str_replace('.php', '', $file));
        })->merge(self::ADDITIONAL_MODELS)->filter(function ($model) use ($exceptions) {
            return !in_array($model, $exceptions);
        });
    }

    /**
     * Create any role with basic permissions on specific models.
     * @param $role
     * @param Collection $models
     * @return Role
     */
    public static function CreateRole($role, Collection $models = null): Role
    {
        $label = preg_replace('/[^A-Za-z0-9\-]/', ' ', $role);

        $role = Role::firstOrCreate(['name' => $role], ['name' => $role, 'label' => $label]);

        if (!empty($models))
            self::AssignModelPermissionsToRole($role, $models);

        return $role;
    }

    /**
     * Create basic permissions for passed model.
     *
     * @param $model_name
     * @return Collection
     */
    public static function CreateModelPermissions(string $model_name): Collection
    {
        $permissions = collect();

        $operations = self::PrepareOperations($model_name);

        foreach ($operations as $operation) {
            $permissions->push(
                self::FindOrCreatePermission($model_name, $operation)
            );
        }

        return $permissions;
    }

    /**
     * @param string $model
     * @param $operation
     * @return Permission
     */
    private static function FindOrCreatePermission(string $model, string $operation): Permission
    {
        return Permission::firstOrCreate(
            ['name' => "{$operation}_{$model}"],
            ['name' => "{$operation}_{$model}", 'label' => "$operation $model", 'model' => $model]
        );
    }

    /**
     * Creating models' basic permissions (CRUD) and assign them to the role.
     *
     * @param Role $role
     * @param Collection $models
     */
    private static function AssignModelPermissionsToRole(Role $role, Collection $models): void
    {
        $models->each(function ($model) use ($role) {
            // At first we have to create all model permissions.
            $permissions = self::CreateModelPermissions($model);

            // then we assign all of this permissions to super-admin role.
            $role->givePermissionTo($permissions);
        });
    }

    /**
     * @param string $model_name
     * @return array
     */
    private static function PrepareOperations(string $model_name): array
    {
        $additional_operations = collect(self::ADDITIONAL_MODEL_OPERATIONS);

        $operations = self::BASIC_OPERATIONS;

        if ($additional_operations->contains('name', $model_name)) {
            $model_additional_operations = $additional_operations->where('name', $model_name)->first();
            $operations = isset($model_additional_operations['basic']) && $model_additional_operations['basic']
                ? array_unique(array_merge($operations, $model_additional_operations['operations']))
                : $model_additional_operations['operations'];
        }

        return $operations;
    }
}
