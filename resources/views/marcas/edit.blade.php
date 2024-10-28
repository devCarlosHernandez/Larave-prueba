@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-6">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h1 class="text-center">Editar Marca</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('marcas.update', $marca) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label" for="nombre">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $marca->nombre) }}" required>
                                @error('nombre')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label" for="producto-select">Producto Asociado:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="producto-select" name="producto_id" required>
                                    <option value="">Selecciona un producto</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}" 
                                            {{ $producto->id == $marca->producto_id ? 'selected' : '' }}>
                                            {{ $producto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="form-text">Selecciona un producto asociado a la marca</p>
                                @error('producto_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-sm-12 d-flex justify-content-center">
                                <a href="{{ route('marcas.index') }}" class="btn btn-danger me-3">Cancelar</a>
                                <button class="btn btn-success" type="submit">Actualizar Marca</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<script>
    $(document).ready(function(){
        $('#articles').DataTable();
    });
</script>
@endsection
