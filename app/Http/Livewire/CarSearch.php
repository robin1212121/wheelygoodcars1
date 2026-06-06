<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Car;

class CarSearch extends Component
{
    public $search = '';

    public function render()
    {
        $cars = Car::query()
            ->where('status', 'available')
            ->where(function ($query) {
                $query->where('brand', 'like', '%' . $this->search . '%')
                      ->orWhere('model', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        return view('livewire.car-search', [
            'cars' => $cars
        ]);
    }
}