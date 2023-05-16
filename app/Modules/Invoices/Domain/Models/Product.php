<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Product
 *
 * @property string $id;
 * @property string $name;
 * @property int $price;
 * @property string $currency;
 * @property Carbon|null $created_at;
 * @property Carbon|null $updated_at;
 *
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function invoiceProductLines(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class);
    }
}
