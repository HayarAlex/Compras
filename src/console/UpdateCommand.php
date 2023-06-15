<?php

namespace Liffe\Compras\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateCommand extends Command{

    protected $name = 'compras:update';
    protected $description = 'Update package Compras.';

    public function handle(){
        $this->info('Init update package Compras');
        Artisan::call('migrate', [
            '--path' => 'extensions/compras/src/database/migrations',
        ]);
        $this->info('Successfully update package Compras :)');
    }
}
