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
            @if (isset($proveedores))
                <h1 class="text-center">Editar proveedor</h1>
            @else
                <h1 class="text-center">Crear proveedor</h1>
            @endif
            <small class="text-muted float-end">proveedores</small>
          </div>
          <div class="card-body">
            @if (isset($proveedores))
                <form action="{{ route('proveedores.update', $proveedores) }}" method="post">
                @method('PUT')
            @else
                <form action="{{ route('proveedores.store') }}" method="post">
            @endif
                @csrf
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Nombre del proveedores</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-name" name="nombre" placeholder="Ingresa el nombre del proveedor." value="{{ old('nombre') ?? @$proveedores->nombre }}" />
                  <p class="form-text">Escribe el nombre del proveedor</p>
                @error('nombre')
                <p class="form-text text-danger">{{ $message}}</p>
                @enderror
                </div>
              </div>
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-company">Direccion</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    class="form-control" name="direccion"
                    id="basic-default-company"
                    placeholder="Ingresa una direccion." value="{{ isset($proveedores) ? $proveedores->direccion : '' }}" />
                </div>
              </div>

              <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-company">Telefono</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    class="form-control" name="telefono"
                    id="basic-default-company"
                    placeholder="Ingresa un telefono." value="{{ isset($proveedores) ? $proveedores->telefono : '' }}" />
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-sm-12 d-flex justify-content-center">
                  <a href="{{ route('proveedores.index') }}" class="btn btn-danger me-3">Cancelar</a>
                  <button class="btn btn-success" type="submit">{{ isset($proveedores) ? 'Actualizar categoria' : 'Agregar categoria' }}</button>
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
