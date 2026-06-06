@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">🚨 Opvallende aanbieders</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">

            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Aantal auto's</th>
                    <th>Meldingen</th>
                    <th>Risico</th>
                </tr>
            </thead>

            <tbody>
                @foreach($result as $user)

                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->cars->count() }}</td>

                    <td>
                        @foreach($user->flags as $flag)
                            <span class="badge bg-warning text-dark">
                                {{ $flag }}
                            </span>
                        @endforeach
                    </td>

                    <td>
                        @php
                            $count = count($user->flags);
                        @endphp

                        @if($count >= 3)
                            <span class="badge bg-danger">
                                Hoog risico
                            </span>
                        @elseif($count == 2)
                            <span class="badge bg-warning text-dark">
                                Gemiddeld risico
                            </span>
                        @else
                            <span class="badge bg-success">
                                Laag risico
                            </span>
                        @endif
                    </td>

                </tr>

                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection