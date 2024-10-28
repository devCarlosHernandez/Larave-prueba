@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="text-center">Listado de Marcas</h1>
    
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <style>
                .right-align {
                    text-align: right;
                }

                .d-flex.justify-content-end.mb-3 {
                    margin-top: 30px;
                    margin-right: 50px;
                }

                .d-flex.justify-content-end.mb-3 a.btn {
                    padding: 10px 20px;
                }
            </style>

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('marcas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Crear Marca
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success my-5">{{ session('success') }}</div>
            @endif

            <table id="articles" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($marca as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>
                                <a href="{{ route('marcas.edit', $item) }}" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt me-2"></i> Editar
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('marcas.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $item->id }})">
                                        <i class="fa-solid fa-x me-2"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                @if($marca->isEmpty())
                    <tr>
                        <td colspan="3">No existen registros!</td>
                    </tr>
                @endif

                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
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