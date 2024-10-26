@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Marca</h1>
    
    <form action="{{ route('marcas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
