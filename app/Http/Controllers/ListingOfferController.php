<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Notifications\OfferMade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        if (!Gate::allows('makeOffer', $listing)) {
            // custom response tanpa exception
            return redirect()->back()->with([
                'error' => 'You are not allowed to make an offer on this listing.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:1|max:20000000'
        ], [
            'amount.required' => 'Amount is required.',
            'amount.integer' => 'Amount must be a number.',
            'amount.min' => 'Too low.',
            'amount.max' => 'Too high.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => 'Complete the form'
            ]);
        }

        $offer = $listing->offers()->save(
            Offer::make(
                $request->validate([
                    'amount' => 'required|integer|min:1|max:20000000'
                ])
            )->bidder()->associate($request->user())
        );

        $listing->owner->notify(
            new OfferMade($offer)
        );

        return redirect()->back()->with(
            'success',
            'Offer has been made!'
        );
    }
}
