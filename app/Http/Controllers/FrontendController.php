<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\Order;
use App\Models\BannerImage;
use App\Models\HomePageOneVisibility;
use App\Models\PopularCategory;
use App\Models\FeaturedCategory;
use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\StripePayment;
use App\Models\PaypalPayment;
use App\Models\RazorpayPayment;
use App\Models\Flutterwave;
use App\Models\PaystackAndMollie;
use App\Models\InstamojoPayment;
use App\Models\SslcommerzPayment;
use App\Models\BankPayment;
use App\Models\Blog;
use App\Models\SeoSetting;
use App\Models\ContactPage;
use App\Models\AboutUs;
use App\Models\Faq;
use App\Models\CustomPage;
use App\Models\TermsAndCondition;

use Cart;
use Session;

class FrontendController extends Controller
{
    public function index()
    {
        // Fetch homepage data dynamically from admin panel
        $setting = Setting::first();
        $homePageVisibility = HomePageOneVisibility::first();
        
        // SEO settings for homepage
        $seoSetting = SeoSetting::find(1);
        
        // Sliders
        $sliders = Slider::where('status', 1)->orderBy('serial', 'asc')->get();
        
        // Banner Images - Fetch specific four banners from admin advertisement
        $bannerImages = BannerImage::whereIn('id', [16, 17, 18, 19])
            ->where('status', 1)
            ->orderBy('id', 'asc')
            ->get();
        
        // Categories (check visibility setting)
        $categories = Category::with('products')
            ->withCount('products')
            ->where('status', 1);
        
        if ($homePageVisibility && $homePageVisibility->category_section_status) {
            $categories = $categories->take($homePageVisibility->category_qty ?? 4);
        } else {
            $categories = $categories->take(4);
        }
        $categories = $categories->get();
        
        // Popular Categories
        $popularCategories = PopularCategory::with('category')
            ->get();
            
        // Featured Categories
        $featuredCategories = FeaturedCategory::with(['category.products' => function($query) {
            $query->where('status', 1)->where('approve_by_admin', 1);
        }])->get();
            
        // Top Products for "Our Products" section - Show last 8 highlighted/top products
        $products = Product::with(['category', 'brand', 'reviews'])
            ->where('status', 1)
            ->where('is_top', 1)
            ->where('approve_by_admin', 1)
            ->latest()
            ->take(8)
            ->get();
            
        // Featured Products
        $featuredProducts = Product::with(['category', 'brand', 'reviews'])
            ->where('status', 1)
            ->where('is_featured', 1)
            ->where('show_homepage', 1)
            ->where('approve_by_admin', 1)
            ->take(4)
            ->get();
            
        // New Arrival Products - Show last 4 newest products
        $newArrivalProducts = Product::with(['category', 'brand', 'reviews'])
            ->where('status', 1)
            ->where('approve_by_admin', 1)
            ->latest()
            ->take(4)
            ->get();
            
        // Best Products - Show 4 best products
        $bestProducts = Product::with(['category', 'brand', 'reviews'])
            ->where('status', 1)
            ->where('is_best', 1)
            ->where('approve_by_admin', 1)
            ->take(4)
            ->get();
        
        // Flash Sale
        $flashSale = FlashSale::where('status', 1)
            ->where('end_time', '>=', now())
            ->first();
        $flashSaleProducts = collect();
        if ($flashSale) {
            $flashSaleProducts = FlashSaleProduct::with(['product.category', 'product.brand'])
                ->where('status', 1)
                ->whereHas('product', function($query) {
                    $query->where('status', 1)->where('approve_by_admin', 1);
                })
                ->get();
        }
            
        // Brands
        $brands = Brand::where('status', 1)
            ->take(6)
            ->get();
            
        // Services
        $services = Service::where('status', 1)->get();
        
        // Testimonials
        $testimonials = Testimonial::where('status', 1)->get();
            
        // Blogs
        $blogs = Blog::where('status', 1)
            ->latest()
            ->take(3)
            ->get();
        
        return view('frontend.home', compact(
            'categories', 
            'products',
            'featuredProducts',
            'newArrivalProducts',
            'bestProducts',
            'brands',
            'blogs',
            'sliders',
            'bannerImages',
            'popularCategories',
            'featuredCategories',
            'flashSale',
            'flashSaleProducts',
            'services',
            'testimonials',
            'setting',
            'homePageVisibility',
            'seoSetting'
        ));
    }
    
    public function products(Request $request)
    {
        $query = Product::with(['category', 'brand', 'reviews'])
            ->where('status', 1)
            ->where('approve_by_admin', 1);
            
        // Category filter - handle both slug and ID for backward compatibility
        if ($request->has('category') && $request->category) {
            $categories = explode(',', $request->category);
            
            // Check if categories are slugs or IDs
            $categoryIds = [];
            $subCategoryIds = [];
            
            foreach ($categories as $category) {
                if (is_numeric($category)) {
                    // It's an ID - check if it's a category or subcategory
                    $categoryModel = Category::find($category);
                    if ($categoryModel) {
                        $categoryIds[] = $category;
                    } else {
                        // Check if it's a subcategory ID
                        $subCategoryModel = SubCategory::find($category);
                        if ($subCategoryModel) {
                            $subCategoryIds[] = $category;
                        }
                    }
                } else {
                    // It's a slug - check if it's a category or subcategory slug
                    $categoryModel = Category::where('slug', $category)->first();
                    if ($categoryModel) {
                        $categoryIds[] = $categoryModel->id;
                    } else {
                        // Check if it's a subcategory slug
                        $subCategoryModel = SubCategory::where('slug', $category)->first();
                        if ($subCategoryModel) {
                            $subCategoryIds[] = $subCategoryModel->id;
                        }
                    }
                }
            }
            
            // Apply filters based on what we found
            if (!empty($categoryIds) && !empty($subCategoryIds)) {
                // Both categories and subcategories selected
                $query->where(function($q) use ($categoryIds, $subCategoryIds) {
                    $q->whereIn('category_id', $categoryIds)
                      ->orWhereIn('sub_category_id', $subCategoryIds);
                });
            } elseif (!empty($categoryIds)) {
                // Only categories selected
                $query->whereIn('category_id', $categoryIds);
            } elseif (!empty($subCategoryIds)) {
                // Only subcategories selected
                $query->whereIn('sub_category_id', $subCategoryIds);
            }
        }
        
        // Brand filter
        if ($request->has('brand') && $request->brand) {
            $brands = explode(',', $request->brand);
            $query->whereIn('brand_id', $brands);
        }
        
        // Price range filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where(function($q) use ($request) {
                $q->where('offer_price', '>=', $request->min_price)
                  ->orWhere(function($subQ) use ($request) {
                      $subQ->whereNull('offer_price')
                           ->where('price', '>=', $request->min_price);
                  });
            });
        }
        
        if ($request->has('max_price') && $request->max_price) {
            $query->where(function($q) use ($request) {
                $q->where('offer_price', '<=', $request->max_price)
                  ->orWhere(function($subQ) use ($request) {
                      $subQ->whereNull('offer_price')
                           ->where('price', '<=', $request->max_price);
                  });
            });
        }
        
        // Rating filter
        if ($request->has('rating') && $request->rating) {
            $query->whereHas('reviews', function($q) use ($request) {
                $q->selectRaw('product_id, AVG(rating) as avg_rating')
                  ->groupBy('product_id')
                  ->havingRaw('AVG(rating) >= ?', [$request->rating]);
            });
        }
        
        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('short_description', 'LIKE', "%{$search}%")
                  ->orWhere('tags', 'LIKE', "%{$search}%");
            });
        }
        
        // Product type filter (featured, new, top)
        if ($request->has('filter') && $request->filter) {
            switch ($request->filter) {
                case 'featured':
                    $query->where('is_featured', 1)->where('show_homepage', 1);
                    break;
                case 'new':
                    // For new arrivals, we can either use a specific flag or just show latest products
                    // Since there's no specific 'new' flag, we'll show latest products
                    $query->latest();
                    break;
                case 'top':
                    $query->where('is_top', 1);
                    break;
                case 'best':
                    $query->where('is_best', 1);
                    break;
                case 'flash_sale':
                    // Filter products that are part of active flash sales
                    // Use FlashSaleProduct directly to fetch product IDs of active items
                    $flashSaleProductIds = FlashSaleProduct::where('status', 1)
                        ->whereHas('product', function($q) {
                            $q->where('status', 1)->where('approve_by_admin', 1);
                        })
                        ->pluck('product_id');

                    if ($flashSaleProductIds->isNotEmpty()) {
                        $query->whereIn('id', $flashSaleProductIds);
                    } else {
                        // If no active flash sale items, return empty result
                        $query->whereRaw('1 = 0');
                    }
                    break;
            }
        }
        
        // Sorting
        $sort = $request->get('sort', 'name');
        switch ($sort) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price':
                $query->orderByRaw('COALESCE(offer_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(offer_price, price) DESC');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
                break;
        }
        
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        
        // Get setting for currency
        $setting = Setting::first();
        
        return view('frontend.products', compact('products', 'categories', 'brands', 'setting'));
    }
    
    public function productDetail(Request $request, $slug)
    {
        if (!$slug) {
            abort(404, 'Product not found');
        }
        
        // Get product by slug with relationships
        $product = Product::where('slug', $slug)
            ->where('status', 1)
            ->where('approve_by_admin', 1)
            ->with([
                'category', 
                'brand', 
                'gallery', 
                'specifications.key', 
                'reviews' => function($query) {
                    $query->where('status', 1)->with('user')->latest();
                },
                'variants.variantItems'
            ])
            ->firstOrFail();
        
        // Calculate average rating
        $product->averageRating = $product->reviews->avg('rating') ?? 0;
        
        // Get related products from same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->where('approve_by_admin', 1)
            ->with(['category', 'brand'])
            ->limit(4)
            ->get();
        
        // Get SEO settings
        $seoSetting = SeoSetting::first();
        
        // Get setting for currency
        $setting = Setting::first();
        
        return view('frontend.product-detail', compact('product', 'relatedProducts', 'seoSetting', 'setting'));
    }
    
    public function getRecommendedProducts()
    {
        // Get random featured or popular products for cart recommendations
        $recommendedProducts = Product::where('status', 1)
            ->where('approve_by_admin', 1)
            ->where(function($query) {
                $query->where('is_featured', 1)
                      ->orWhere('is_top', 1)
                      ->orWhere('is_best', 1);
            })
            ->with(['category', 'brand'])
            ->inRandomOrder()
            ->limit(3)
            ->get();
            
        return response()->json([
            'success' => true,
            'products' => $recommendedProducts
        ]);
    }
    
    public function category($slug)
    {
        $category = Category::with(['subCategories' => function($query) {
            $query->where('status', 1)->with('products');
        }])->where('slug', $slug)->firstOrFail();
        
        // Build query for products
        $query = Product::where('category_id', $category->id)
            ->where('status', 1)
            ->where('approve_by_admin', 1)
            ->with(['category', 'brand', 'reviews']);
        
        // Apply sorting
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->paginate(12)->withQueryString();
        
        // Get setting for currency
        $setting = Setting::first();
        
        return view('frontend.category', compact('category', 'products', 'setting'));
    }
    
    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        
        // Get categories that have products from this brand
        $brandCategories = Category::whereHas('products', function($query) use ($brand) {
            $query->where('brand_id', $brand->id)->where('status', 1);
        })->with('products')->get();
        
        // Build query for products
        $query = Product::where('brand_id', $brand->id)
            ->where('status', 1)
            ->where('approve_by_admin', 1)
            ->with(['category', 'brand', 'reviews']);
        
        // Apply price filter
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }
        
        // Apply category filter
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
        
        // Apply sorting
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->paginate(12)->withQueryString();
        
        // Get setting for currency
        $setting = Setting::first();
        
        return view('frontend.brand', compact('brand', 'products', 'brandCategories', 'setting'));
    }
    
    public function about()
    {
        $aboutUs = AboutUs::first();
        return view('frontend.about', compact('aboutUs'));
    }
    
    public function contact()
    {
        $contactPage = ContactPage::first();
        return view('frontend.contact', compact('contactPage'));
    }
    
    public function cart()
    {
        $setting = Setting::first();
        return view('frontend.cart', compact('setting'));
    }

    public function checkout()
    {
        $countries = \App\Models\Country::where('status', 1)->get();
        $states = \App\Models\CountryState::where('status', 1)->get();
        $cities = \App\Models\City::where('status', 1)->get();
        $shippingMethods = \App\Models\Shipping::all();
        
        // Get user addresses if authenticated
        $addresses = collect();
        if (auth()->check()) {
            $addresses = \App\Models\Address::with('country','countryState','city')
                ->where(['user_id' => auth()->id()])
                ->get();
        }
        
        // Get payment gateway settings
        $stripe_setting = \App\Models\StripePayment::first();
        $paypal_setting = \App\Models\PaypalPayment::first();
        $razorpay_setting = \App\Models\RazorpayPayment::first();
        $flutterwave_setting = \App\Models\Flutterwave::first();
        $mollie_setting = \App\Models\PaystackAndMollie::first();
        $instamojo_setting = \App\Models\InstamojoPayment::first();
        $paystack_setting = \App\Models\PaystackAndMollie::first();
        $sslcommerz_setting = \App\Models\SslcommerzPayment::first();
        $bank_payment_setting = \App\Models\BankPayment::first();
        
        return view('frontend.checkout', compact(
            'countries', 
            'states', 
            'cities', 
            'shippingMethods', 
            'addresses',
            'stripe_setting',
            'paypal_setting',
            'razorpay_setting',
            'flutterwave_setting',
            'mollie_setting',
            'instamojo_setting',
            'paystack_setting',
            'sslcommerz_setting',
            'bank_payment_setting'
        ));
    }

    public function orderSuccess(Request $request)
    {
        $encodedOrderId = $request->get('order');
        
        if (!$encodedOrderId) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }
        
        // Decode the order ID
        $orderNumber = decodeOrderId($encodedOrderId);
        
        if (!$orderNumber) {
            return redirect()->route('home')->with('error', 'Invalid order reference.');
        }
        
        // Find the order by order_id
        $order = Order::with(['orderProducts.product.category', 'user', 'orderAddress'])
            ->where('order_id', $orderNumber)
            ->first();
            
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }
        
        // Get settings for currency and other configurations
        $setting = Setting::first();
        
        // Clear guest cart after successful order
        if (!Auth::check()) {
            Session::forget('guest_cart');
        }
        
        // Display the order success page with order details
        return view('frontend.order-success', compact('order', 'setting'));
    }
    
    public function blog()
    {
        $blogs = Blog::where('status', 1)->orderBy('id', 'desc')->paginate(9);
        return view('frontend.blog', compact('blogs'));
    }
    
    public function blogDetail($slug)
    {
        $blog = Blog::where(['slug' => $slug, 'status' => 1])->firstOrFail();
        $recentBlogs = Blog::where('status', 1)->where('id', '!=', $blog->id)
            ->orderBy('id', 'desc')->take(5)->get();
            
        return view('frontend.blog-detail', compact('blog', 'recentBlogs'));
    }
    
    public function faq()
    {
        $faqs = Faq::where('status', 1)->get();
        return view('frontend.faq', compact('faqs'));
    }
    
    public function customPage($slug)
    {
        $page = CustomPage::where(['slug' => $slug, 'status' => 1])->firstOrFail();
        return view('frontend.custom-page', compact('page'));
    }
    
    public function termsConditions()
    {
        $termsCondition = TermsAndCondition::first();
        return view('frontend.terms-conditions', compact('termsCondition'));
    }
    
    public function privacyPolicy()
    {
        $privacyPolicy = TermsAndCondition::first();
        return view('frontend.privacy-policy', compact('privacyPolicy'));
    }
    
    public function orderDetails(Request $request, $order_id)
    {
        // Find the order by order_id and ensure it belongs to the authenticated user
        $order = Order::with(['orderProducts.product.category', 'user', 'orderAddress'])
            ->where('order_id', $order_id)
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found or you do not have permission to view this order.');
        }
        
        $setting = Setting::first();
        
        // Get payment gateway settings for the payment options
        $stripe_setting = StripePayment::first();
        $paypal_setting = PaypalPayment::first();
        $razorpay_setting = RazorpayPayment::first();
        $flutterwave_setting = Flutterwave::first();
        $mollie_setting = PaystackAndMollie::first(); // This model handles both Paystack and Mollie
        $instamojo_setting = InstamojoPayment::first();
        $paystack_setting = PaystackAndMollie::first(); // Same model as mollie
        $sslcommerz_setting = SslcommerzPayment::first();
        $bank_payment_setting = BankPayment::first();
        
        return view('frontend.order-details', compact(
            'order', 
            'setting',
            'stripe_setting',
            'paypal_setting', 
            'razorpay_setting',
            'flutterwave_setting',
            'mollie_setting',
            'instamojo_setting',
            'paystack_setting',
            'sslcommerz_setting',
            'bank_payment_setting'
        ));
    }
}