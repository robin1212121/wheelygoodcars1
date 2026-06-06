<div>

    {{-- SEARCH BAR --}}
    <input type="text"
           class="form-control mb-4"
           placeholder="Zoek op merk of model..."
           wire:model.live="search">

    {{-- RESULTEN --}}
    <div class="row">

        @forelse($cars as $car)
            <div class="col-md-4 mb-3">
                <div class="card h-100"
                     onclick="window.location='{{ route('cars.show', $car) }}'"
                     style="cursor:pointer;">

                    <img src="{{ $car->image ?: asset('img/default-car.jpg') }}"
                         class="card-img-top"
                         style="height:200px; object-fit:cover;">

                    <div class="card-body">
                        <h5>{{ $car->brand }} {{ $car->model }}</h5>
                        <p>€ {{ number_format($car->price, 2) }}</p>
                        <p><strong>Views:</strong> {{ $car->views }}</p>
                    </div>

                </div>
            </div>
        @empty
            <p>Geen auto's gevonden</p>
        @endforelse

    </div>

</div>