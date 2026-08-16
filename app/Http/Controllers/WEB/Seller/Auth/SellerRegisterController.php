<?php

namespace App\Http\Controllers\WEB\Seller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Setting;
use App\Models\Country;
use App\Models\CountryState;
use App\Models\City;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;

class SellerRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the seller registration form.
     */
    public function showRegistrationForm()
    {
        $setting = Setting::first();
        $countries = Country::where('status', 1)->orderBy('name', 'asc')->get();
        
        return view('frontend.seller.register', compact('setting', 'countries'));
    }

    /**
     * Handle seller registration request.
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:country_states,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:500',
            'shop_name' => 'required|string|max:255|unique:vendors',
            'shop_email' => 'required|string|email|max:255|unique:vendors,email',
            'shop_phone' => 'required|string|max:20',
            'shop_address' => 'required|string|max:500',
            'open_at' => 'required|string',
            'closed_at' => 'required|string',
            'agree_terms_condition' => 'required|accepted'
        ];

        $customMessages = [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'phone.required' => 'Phone is required',
            'country_id.required' => 'Country is required',
            'state_id.required' => 'State is required',
            'city_id.required' => 'City is required',
            'address.required' => 'Address is required',
            'shop_name.required' => 'Shop name is required',
            'shop_name.unique' => 'Shop name already exists',
            'shop_email.required' => 'Shop email is required',
            'shop_email.unique' => 'Shop email already exists',
            'shop_phone.required' => 'Shop phone is required',
            'shop_address.required' => 'Shop address is required',
            'open_at.required' => 'Opening time is required',
            'closed_at.required' => 'Closing time is required',
            'agree_terms_condition.required' => 'You must agree to terms and conditions'
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Create user account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'status' => 1,
                'is_vendor' => 1,
                'verify_token' => Str::random(100),
                'email_verified_at' => now() // Auto-verify for sellers
            ]);

            // Create vendor/seller account
            $vendor = new Vendor();
            $vendor->user_id = $user->id;
            $vendor->shop_name = $request->shop_name;
            $vendor->slug = Str::slug($request->shop_name);
            $vendor->email = $request->shop_email;
            $vendor->phone = $request->shop_phone;
            $vendor->address = $request->shop_address;
            $vendor->open_at = $request->open_at;
            $vendor->closed_at = $request->closed_at;
            $vendor->status = 0; // Pending approval
            $vendor->is_featured = 0;
            $vendor->top_rated = 0;
            $vendor->verified_token = Str::random(100);
            $vendor->save();

            $notification = 'Registration successful! Your seller account is pending approval.';
            return redirect()->route('seller.login')->with('success', $notification);

        } catch (\Exception $e) {
            $notification = 'Registration failed. Please try again.';
            return redirect()->back()->with('error', $notification)->withInput();
        }
    }

    /**
     * Get states by country ID (AJAX)
     */
    public function getStatesByCountry($countryId)
    {
        $states = CountryState::where('country_id', $countryId)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
        
        return response()->json($states);
    }

    /**
     * Get cities by state ID (AJAX)
     */
    public function getCitiesByState($stateId)
    {
        $cities = City::where('country_state_id', $stateId)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
        
        return response()->json($cities);
    }
}