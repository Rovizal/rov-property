<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Auth;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'priceFrom',
            'priceTo',
            'beds',
            'baths',
            'areaFrom',
            'areaTo'
        ]);

        return inertia('Listing/Index', [
            'listings'  => Listing::mostRecent()
                ->filter($filters)
                ->withoutSold()
                ->paginate(10)
                ->withQueryString(),
            'filters'   => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create', Listing::class);
        return inertia('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'beds'      => 'required|integer|min:0|max:20',
            'baths'     => 'required|integer|min:0|max:20',
            'area'      => 'required|numeric|min:0',
            'street'    => 'required|string',
            'code'      => 'required|numeric|min:0',
            'street_nr' => 'required|numeric|min:0',
            'city'      => 'required|string',
            'price'     => 'required|numeric|min:0',
        ]);

        // Listing::create($validated);
        $request->user()->listings()->create($validated);

        return redirect()->route('listing.index')->with('success', 'Listing was created!');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     return inertia('Listing/Show', [
    //         'listing' => Listing::find($id)
    //     ]);
    // }

    public function show(Listing $listing)
    {
        // Auth::user()->can('view', $listing);
        // if (Auth::user()->cannot('view', $listing)) {
        //     abort(403);
        // }
        // $this->authorize('view', $listing);
        $listing->load('images');
        $offer = !Auth::user() ? null : $listing->offers()->byMe()->first();

        return inertia('Listing/Show', [
            'listing' => $listing,
            'offerMade' => $offer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return inertia(
            'Listing/Edit',
            [
                'listing' => $listing
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $validated = $request->validate([
            'beds'      => 'required|integer|min:0|max:20',
            'baths'     => 'required|integer|min:0|max:20',
            'area'      => 'required|integer|min:15|max:1500',
            'city'      => 'required',
            'code'      => 'required',
            'street'    => 'required',
            'street_nr' => 'required|min:1|max:1000',
            'price'     => 'required|integer|min:1|max:20000000000',
        ]);

        $listing->update($validated);

        return redirect()->route('listing.index')
            ->with('success', 'Listing was changed!');
    }
}
