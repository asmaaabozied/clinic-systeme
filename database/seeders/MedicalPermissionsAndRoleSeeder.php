<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MedicalPermissionsAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = ['manage', 'create', 'edit', 'delete', 'view', 'show'];

        $medicalModules = [
            'appointment' => $actions,
            'checkups' => [$actions[1]],
            'patients' => $actions,
            'doctors' => $actions,
            'doctor dashboard' => [$actions[5]],
            'doses' => $actions,
            'dose intervals' => $actions,
            'charge types' => $actions,
            'taxes' => $actions,
            'charges' => $actions,
            'charge categories' => $actions,
            'doctor specializations' => $actions,
            'medicine categories' => $actions,
            'invoices' => [$actions[0]],
        ];
        $per = [];

        foreach ($medicalModules as $module => $moduleActions) {

            foreach ($moduleActions as $action) {
                $permissionName = "{$action} {$module}";
                $per [] = $permissionName;
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }
        }

       $companyRoles = Role::query()->where('name', 'like', '%company%')->get();
        foreach ($companyRoles as $role) {
           //if not exsist add it
            foreach ($per as $permission) {
                if (!$role->hasPermissionTo($permission)) {
                    $role->givePermissionTo($permission);
                }
            }
        }

    }

}
