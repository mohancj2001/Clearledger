<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'tax_service_id', 'scheduled_at', 'status', 'notes'])]
class Appointment extends Model
{
    protected function casts(): array
    {
        return ['scheduled_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(TaxService::class, 'tax_service_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(CustomerDocument::class);
    }
}
