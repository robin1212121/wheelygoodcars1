<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;

class CarSearch extends Component
{
    public $search = '';

    public function render()
    {
        $cars = Car::with('user')
            ->where('status', 'available')
            ->when($this->search, function ($q) {
                $q->where('brand', 'like', "%{$this->search}%")
                  ->orWhere('model', 'like', "%{$this->search}%");
            })
            ->orderByDesc('views')
            ->get();

        return view('livewire.car-search', [
            'cars' => $cars
        ]);
    }
}