<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Permissions
            ['group' => 'Permissions', 'name' => 'create-permissions', 'display_name' => 'Create Permissions', 'guard_name' => 'web'],
            ['group' => 'Permissions', 'name' => 'edit-permissions', 'display_name' => 'Edit Permissions', 'guard_name' => 'web'],
            ['group' => 'Permissions', 'name' => 'list-permissions', 'display_name' => 'List Permissions', 'guard_name' => 'web'],
            ['group' => 'Permissions', 'name' => 'delete-permissions', 'display_name' => 'Delete Permissions', 'guard_name' => 'web'],
            // Languages
            ['group' => 'Languages', 'name' => 'create-languages', 'display_name' => 'Create Languages', 'guard_name' => 'web'],
            ['group' => 'Languages', 'name' => 'edit-languages', 'display_name' => 'Edit Languages', 'guard_name' => 'web'],
            ['group' => 'Languages', 'name' => 'list-languages', 'display_name' => 'List Languages', 'guard_name' => 'web'],
            ['group' => 'Languages', 'name' => 'delete-languages', 'display_name' => 'Delete Languages', 'guard_name' => 'web'],

            // Roles
            ['group' => 'Roles', 'name' => 'create-roles', 'display_name' => 'Create', 'guard_name' => 'web'],
            ['group' => 'Roles', 'name' => 'edit-roles', 'display_name' => 'Edit', 'guard_name' => 'web'],
            ['group' => 'Roles', 'name' => 'list-roles', 'display_name' => 'List', 'guard_name' => 'web'],
            ['group' => 'Roles', 'name' => 'delete-roles', 'display_name' => 'Delete', 'guard_name' => 'web'],
            // Users
            ['group' => 'Users', 'name' => 'create-users', 'display_name' => 'Create User', 'guard_name' => 'web'],
            ['group' => 'Users', 'name' => 'list-users', 'display_name' => 'List Users', 'guard_name' => 'web'],
            ['group' => 'Users', 'name' => 'edit-users', 'display_name' => 'Edit Users', 'guard_name' => 'web'],
            ['group' => 'Users', 'name' => 'delete-users', 'display_name' => 'Delete Users', 'guard_name' => 'web'],
             // Settings
            ['group' => 'Settings', 'name' => 'list-settings', 'display_name' => 'List Settings', 'guard_name' => 'web'],
            ['group' => 'Settings', 'name' => 'create-settings', 'display_name' => 'Create Settings', 'guard_name' => 'web'],
            ['group' => 'Settings', 'name' => 'edit-settings', 'display_name' => 'Edit Settings', 'guard_name' => 'web'],
            ['group' => 'Settings', 'name' => 'delete-settings', 'display_name' => 'Delete Settings', 'guard_name' => 'web'],


        ];


        DB::table('languages')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();
        DB::table('users')->delete();
     
        // default admin users
        $rootUser = User::create([
            'name' => 'ROOT',
            'email' => 'admin@admin.com',
            'phone' => '01254455827',
            'password' => Hash::make('12345678'),
            'type' => 'admin'
        ]);
     
        // add default languages
        $language = new \App\Language;
        $language->name = 'EN';
        $language->code = 'EN';
        $language->direction = 'LTR';
        $language->flag = 'EN';
        $language->user_id = $rootUser->id;

        $language->save();

        $language = new \App\Language;
        $language->name = 'AR';
        $language->code = 'AR';
        $language->direction = 'RTL';
        $language->flag = 'AR';
        $language->user_id = $rootUser->id;

        $language->save();



        }
}
