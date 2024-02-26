<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\Region;
use App\Models\Station;
use App\Models\Officer;
use Illuminate\View\View;
use App\Models\Subcounty;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StationStoreRequest;
use App\Http\Requests\StationUpdateRequest;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Station::class);

        $search = $request->get('search', '');

        $stations = Station::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.stations.index', compact('stations', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Station::class);

        $regions = Region::pluck('name', 'id');
        $officers = Officer::pluck('officer_name', 'id');
        $subcounties = Subcounty::pluck('subcounty_name', 'id');
        $wards = Ward::pluck('name', 'id');

        return view(
            'app.stations.create',
            compact('regions', 'officers', 'subcounties', 'wards')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StationStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Station::class);

        $validated = $request->validated();

        $station = Station::create($validated);

        return redirect()
            ->route('stations.edit', $station)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Station $station): View
    {
        $this->authorize('view', $station);

        return view('app.stations.show', compact('station'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Station $station): View
    {
        $this->authorize('update', $station);

        $regions = Region::pluck('name', 'id');
        $officers = Officer::pluck('officer_name', 'id');
        $subcounties = Subcounty::pluck('subcounty_name', 'id');
        $wards = Ward::pluck('name', 'id');

        return view(
            'app.stations.edit',
            compact('station', 'regions', 'officers', 'subcounties', 'wards')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StationUpdateRequest $request,
        Station $station
    ): RedirectResponse {
        $this->authorize('update', $station);

        $validated = $request->validated();

        $station->update($validated);

        return redirect()
            ->route('stations.edit', $station)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Station $station
    ): RedirectResponse {
        $this->authorize('delete', $station);

        $station->delete();

        return redirect()
            ->route('stations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
