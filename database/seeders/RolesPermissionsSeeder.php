<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name'=>'superAdmin']);
        $adminRole = Role::create(['name' => 'admin']);
        $clientRole = Role::create(['name' => 'client']);


        $permissions = [
            'create-address','update-address','delete-address','index-address','show-address',
            'create-cart','update-cart','delete-cart','index-cart','show-cart',
            'create-favorite','update-favorite','delete-favorite','index-favorite','show-favorite',
            'create-image','update-image','delete-image','index-image','show-image',
            'create-order','update-order','delete-order','index-order','show-order',
            'create-product','update-product','delete-product','index-product','show-product',
            'create-store','update-store','delete-store','index-store','show-store',
            'create-user','update-user','delete-user','index-user','show-user',
            'index-notification','show-notification'
        ];

        foreach($permissions as $permission)
        {
            Permission::findOrCreate($permission,'web');
        }

        // Assign permissions to roles




        // delete old permissions and keep those inside the $permissions array
        $superAdminRole->syncPermissions($permissions);
        $adminRole->syncPermissions($permissions);



        // add permissions  on top of old ones
        $clientRole->givePermissionTo(
            [
                'create-address','update-address','delete-address','index-address','show-address',
                'create-cart','update-cart','delete-cart','index-cart','show-cart',
                'create-favorite','update-favorite','delete-favorite','index-favorite','show-favorite',
                'create-order','update-order','delete-order','index-order','show-order','show-user',
                'update-user','delete-user','index-store','show-store','index-product','show-product',
                'index-notification','show-notification'
            ]);


        ////////////////////////////////////////////////////////

        $superAdmin = User::factory()->create([
            'image_path' => 'users/profile-user.png',
            'first_name' => 'Ahmad',
            'last_name' =>'Kalleh',
            'email' => 'ahmadhkalleh@gmail.com',
            'password' => Hash::make('a72xd2004'),
            'phone_number' => '0000000000'
        ]);

        $superAdmin2 = User::factory()->create([
            'image_path' => 'users/profile-user.png',
            'first_name' => 'Osama',
            'last_name' =>'Abo-Daken',
            'email' => 'osamaabodaken@gmail.com',
            'password' => Hash::make('o72xd2004'),
            'phone_number' => '1111111111'
        ]);

        $adminUser = User::factory()->create([
            'image_path' => 'users/profile-user.png',
            'first_name' => 'Jad',
            'last_name'=>'Nahkla',
            'email' => 'jadnahkla@example.com',
            'password' => Hash::make('j72xd2004'),
            'phone_number' => '2222222222'
        ]);

        $adminUser2 = User::factory()->create([
            'image_path' => 'users/profile-user.png',
            'first_name' => 'Raghad',
            'last_name'=>'Sobh',
            'email' => 'raghadsobh@example.com',
            'password' => Hash::make('r72xd2004'),
            'phone_number' => '3333333333'
        ]);

        $adminUser3 = User::factory()->create([
            'image_path' => 'users/profile-user.png',
            'first_name' => 'Tassnim',
            'last_name'=>'Kashoa',
            'email' => 'tassnimKashoa@example.com',
            'password' => Hash::make('t72xd2004'),
            'phone_number' => '4444444444'
        ]);



        $superAdmin->assignRole($superAdminRole);
        $permissions = $superAdminRole->permissions()->pluck('name')->toArray();
        $superAdmin->givePermissionTo($permissions);

        $superAdmin2->assignRole($superAdminRole);
        $permissions = $superAdminRole->permissions()->pluck('name')->toArray();
        $superAdmin2->givePermissionTo($permissions);

        $adminUser->assignRole($adminRole);
        $permissions = $adminRole->permissions()->pluck('name')->toArray();
        $adminUser->givePermissionTo($permissions);

        $adminUser2->assignRole($adminRole);
        $permissions = $adminRole->permissions()->pluck('name')->toArray();
        $adminUser2->givePermissionTo($permissions);

        $adminUser3->assignRole($adminRole);
        $permissions = $adminRole->permissions()->pluck('name')->toArray();
        $adminUser3->givePermissionTo($permissions);


        //////////////////////////////////////////////////////////


        $clientUser = User::factory()->create([
            'image_path' => 'users/profile-user.png',
            'first_name' => 'Mohammad',
            'last_name'=>'Kalleh',
            'email' => 'mohammadkalleh@example.com',
            'password' => Hash::make('123456'),
            'phone_number' => '0946561629'
        ]);

        $clientUser->assignRole($clientRole);
        $permissions = $clientRole->permissions()->pluck('name')->toArray();
        $clientUser->givePermissionTo($permissions);
    }
}
