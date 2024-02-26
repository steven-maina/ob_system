<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Booking;
use App\Models\OffenseCase;
use App\Models\User;
use App\Models\Officer;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', User::class);

        $search = $request->get('search', '');

        $users = User::search($search)
            ->latest()
            ->paginate(25)
            ->withQueryString();
        return view('app.users.index', compact('users', 'search'));
    }
    public function profile(Request $request): View
    {
      $user = User::with('county', 'subcounty', 'ward')->findOrFail(Auth::user()->id);
      $officer = Officer::where('user_id', $user->id)->with('station')->first();
      $activities = Activity::where('user_id', $user->id)
        ->latest('created_at')
        ->take(10)
        ->get();

      $bookings=[];
        if ($officer){
            $bookings = Booking::where('officer_id', $officer->id)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->get();
        }
        return view('app.user.view-account', ['title' => 'User Profile', 'breadcrumb' => 'Account Profile', 'user'=>$user, 'bookings'=>$bookings, 'officer'=>$officer, 'activities'=>$activities]);
    }
    public function settings(Request $request): View
    {
      $user = User::with('county', 'subcounty', 'ward')->findOrFail(Auth::user()->id);

      $officer = Officer::where('user_id', $user->id)->with('station')->first();

      $bookings=[];
        if ($officer){
            $bookings = Booking::where('officer_id', $officer->id)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->get();
            }

        return view('app.user.account-settings', ['title' => 'User Account Settings', 'breadcrumb' => 'Account Settings', 'user'=>$user, 'bookings'=>$bookings]);
    }
 public function userSecurity(Request $request): View
    {
        $user = User::findOrFail(Auth::user()->id);
        $officer = Officer::where('user_id', $user->id)->first();
        $bookings=[];
        if ($officer){
            $bookings = Booking::where('officer_id', $officer->id)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->get();
            }
        return view('app.user.security', ['title' => 'User Account Settings', 'breadcrumb' => 'Account Settings', 'user'=>$user, 'bookings'=>$bookings]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', User::class);

        $officers = Officer::pluck('officer_name', 'id');

        $roles = Role::get();

        return view('app.users.create', compact('officers', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user): View
    {
        $this->authorize('view', $user);

        return view('app.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user): View
    {
        $this->authorize('update', $user);

        $officers = Officer::pluck('officer_name', 'id');

        $roles = Role::get();

        return view('app.users.edit', compact('user', 'officers', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UserUpdateRequest $request,
        User $user
    ): RedirectResponse {
        $this->authorize('update', $user);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
