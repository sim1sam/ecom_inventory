<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Country;
use App\Models\CountryState;
use App\Models\City;

class AddressController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's addresses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = Address::with('country', 'countryState', 'city')
            ->where('user_id', $user->id)
            ->get();

        return view('frontend.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('frontend.addresses.create', compact('countries'));
    }

    /**
     * Store a newly created address in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|exists:countries,id',
            'state' => 'required|exists:country_states,id',
            'city' => 'required|exists:cities,id',
            'address' => 'required|string|max:500',
            'zip_code' => 'nullable|string|max:20',
            'type' => 'required|in:home,office,other',
        ]);

        $user = Auth::user();
        $isExist = Address::where('user_id', $user->id)->count();

        $address = new Address();
        $address->user_id = auth()->id();
        $address->name = $request->name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->country_id = $request->country;
        $address->state_id = $request->state;
        $address->city_id = $request->city;
        $address->address = $request->address;
        $address->zip_code = $request->zip_code;
        $address->type = $request->type;
        $address->default_shipping = $isExist > 0 ? 0 : 1;
        $address->default_billing = $isExist > 0 ? 0 : 1;
        $address->save();

        return redirect()->route('addresses.index')
            ->with('success', 'Address created successfully!');
    }

    /**
     * Display the specified address.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();
        $address = Address::with('country', 'countryState', 'city')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('frontend.addresses.show', compact('address'));
    }

    /**
     * Show the form for editing the specified address.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $countries = Country::where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        $states = CountryState::where('status', 1)
            ->where('country_id', $address->country_id)
            ->orderBy('name', 'asc')
            ->get();

        $cities = City::where('status', 1)
            ->where('country_state_id', $address->state_id)
            ->orderBy('name', 'asc')
            ->get();

        return view('frontend.addresses.edit', compact('address', 'countries', 'states', 'cities'));
    }

    /**
     * Update the specified address in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|exists:countries,id',
            'state' => 'required|exists:country_states,id',
            'city' => 'required|exists:cities,id',
            'address' => 'required|string|max:500',
            'zip_code' => 'nullable|string|max:20',
            'type' => 'required|in:home,office,other',
        ]);

        $user = Auth::user();
        $address = Address::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $address->name = $request->name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->zip_code = $request->zip_code;
        $address->country_id = $request->country;
        $address->state_id = $request->state;
        $address->city_id = $request->city;
        $address->type = $request->type;
        $address->save();

        return redirect()->route('addresses.index')
            ->with('success', 'Address updated successfully!');
    }

    /**
     * Remove the specified address from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($address->default_billing == 1 && $address->default_shipping == 1) {
            return redirect()->route('addresses.index')
                ->with('error', 'Default address cannot be deleted.');
        }

        $address->delete();

        return redirect()->route('addresses.index')
            ->with('success', 'Address deleted successfully!');
    }

    /**
     * Get states by country ID (AJAX endpoint).
     *
     * @param  int  $countryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatesByCountry($countryId)
    {
        $states = CountryState::where('status', 1)
            ->where('country_id', $countryId)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return response()->json($states);
    }

    /**
     * Get cities by state ID (AJAX endpoint).
     *
     * @param  int  $stateId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCitiesByState($stateId)
    {
        $cities = City::where('status', 1)
            ->where('country_state_id', $stateId)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return response()->json($cities);
    }

    /**
     * Set address as default shipping.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDefaultShipping($id)
    {
        $user = Auth::user();
        
        // Remove default from all addresses
        Address::where('user_id', $user->id)
            ->update(['default_shipping' => 0]);

        // Set new default
        $address = Address::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
        $address->default_shipping = 1;
        $address->save();

        return redirect()->route('addresses.index')
            ->with('success', 'Default shipping address updated!');
    }

    /**
     * Set address as default billing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDefaultBilling($id)
    {
        $user = Auth::user();
        
        // Remove default from all addresses
        Address::where('user_id', $user->id)
            ->update(['default_billing' => 0]);

        // Set new default
        $address = Address::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
        $address->default_billing = 1;
        $address->save();

        return redirect()->route('addresses.index')
            ->with('success', 'Default billing address updated!');
    }
}