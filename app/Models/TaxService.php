<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'category', 'summary', 'description', 'price_from', 'duration_minutes', 'active'])]
class TaxService extends Model
{
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'tax_service_id');
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'tax_service_id');
    }
}
