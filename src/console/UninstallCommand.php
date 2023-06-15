<?php

namespace Liffe\Compras\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UninstallCommand extends Command
{
    protected $name = 'compras:uninstall';
    protected $description = 'Uninstall package Compras !!!.';

    public function handle()
    {
        $this->info('Uninstall package Compras !!!');
        Artisan::call('migrate:rollback', [
            '--path' => 'packages/compras/src/database/migrations',
        ]);
        $this->info('Uninstall package Compras :)');
    }
}