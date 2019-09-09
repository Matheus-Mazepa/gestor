<?php

use App\Enums\UserRolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $this->createAdminUser();
        $this->createClientUser();
    }

    private function createClientUser()
    {
        $user = User::create([
            'name' => 'Client',
            'email' => 'client@letsgrow.com.br',
            'password' => \Hash::make('123456'),
        ]);

        $user->save();
        $user->assignRole(UserRolesEnum::CLIENT);
    }

    private function createAdminUser()
    {
        $user = User::firstOrNew([
            'email' => 'admin@letsgrow.com.br',
        ]);

        $user->fill([
            'name' => 'Administrador Letsgrow',
            'email' => 'admin@letsgrow.com.br',
            'password' => \Hash::make('123456'),
        ]);

        $user->save();
        $user->assignRole(UserRolesEnum::ADMIN);
    }
}
