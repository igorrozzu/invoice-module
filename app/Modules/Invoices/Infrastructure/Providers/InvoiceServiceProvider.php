<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Application\Services\InvoiceInterface;
use App\Modules\Invoices\Application\Services\InvoiceService;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepository;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->bind(InvoiceInterface::class, InvoiceService::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            InvoiceInterface::class,
            InvoiceRepositoryInterface::class
        ];
    }
}
