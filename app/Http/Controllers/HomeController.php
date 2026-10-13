<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarCategory;
use App\Models\Driver;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = CarCategory::withCount('cars')->get();
        
        $featuredCarsQuery = Car::with(['category', 'reviews'])
            ->where('status', '!=', 'nonaktif');

        if ($request->filled('category')) {
            $featuredCarsQuery->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('transmission')) {
            $featuredCarsQuery->where('transmission', $request->transmission);
        }

        if ($request->filled('capacity')) {
            $featuredCarsQuery->where('seating_capacity', '>=', $request->capacity);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $featuredCarsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $cars = $featuredCarsQuery->latest()->paginate(9)->withQueryString();
        $drivers = Driver::where('status', '!=', 'libur')->take(3)->get();
        $reviews = Review::with(['user', 'car'])->where('is_published', true)->latest()->take(6)->get();
        $companyName = Setting::get('company_name', 'PKD Rental Mobil');
        $companyTagline = Setting::get('company_tagline', 'Sewa Mobil Nyaman, Cepat & Terpercaya');

        return view('home', compact('categories', 'cars', 'drivers', 'reviews', 'companyName', 'companyTagline'));
    }

    public function carDetail($id)
    {
        $car = Car::with(['category', 'reviews.user'])->findOrFail($id);
        $relatedCars = Car::where('car_category_id', $car->car_category_id)
            ->where('id', '!=', $car->id)
            ->where('status', 'tersedia')
            ->take(3)
            ->get();
        $terms = Setting::get('rental_terms', '');

        return view('cars.detail', compact('car', 'relatedCars', 'terms'));
    }

    public function catalog(Request $request)
    {
        $categories = CarCategory::all();
        $query = Car::with(['category', 'reviews'])->where('status', '!=', 'nonaktif');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('fuel')) {
            $query->where('fuel_type', $request->fuel);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if ($request->sort == 'price_low') {
            $query->orderBy('price_per_day', 'asc');
        } elseif ($request->sort == 'price_high') {
            $query->orderBy('price_per_day', 'desc');
        } else {
            $query->latest();
        }

        $cars = $query->paginate(12)->withQueryString();

        return view('cars.catalog', compact('cars', 'categories'));
    }
}
