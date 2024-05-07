<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-create',
            'role-edit',
            'role-list',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'topup-list',
            'topup-create',
            'topup-edit',
            'topup-delete',
            'country-list',
            'country-create',
            'country-edit',
            'country-delete',
            'currency-list',
            'currency-create',
            'currency-edit',
            'currency-delete',
            'flat_rate-list',
            'flat_rate-create',
            'flat_rate-edit',
            'flat_rate-delete',
            'stock-list',
            'stock-create',
            'stock-edit',
            'stock-delete',
            'cashout-list',
            'cashout-create',
            'cashout-edit',
            'cashout-delete',
            'send-list',
            'send-create',
            'send-edit',
            'send-delete',
            'dashboard-user',
            'dashboard-admin',
            'dashboard-agent',
            'dashboard-super_admin',
            'account-list',
            'account-create',
            'account-edit',
            'account-delete',
            'safe_pay-list',
            'safe_pay-create',
            'safe_pay-edit',
            'safe_pay-delete',
            'dashboard-finance',
            'income-list',
            'income-create',
            'income-edit',
            'income-delete',
            'commission-create',
            'commission-list',
            'commission-edit',
            'commission-delete',
            'AgentCashOut-list',
            'AgentCashOut-create',
            'AgentCashOut-edit',
            'AgentCashOut-update',
            'AgentCashOut-delete',
        ];

        foreach($permissions as $permission){
            Permission::create([
                'name' => $permission
            ]);
        }

        // All Permissions
        $permission_saved = Permission::pluck('id')->toArray();
        
        // Give Role Admin All Access
        $role = Role::whereId(1)->first();
        $role->syncPermissions($permission_saved);
        
        // Admin Role Sync Permission
        $user = User::where('role_id', 1)->first();
        $user->assignRole($role->id);
    }
}
