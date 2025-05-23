<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class RealtorListingAcceptOfferController extends Controller
{

    public function __invoke(Offer $offer)
    {
        $listing = $offer->listing;
        $this->authorize('update', $listing);

        $now = now();
        // ACCEPT SELECTED OFFER
        $offer->update(['accepted_at' => $now]);

        $listing->sold_at = $now;
        $listing->save();
        // REJECT ALL OTHER OFFERS
        $listing->offers()->except($offer)->update(['rejected_at' => $now]);

        return redirect()->back()->with('success', 'Offer #' . $offer->id . ' accepted, other offers rejected');
    }
}
