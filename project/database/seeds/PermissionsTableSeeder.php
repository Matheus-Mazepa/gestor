<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

use App\Support\PermissionsHelper;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = $this->getPermissions();
        $permissions = PermissionsHelper::getFlattenPermissions($permissions);
        foreach ($permissions as $permission) {
            $model = Permission::firstOrNew(['name' => $permission]);
            $model->save();
        }
    }

    private function getPermissions()
    {
        return config('permissions');
    }
}
