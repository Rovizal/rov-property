<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'beds',
        'baths',
        'area',
        'city',
        'code',
        'street',
        'street_nr',
        'price'
    ];

    protected static $sortable = [
        'price',
        'created_at'
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'by_user_id');
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $this->orderByDesc('created_at');
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        return $query
            ->when($filters['priceFrom'] ?? false, fn($q, $value) => $q->where('price', '>=', $value))
            ->when($filters['priceTo'] ?? false, fn($q, $value) => $q->where('price', '<=', $value))
            ->when(
                $filters['beds'] ?? false,
                fn($q, $value) =>
                $q->where('beds', (int)$value < 6 ? '=' : '>=', $value)
            )
            ->when(
                $filters['baths'] ?? false,
                fn($q, $value) =>
                $q->where('baths', (int)$value < 6 ? '=' : '>=', $value)
            )
            ->when($filters['areaFrom'] ?? false, fn($q, $value) => $q->where('area', '>=', $value))
            ->when($filters['areaTo'] ?? false, fn($q, $value) => $q->where('area', '<=', $value))
            ->when($filters['deleted'] ?? false, fn($q) => $q->withTrashed())
            ->when(
                $filters['by'] ?? false,
                fn($q, $value) =>
                in_array($value, self::$sortable)
                    ? $q->orderBy($value, $filters['order'] ?? 'desc')
                    : $q // fallback: tidak melakukan sort jika field tidak valid
            );
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'listing_id');
    }

    public function scopeWithoutSold(Builder $query)
    {
        // return $query->doesntHave('offers')
        //     ->orWhereHas(
        //         'offers',
        //         fn(Builder $query) =>
        //         $query->whereNull('accepted_at')
        //             ->whereNull('rejected_at')
        //     );
        return $query->whereNull('sold_at');
    }
}
