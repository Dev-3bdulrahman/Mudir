<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
  public function run(): void
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Create permissions
    $permissions = [
      // Projects
      'projects.view',
      'projects.create',
      'projects.edit',
      'projects.delete',

      // Clients
      'clients.view',
      'clients.create',
      'clients.edit',
      'clients.delete',

      // Tickets
      'tickets.view',
      'tickets.reply',
      'tickets.manage',
      'tickets.close',

      // Invoices
      'invoices.view',
      'invoices.create',
      'invoices.edit',

      // Employees
      'employees.view',
      'employees.create',
      'employees.edit',
      'employees.delete',

      // Todos
      'todos.view-own',
      'todos.manage-all',

      // Site Settings
      'settings.view',
      'settings.edit',

      // Portfolio, Products, Services, Leads
      'portfolio.view',
      'portfolio.manage',
      'products.view',
      'products.manage',
      'services.view',
      'services.manage',
      'leads.view',
      'leads.manage',
    ];

    foreach ($permissions as $permission) {
      Permission::firstOrCreate(['name' => $permission]);
    }

    // Super Admin: gets all permissions via Gate::before
    $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);

    // Admin role
    $admin = Role::firstOrCreate(['name' => 'admin']);
    $admin->syncPermissions(Permission::all());

    // Employee role
    $employee = Role::firstOrCreate(['name' => 'employee']);
    $employee->syncPermissions([
      'projects.view',
      'tickets.view',
      'tickets.reply',
      'todos.view-own',
      'clients.view',
      'invoices.view',
    ]);

    // Client role (no admin permissions needed — portal has its own logic)
    Role::firstOrCreate(['name' => 'client']);

    // Assign super-admin role to the default admin user
    $user = \App\Models\User::where('email', 'admin@admin.com')->first();
    if ($user) {
      $user->assignRole('super-admin');
    }
  }
}
