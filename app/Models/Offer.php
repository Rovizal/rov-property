<?php

namespace App\Models;

use Auth;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'accepted_at', 'rejected_at'];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function bidder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bidder_id');
    }

    public function scopeByMe(Builder $query)
    {
        return $query->where('bidder_id', Auth::user()->id ?? null);
    }

    public function scopeExcept(Builder $query, Offer $offer)
    {
        $query->where('id', '!=', $offer->id);
    }
}
