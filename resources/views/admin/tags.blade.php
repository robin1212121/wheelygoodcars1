@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h1 class="mb-4">
        Tag statistieken
    </h1>

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-striped">

                <thead>
                    <tr>
                        <th>Tag</th>
                        <th>Totaal gebruikt</th>
                        <th>Verkocht</th>
                        <th>Beschikbaar</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($tags as $tag)

                        <tr>

                            <td>
                                {{ $tag->name }}
                            </td>

                            <td>
                                {{ $tag->cars_count }}
                            </td>

                            <td>
                                {{ $tag->sold_count }}
                            </td>

                            <td>
                                {{ $tag->available_count }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection