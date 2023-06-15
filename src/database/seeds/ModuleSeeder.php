<?php

namespace Liffe\Compras\Database\Seeds;

use Illuminate\Database\Seeder;
use Phantom\App\Models\Module;

class ModuleSeeder extends Seeder
{

    public function run()
    {
        $this->register();
    }

    public function register()
    {
        $this->module();
    }

    public function module()
    {
        $module = [
            'usmodname' => 'Compras',
            'usmoddesc' => 'Modulo Compras',
            'usmodvers' => '1.0.0',
            'usmodauth' => 'hayaralexaliagagutierrez@gmail.com',
            'usmodprfx' => 'compras',
            'usmodcspc' => 1089
        ];
        return Module::firstOrCreate($module);
    }

}
