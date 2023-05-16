<?php

namespace Database\Seeders;

use \App\Modules\Invoices\Infrastructure\Database\Seeders\DatabaseSeeder as InvoiceDatabaseSeeder;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    private InvoiceDatabaseSeeder $invoiceSeeder;

    public function __construct()
    {
        $this->invoiceSeeder = app(InvoiceDatabaseSeeder::class);
    }

    public function run(): void
    {
        $this->invoiceSeeder->run();
    }
}
