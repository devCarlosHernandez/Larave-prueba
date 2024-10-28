@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="text-center">Listado de Productos</h1>
    <!-- DataTable with  -->
    <div class="card">
      <div class="card-datatable table-responsive pt-0">
        <style>
            .right-align {
                text-align: right;
            }

            .d-flex.justify-content-end.mb-3 {
                margin-top: 30px; /* Ya lo habíamos agregado */
                margin-right: 50px; /* Ajusta este valor para moverlo más a la izquierda */
            }

            .d-flex.justify-content-end.mb-3 a.btn {
                padding: 10px 20px 10px; /* Ajusta el padding interno del botón si es necesario */
            }
        </style>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Nuevo Producto
            </a>
        </div>


        @if (Session::has('mensaje'))
            <div class="alert alert-info my-5">
                {{ Session::get('mensaje') }}
            </div>
        @endif


        <table id="articles" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Marca</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->marca->nombre }}</td>
                    <td>{{ $producto->categoria->nombre ?? 'N/A' }}</td>
                    <td>
                        <ul>
                            @foreach($producto->proveedores as $proveedor)
                                <li>{{ $proveedor->nombre }}</li>
                            @endforeach
                        </ul>
                        
                    </td>
                    <td>
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">
                            <i class="fas fa-pencil-alt me-2"></i> Editar</a>
                    </td>
                    <td>
                        <form id="delete-form-{{ $producto->id }}" action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $producto->id }})">
                                <i class="fas fa-times me-2"></i>Eliminar
                            </button>
                        </form>
                    </td>                    
                </tr>
            @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Marca</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </tfoot>
        </table>
      </div>
    </div>

  </div>
  <!--/ Content -->

@endsection


@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<script>
    $(document).ready(function(){
        $('#articles').DataTable();
    });
    
</script>
<script>

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, envía el formulario
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

@endsection