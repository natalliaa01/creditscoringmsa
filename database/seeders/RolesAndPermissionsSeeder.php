<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; // Import model User

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definisikan Permissions
        // Permissions untuk aplikasi kredit
        Permission::firstOrCreate(['name' => 'view all credit applications']);
        Permission::firstOrCreate(['name' => 'create credit application']);
        Permission::firstOrCreate(['name' => 'edit credit application']);
        Permission::firstOrCreate(['name' => 'delete credit application']);
        Permission::firstOrCreate(['name' => 'view scoring result']);
        Permission::firstOrCreate(['name' => 'view recommendation']);
        Permission::firstOrCreate(['name' => 'approve/reject application']);

        // Permissions khusus Admin
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage master data']);
        Permission::firstOrCreate(['name' => 'manage system configuration']);
        Permission::firstOrCreate(['name' => 'access full reports']);

        // Permissions khusus Direksi
        Permission::firstOrCreate(['name' => 'access strategic reports']);

        // Permissions khusus Kepala Bagian Kredit
        Permission::firstOrCreate(['name' => 'edit own department applications']);
        Permission::firstOrCreate(['name' => 'delete own department applications']);
        Permission::firstOrCreate(['name' => 'access team reports']);

        // Permissions khusus Teller (melihat aplikasi yang diinput sendiri)
        Permission::firstOrCreate(['name' => 'view own applications']);


        // 2. Definisikan Roles dan Berikan Permissions

        // Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all()); // Admin memiliki semua izin

        // Direksi Role
        $direksiRole = Role::firstOrCreate(['name' => 'Direksi']);
        $direksiRole->givePermissionTo([
            'view all credit applications',
            'view scoring result',
            'view recommendation',
            'access full reports',
            'access strategic reports',
            'approve/reject application',
            'edit credit application',   // Tambahkan izin ini untuk Direksi
            'delete credit application', // Tambahkan izin ini untuk Direksi
        ]);

        // Kepala Bagian Kredit Role
        $kepalaBagianKreditRole = Role::firstOrCreate(['name' => 'Kepala Bagian Kredit']);
        $kepalaBagianKreditRole->givePermissionTo([
            'create credit application',
            'view all credit applications',
            'edit own department applications',
            'delete own department applications',
            'view scoring result',
            'view recommendation',
            'access team reports',
            'edit credit application',
            'delete credit application',
        ]);

        // Teller Role
        $tellerRole = Role::firstOrCreate(['name' => 'Teller']);
        $tellerRole->givePermissionTo([
            'create credit application',
            'view own applications',
            'edit credit application',
            'delete credit application',
        ]);

        // Opsional: Buat user admin pertama
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
            ]
        );
        $adminUser->assignRole('Admin');

        $direksiUser = User::firstOrCreate(
            ['email' => 'direksi@example.com'],
            [
                'name' => 'Direksi User',
                'password' => bcrypt('password'),
            ]
        );
        $direksiUser->assignRole('Direksi');

        $kepalaBagianKreditUser = User::firstOrCreate(
            ['email' => 'kepalabagian@example.com'],
            [
                'name' => 'Kepala Bagian Kredit User',
                'password' => bcrypt('password'),
            ]
        );
        $kepalaBagianKreditUser->assignRole('Kepala Bagian Kredit');

        $tellerUser = User::firstOrCreate(
            ['email' => 'teller@example.com'],
            [
                'name' => 'Teller User',
                'password' => bcrypt('password'),
            ]
        );
        $tellerUser->assignRole('Teller');
    }
}
