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
            @if (isset($categorias))
                <h1 class="text-center">Editar categoria</h1>
            @else
                <h1 class="text-center">Crear categoria</h1>
            @endif

        <h5 class="mb-0">{{ isset($categorias) ? 'Editar Categoria' : 'Nueva Categoria' }}</h5>
            <small class="text-muted float-end">Categorias</small>
          </div>
          <div class="card-body">
            @if (isset($categorias))
                <form action="{{ route('categorias.update', $categorias) }}" method="post">
                @method('PUT')
            @else
                <form action="{{ route('categorias.store') }}" method="post">
            @endif
                @csrf
              <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Nombre de la categoria</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-name" name="nombre" placeholder="Ingresa el nombre de la categoria." value="{{ old('nombre') ?? @$categorias->nombre }}" />
                  <p class="form-text">Escribe el nombre del la categoria</p>
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
                    placeholder="Ingresa una descripcion." value="{{ isset($categorias) ? $categorias->descripcion : '' }}" />
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-sm-12 d-flex justify-content-center">
                  <a href="{{ route('categorias.index') }}" class="btn btn-danger me-3">Cancelar</a>
                  <button class="btn btn-success" type="submit">{{ isset($categorias) ? 'Actualizar categoria' : 'Agregar categoria' }}</button>
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
