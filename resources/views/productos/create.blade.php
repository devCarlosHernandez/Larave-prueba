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
                    <h1 class="text-center">Agregar Nuevo Producto</h1>
                    <small class="text-muted float-end">productos</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.store') }}" method="POST">
                        @csrf

                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label" for="nombre">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                                @error('nombre')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label" for="descripcion">Descripción:</label>
                            <div class="col-sm-10">
                                <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                                @error('descripcion')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label" for="precio">Precio:</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
                                @error('precio')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label" for="marca_id">Marca:</label>
                            <div class="col-sm-10">
                                <select name="marca_id" id="marca_id" class="form-control">
                                    <option value="">Selecciona una Marca</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('marca_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label" for="categoria_id">Categoría:</label>
                            <div class="col-sm-10">
                                <select name="categoria_id" id="categoria_id" class="form-control">
                                    <option value="">Seleccione una categoría (opcional)</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label">Proveedores:</label>
                            <div class="col-sm-10">
                                @foreach($proveedores as $proveedor)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="proveedor_id[]" id="proveedor_{{ $proveedor->id }}" value="{{ $proveedor->id }}">
                                        <label class="form-check-label" for="proveedor_{{ $proveedor->id }}">
                                            {{ $proveedor->nombre }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('proveedor_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        

                        <div class="row justify-content-center">
                            <div class="col-sm-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Agregar Producto</button>
                                <a href="{{ route('productos.index') }}" class="btn btn-danger ms-3">Cancelar</a>
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
