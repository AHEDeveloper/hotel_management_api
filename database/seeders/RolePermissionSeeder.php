<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Rooms
            'create rooms',
            'view rooms',
            'update rooms',
            'delete rooms',

            // Room Types
            'create room types',
            'view room types',
            'update room types',
            'delete room types',

            // Reservations
            'create reservations',
            'view reservations',
            'update reservations',
            'delete reservations',

            // Reservation Rooms
            'create reservation rooms',
            'view reservation rooms',
            'update reservation rooms',
            'delete reservation rooms',

            // Payments
            'create payments',
            'view payments',
            'update payments',
            'delete payments',

            // Services
            'create services',
            'view services',
            'update services',
            'delete services',

            // Reservation Services
            'create reservation services',
            'view reservation services',
            'update reservation services',
            'delete reservation services',

            // Reviews
            'create reviews',
            'view reviews',
            'update reviews',
            'delete reviews',

            // Amenities
            'create amenities',
            'view amenities',
            'update amenities',
            'delete amenities',

            // Amenity Rooms
            'create amenity rooms',
            'view amenity rooms',
            'update amenity rooms',
            'delete amenity rooms',

            // Room Images
            'create room images',
            'view room images',
            'update room images',
            'delete room images',

            // Admins
            'create admins',
            'view admins',
            'update admins',
            'delete admins',
        ];
        foreach ($permissions as $permission){
            Permission::query()->create([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }

        $superAdmin = Role::query()->create([
            'name' => 'super admin',
            'guard_name' => 'admin'
        ]);
        $superAdmin->givePermissionTo(Permission::all());

        $roomAdmin = Role::query()->create([
            'name' => 'room admin',
            'guard_name' => 'admin'
        ]);
        $roomAdmin->givePermissionTo([
            'create rooms', 'view rooms', 'update rooms', 'delete rooms',
            'create room types', 'view room types', 'update room types', 'delete room types',
            'create room images', 'view room images', 'update room images', 'delete room images',
            'create amenities', 'view amenities', 'update amenities', 'delete amenities',
            'create amenity rooms', 'view amenity rooms', 'update amenity rooms', 'delete amenity rooms',
        ]);

        $reservationAdmin = Role::query()->create([
            'name' => 'reservation admin',
            'guard_name' => 'admin'
        ]);
        $reservationAdmin->givePermissionTo([
            'create reservations', 'view reservations', 'update reservations', 'delete reservations',
            'create reservation rooms', 'view reservation rooms', 'update reservation rooms', 'delete reservation rooms',
            'create payments', 'view payments', 'update payments', 'delete payments',
            'create reservation services', 'view reservation services', 'update reservation services', 'delete reservation services',
        ]);

        $serviceAdmin = Role::query()->create([
            'name' => 'service admin',
            'guard_name' => 'admin'
        ]);
        $serviceAdmin->givePermissionTo([
            'create reviews', 'view reviews', 'update reviews', 'delete reviews',
            'create services', 'view services', 'update services', 'delete services',
        ]);

        $superAdminUser = Admin::query()->create([
            'name' => 'amirEsmaili',
            'email' => 'A@gmail.com',
            'password' => bcrypt(1234)
        ]);
        $superAdminUser->assignRole('super admin');

        $adminRoomUser = Admin::query()->create([
            'name' => 'sardar',
            'email' => 's@gmailcom',
            'password' => bcrypt(1234)
        ]);
        $adminRoomUser->assignRole('room admin');

        $reservationAdminUser = Admin::query()->create([
            'name' => 'mahdi',
            'email' => 'm@gmail.com',
            'password' => bcrypt(1234),
        ]);
        $reservationAdminUser->assignRole('reservation admin');

        $serviceAdminUser = Admin::query()->create([
            'name' => 'hosein',
            'email' => 'h@gmail.com',
            'password' => bcrypt(1234)
        ]);
        $serviceAdminUser->assignRole('service admin');
    }
}
