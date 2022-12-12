<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\AssignRef;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /* Create User */
        $user= User::create([
            'name'=> 'Master Admin',
            'email'=> 'admin@gmail.com',
            'password'=> Hash::make('123'),
            'email_verified_at'=>now(),
        ]);
        $role = Role::create(['name' => 'super-admin']);
        $user ->assignRole($role);
        Role::create(['name' => 'user']);

        // create permissions
        $arrayOfPermissionNames = ['edit user', 'delete user', 'see user', 'Add Product', 'see role', 'create role'];
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web', 'created_at'=>now(), 'updated_at'=>now()];
        });

        Permission::insert($permissions->toArray());

    }
}