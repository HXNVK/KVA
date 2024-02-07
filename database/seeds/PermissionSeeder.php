<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $permission->delete();
        }

        $guards = [
            'web',
//            'sanctum'
        ];

        $permissions = [
            'user-create',
            'user-delete',
            'user-edit',
            'user-list',
        ];

        foreach ($guards as $guard) {
            foreach($permissions as $permission) {
                Permission::findOrCreate($permission , $guard);
            }
        }

        $role = Role::findOrCreate('SuperAdmin');
        $permissions = Permission::all();

        $user = User::find(1);
        $user->assignRole('SuperAdmin');
        $user = User::find(24);
        $user->assignRole('SuperAdmin');
        
        $user->password = Hash::make('marvin95');
        $user->save();




        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->name);
        }

        $adminPermissions = [
            'user-list'
        ];

        $role = Role::findOrCreate('Admin');
        $role->givePermissionTo($adminPermissions);



    }
}
