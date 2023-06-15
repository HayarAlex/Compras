<?php

namespace Liffe\Compras\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Liffe\Compras\Database\Seeds\DatabaseSeeder;

class InstallCommand extends Command
{
    protected $name = 'compras:install';
    protected $description = 'Install package Compras.';

    public function handle()
    {
        $this->info('Init installation package Compras');
//        Artisan::call('migrate', [
//            '--path' => 'packages/compras/src/database/migrations',
//        ]);
        Artisan::call('db:seed', [
            '--class' => DatabaseSeeder::class,
        ]);
        $this->info('Successfully installation package Compras :)');
    }
}
