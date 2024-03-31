<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the 'admin' user
        $user = User::create([
            'name' => 'John Lupidi',
            'email' => 'johnmlupidi@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $adminRole = Role::findByName('Admin');
        $user->assignRole($adminRole);
        $permissions = Permission::pluck('id');
        $user->givePermissionTo($permissions);
    }
}
