<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Booking;
use App\Models\County;
use App\Models\OffenseCase;
use App\Models\Station;
use App\Models\User;
use App\Models\Officer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Yoeunes\Toastr\Toastr;
use Yoeunes\Toastr\ToastrFactory;

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
        $stations=Station::orderBy('station_name', 'asc')->get();
        $roles=Role::all();
      $counties = County::orderBy('name', 'asc')->get();
        return view('app.users.index', compact('users', 'search','stations','roles','counties'));
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
      $bookingsCounts=0;
        if ($officer){
            $bookings = Booking::where('officer_id', $officer->id)
                ->orderBy('created_at', 'desc')
                ->take(15)
                ->get();
            $bookingsCounts = Booking::where('officer_id', $officer->id)->count();
        }
        return view('app.user.view-account', ['title' => 'User Profile', 'breadcrumb' => 'Account Profile', 'user'=>$user, 'bookings'=>$bookings, 'officer'=>$officer, 'activities'=>$activities, 'bookingsCounts'=>$bookingsCounts]);
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
    public function store(Request $request): RedirectResponse
    {
      $this->authorize('create', User::class);
      try {
      $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'phone_number' => 'required|string|max:255',
        'id_no' => 'required|numeric|unique:users',
        'gender' => 'required|string|in:Male,Female,Other',
        'status' => 'required|string|in:active,suspended',
        'station_id' => 'required|exists:stations,id',
        'role_id' => 'required|exists:roles,id',
        'county' => 'required|exists:counties,id',
        'subcounty_id' => 'required|exists:subcounties,id',
        'ward' => 'required|exists:wards,id',
      ]);
      $user = User::create([
        'name' => $request->input('name'),
        'id_no' => $request->input('id_no'),
        'phone_number' => $request->input('phone_number'),
        'email' => $request->input('email'),
        'password'=>$request->input('id_no'),
        'gender' => $request->input('gender'),
        'status' => $request->input('status'),
        'station_id' => $request->input('station_id'),
        'county' => $request->input('county'),
        'subcounty_id' => $request->input('subcounty_id'),
        'ward' => $request->input('ward'),
      ]);

        $user->syncRoles($request->roles_id);
      Activity::create([
        'section'=>'Add User',
        'action'=>'Adding New User',
        'target'=>'Web',
        'user_id'=>Auth::user()->id
      ]);

        return redirect()
            ->back()
            ->withSuccess(__('User created successfully'));
      } catch (\Exception $e) {

        return redirect()->back()->withInput()->withErrors(['An error occurred while creating the user. Please try again.']);
      }
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
