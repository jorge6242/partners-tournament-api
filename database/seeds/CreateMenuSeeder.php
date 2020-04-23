<?php

use App\Menu;
use App\Role;
use App\MenuItem;
use App\Parameter;
use App\MenuItemRole;
use Illuminate\Database\Seeder;

class CreateMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $menuBase = Menu::create([
            'name' => 'menu-base',
            'slug' => 'menu-base',
            'description' => 'Menu Base',
        ]);

        Parameter::create([
            'description' => 'MENU PRINCIPAL',
            'parameter' => 'MENU_ID',
            'value' => $menuBase->id,
            'eliminable' => 1,
        ]);

        MenuItem::create([
            'name' => 'Inicio',
            'slug' => 'inicio',
            'parent' => 0,
            'order' => 0,
            'description' => 'Inicio',
            'route' => '/dashboard/main',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Registro de Torneo',
            'slug' => 'registro-torneo',
            'parent' => 0,
            'order' => 0,
            'description' => 'Registro de Torneo',
            'route' => '/dashboard/tournament-new',
            'menu_id' => $menuBase->id,
        ]);

        $sec = MenuItem::create([
            'name' => 'Seguridad',
            'slug' => 'seguridad',
            'parent' => 0,
            'order' => 1,
            'description' => 'Seguridad',
            'route' => '',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Usuarios',
            'slug' => 'usuarios',
            'parent' => $sec->id,
            'order' => 2,
            'description' => 'Usuarios',
            'route' => '/dashboard/user',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Roles',
            'slug' => 'roles',
            'parent' => $sec->id,
            'order' => 2,
            'description' => 'Roles',
            'route' => '/dashboard/role',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Permisos',
            'slug' => 'permisos',
            'parent' => $sec->id,
            'order' => 3,
            'description' => 'Permisos',
            'route' => '/dashboard/permission',
            'menu_id' => $menuBase->id,
        ]);
        
        MenuItem::create([
            'name' => 'Parametros',
            'slug' => 'parametros',
            'parent' => $sec->id,
            'order' => 3,
            'description' => 'Parametros',
            'route' => '/dashboard/parameter',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Widget',
            'slug' => 'widget',
            'parent' => $sec->id,
            'order' => 4,
            'description' => 'Widget',
            'route' => '/dashboard/widget',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Menu',
            'slug' => 'menu',
            'parent' => $sec->id,
            'order' => 5,
            'description' => 'Menu',
            'route' => '/dashboard/menu',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Menu Item',
            'slug' => 'menu-item',
            'parent' => $sec->id,
            'order' => 6,
            'description' => 'Menu',
            'route' => '/dashboard/menu-item',
            'menu_id' => $menuBase->id,
        ]);

        $data = [ 
            ['menuItem' =>  'inicio', 'roles' => ['administrador', 'participante'] ],
            ['menuItem' =>  'registro-torneo', 'roles' => ['administrador', 'participante'] ],
            ['menuItem' => 'seguridad', 'roles' => ['administrador']],
            ['menuItem' => 'usuarios    ', 'roles' => ['administrador']],
            ['menuItem' => 'roles', 'roles' => ['administrador']],
            ['menuItem' => 'permisos', 'roles' => ['administrador']],
            ['menuItem' => 'parametros', 'roles' => ['administrador']],
            ['menuItem' => 'widget', 'roles' => ['administrador']],
            ['menuItem' => 'menu', 'roles' => ['administrador']],
            ['menuItem' => 'menu-item', 'roles' => ['administrador']],
        ];
        foreach ($data as $key => $value) {
            foreach ($value['roles'] as $key => $role) {
                $menuItem = MenuItem::where('slug', $value['menuItem'])->first();
                $role = Role::where('slug', $role)->first();
                MenuItemRole::create([
                    'role_id' => $role->id,
                    'menu_item_id' => $menuItem ? $menuItem->id : null,
                ]);
            }
        }
    }
}
