<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Car;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function tags()
    {
        $tags = Tag::withCount([
            'cars',

            'cars as sold_count' => function ($query) {
                $query->where('status', 'sold');
            },

            'cars as available_count' => function ($query) {
                $query->where('status', 'available');
            }
        ])->get();

        return view('admin.tags', compact('tags'));
    }

    public function suspiciousUsers()
    {
        $result = User::with(['cars.tags'])
            ->get()
            ->map(function ($user) {

                $flags = [];

                if (empty($user->phone)) {
                    $flags[] = 'Geen telefoonnummer';
                }

                $suspiciousCars = $user->cars->filter(function ($car) {
                    return (date('Y') - $car->production_year) > 10
                        && $car->mileage < 10000;
                });

                if ($suspiciousCars->count() > 0) {
                    $flags[] = 'Oude auto met lage km-stand';
                }

                $sameDaySold = $user->cars->filter(function ($car) {
                    return $car->sold_at
                        && $car->price > 10000
                        && Carbon::parse($car->created_at)
                            ->isSameDay(Carbon::parse($car->sold_at));
                });

                if ($sameDaySold->count() > 3) {
                    $flags[] = 'Meer dan 3 direct verkochte auto\'s';
                }

                if (
                    $user->cars->count() > 0 &&
                    $user->cars->every(fn($car) => $car->price < 1000)
                ) {
                    $flags[] = 'Alle auto\'s onder €1000';
                }

                $carsWithTags = $user->cars->filter(
                    fn($car) => $car->tags->count() > 0
                );

                if (
                    $user->cars->count() > 0 &&
                    $carsWithTags->count() === 0
                ) {
                    $flags[] = 'Geen tags gebruikt';
                }

                $lastCar = $user->cars->sortByDesc('created_at')->first();

                if (
                    $lastCar &&
                    Carbon::parse($lastCar->created_at)->lt(now()->subYear())
                ) {
                    $flags[] = '1 jaar geen nieuwe auto';
                }

                $user->flags = $flags;

                return $user;
            })
            ->filter(fn($user) => count($user->flags) > 0);

        return view('admin.suspicious', compact('result'));
    }

    public function dashboardData()
    {
        return response()->json([
            'totalCars' => Car::count(),

            'soldCars' => Car::where('status', 'sold')->count(),

            'availableCars' => Car::where('status', 'available')->count(),

            'todayCars' => Car::whereDate('created_at', today())->count(),

            'totalSellers' => User::count(),

            'avgCarsPerSeller' => User::count() > 0
                ? round(Car::count() / User::count(), 1)
                : 0,

            'soldPercent' => Car::count() > 0
                ? round(
                    Car::where('status', 'sold')->count()
                    / Car::count() * 100
                )
                : 0
        ]);
    }
}