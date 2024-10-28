@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-6">
          <div class="card-header d-flex align-items-center justify-content-between">
            @if (isset($productos))
                <h1 class="text-center">Editar producto</h1>
            @else
                <h1 class="text-center">Crear producto</h1>
            @endif
            <small class="text-muted float-end">Producto</small>
          </div>
          <div class="card-body">
            @if (isset($productos))
                <form action="{{ route('productos.update', $productos) }}" method="post">
                @method('PUT')
            @else
                <form action="{{ route('productos.store') }}" method="post">
            @endif
                @csrf
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Nombre del producto</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-name" name="nombre" placeholder="Ingresa el nombre del producto." value="{{ old('nombre') ?? @$productos->nombre }}" />
                  <p class="form-text">Escribe el nombre del producto</p>
                @error('nombre')
                <p class="form-text text-danger">{{ $message}}</p>
                @enderror
                </div>
              </div>

              <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-company">Descripcion</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    class="form-control" name="descripcion"
                    id="basic-default-company"
                    placeholder="Ingresa una descripcion." value="{{ isset($productos) ? $productos->descripcion : '' }}" />
                </div>
              </div>

              <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-company">Precio</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    class="form-control" name="precio"
                    id="basic-default-company"
                    placeholder="Ingresa el precio." value="{{ isset($productos) ? $productos->precio : '' }}" />
                </div>
              </div>

              <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="categoria_id">Categoría</label>
                <div class="col-sm-10">
                    <select name="categoria_id" id="categoria_id" class="form-control">
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ isset($productos) && $productos->categoria_id == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
              <label for="proveedor_id" class="form-label">Proveedores</label>
              <select id="proveedor_id" name="proveedor_id[]" class="form-select" multiple>
                  @foreach ($proveedores as $proveedor)
                      <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                  @endforeach
              </select>
          </div>          
            

              <div class="row justify-content-center">
                <div class="col-sm-12 d-flex justify-content-center">
                  <a href="{{ route('productos.index') }}" class="btn btn-danger me-3">Cancelar</a>
                  <button class="btn btn-success" type="submit">{{ isset($productos) ? 'Actualizar producto' : 'Agregar producto' }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Form with Tabs -->
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
