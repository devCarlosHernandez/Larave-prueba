@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="text-center">Activity Log</h1>
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

  

        @if (Session::has('mensaje'))
            <div class="alert alert-info my-5">
                {{ Session::get('mensaje') }}
            </div>
        @endif


        <table id="articles" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre Categoria</th>
                    <th>Descripcion</th>
                    <th>Valor del registro</th>
                    <th>Fecha de creacion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activity as $detail)
                    <tr>
                        <td>{{ $detail->id }}</td> <!-- Asegúrate de que esto exista en tu tabla -->
                        <td>{{ $detail->log_name }}</td>
                        <td>{{ $detail->description }}</td>
                        <td>{{ $detail->subject_id }}</td>
                        <td>{{ $detail->created_at }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5">No existen registros!</td> <!-- Asegúrate de que el colspan sea correcto -->
                        </tr>
                    @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th>id</th>
                    <th>Nombre Categoria</th>
                    <th>Descripcion</th>
                    <th>Valor</th>
                    <th>Fecha de creacion</th>
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
@endsection
