<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Domain\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class Invoice
 *
 * @property string $id;
 * @property string $number;
 * @property Carbon $date;
 * @property Carbon $due_date;
 * @property string $company_id;
 * @property StatusEnum $status;
 * @property Carbon|null $created_at;
 * @property Carbon|null $updated_at;
 *
 * @property Company $company;
 * @property Company $billedCompany;
 * @property Collection $productLines;
 */
class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function billedCompany(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'billed_company_id');
    }

    public function productLines(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class);
    }

    protected $fillable = [
        'id',
        'status'
    ];

    protected $casts = [
        'status' => StatusEnum::class,
    ];
}
