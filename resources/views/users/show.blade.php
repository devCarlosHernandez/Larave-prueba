@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Productos de {{ $user->name }}</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->precio }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
