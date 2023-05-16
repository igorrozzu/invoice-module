<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Seeders;

use App\Domain\Enums\StatusEnum;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $companies = DB::table('companies')->get();
        $products = DB::table('products')->get();

        $faker = Factory::create();

        $invoices = [];

        for ($i = 0; $i < 10; $i++) {
            $companyId = $companies->random()->id;
            do {
                $billedCompanyId = $companies->random()->id;
            } while ($companyId === $billedCompanyId);

            $invoices[] = [
                'id' => Uuid::uuid4()->toString(),
                'number' => $faker->numberBetween(1000, 9999),
                'date' => $faker->date(),
                'due_date' => $faker->date(),
                'company_id' => $companyId,
                'billed_company_id' => $billedCompanyId,
                'status' => StatusEnum::cases()[array_rand(StatusEnum::cases())],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('invoices')->insert($invoices);
        $this->addInvoiceProductLines($products, $invoices);
    }

    private function addInvoiceProductLines(Collection $products, array $invoices): void
    {

        $lines = [];

        foreach ($invoices ?? [] as $invoice) {
            $randomNumberOfProducts = rand(1, 5);
            $freshProducts = clone $products;

            for ($i = 0; $i < $randomNumberOfProducts; $i++) {
                $lines[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'invoice_id' => $invoice['id'],
                    'product_id' => $freshProducts->pop()->id,
                    'quantity' => rand(1, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('invoice_product_lines')->insert($lines);
    }
}
