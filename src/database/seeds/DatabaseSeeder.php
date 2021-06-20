<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // $this->call(AdminSeeder::class);


      $superAdmin= User::create(
        [
            'name'     => 'admin',
            'email'    => 'admin@admin.com',
            'isAdmin'  => 1 ,
            'password' =>Hash::make(123456) ,
            'phone'    => '011111111'
        ]
        );

        $superAdminRole = Role::create([

            'name' => 'super-admin',
            'guard_name' => 'web',

        ]);

        $permissions = Permission::insert([
            [
                'name' => 'user-create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'user-destroy',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin-index',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin-update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin-show',
                'guard_name' => 'web',
            ],
            [
                'name' => 'make-admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin-destroy',
                'guard_name' => 'web',
            ],
           
        ]);

        foreach (Permission::all() as $permission) {
            $superAdminRole->permissions()->attach($permission);
        }

        $superAdmin->assignRole('super-admin');
    }
}

