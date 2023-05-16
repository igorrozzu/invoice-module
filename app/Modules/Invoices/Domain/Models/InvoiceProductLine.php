<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class InvoiceProductLine
 *
 * @property string $id;
 * @property string $invoice_id;
 * @property string $product_id;
 * @property int $quantity;
 * @property Carbon|null $created_at;
 * @property Carbon|null $updated_at;
 *
 * @property Product $product;
 */
class InvoiceProductLine extends Model
{
    use HasFactory;

    protected $table = 'invoice_product_lines';

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
