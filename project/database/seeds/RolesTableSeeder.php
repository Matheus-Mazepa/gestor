<?php

use App\Support\PermissionsHelper;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $profiles = config('profile-permissions');
        $this->removeUnsettedRoles(config('profile-permissions'));
        foreach ($profiles as $profile => $permissions) {
            $role = Role::firstOrCreate([
                'name' => $profile,
                'guard_name' => 'web',
            ]);

            $rolePermissions = PermissionsHelper::getFlattenPermissions($permissions);
            $role->syncPermissions($rolePermissions);
        }
    }

    public function removeUnsettedRoles($permissions)
    {
        $allRoles = array_keys($permissions);
        $unssetedRoles = Role::whereNotIn('name', $allRoles)->get();
        foreach ($unssetedRoles as $role) {
            $role->delete();
        }
    }
}
