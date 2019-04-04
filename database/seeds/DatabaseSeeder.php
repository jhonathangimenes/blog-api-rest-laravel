<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Permission;
use App\PermissionUser;
use App\TypeSocialNetwork;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->createAdmin();
    }

    public function createAdmin()
    {
        $user = User::create([
            'first_name' => 'admin',
            'last_name' => 'administration', 
            'email' => 'admin@admin',
            'password'=> bcrypt('admin')
        ]);

        Permission::create([
            'desc' => 'admin'
        ]);
        Permission::create([
            'desc' => 'user-manager'
        ]);
        Permission::create([
            'desc' => 'post-manager'
        ]);

        PermissionUser::create([
            'user_id' => $user->id,
            'permission_id' => '1'

        ]);

        TypeSocialNetwork::create([
            'desc' => 'facebook'
        ]);
    }
}
