@extends('forestLayout')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@stop
@section('content')
    <div class="text-center">
        <h1>Reporte de ventas</h1>
    </div>

    <div class="card">
        <div class="card-content ">
            <div class="card-body pb-1">
                <form method="GET" action ="{{ Route('automation.reporte-ventas') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control dateranges" placeholder="Selecciona el periodo"
                                    name="periodo" value="{{ $periodo }}">
                                <div class="form-control-position">
                                    <i class="bx bx-calendar-check"></i>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-8 text-right">
                            <fieldset class="form-group">
                                <button type="submit" class="btn btn-light-primary">Consultar</button>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="users-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>OFERTA</th>
                                <th>PRODUCTO/SERVICIO</th>
                                <th>UNIDADES</th>
                                <th>PRECIO</th>
                                <th>MONTO</th>
                                <th>FECHA</th>
                                <th>OTRO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventas as $venta)
                                <tr>
                                    <td>{{ $venta->id }}</td>
                                    <td>{{ $venta->offer->offer }}</td>
                                    <td>{{ $venta->service->service }}</td>
                                    <td>{{ $venta->supply_quantity }}</td>
                                    <td>{{ $venta->supply_charge }}</td>
                                    <td>{{ $venta->requisition_amount }}</td>
                                    <td>{{ $venta->created_at }}</td>
                                    <td><span class="badge badge-light-warning">otro</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>TOTAL: {{ $total }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/page-users.js') }}"></script>

    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>

    <script>
        $('input[name="periodo"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Rango personalizado',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'
                ],
                firstDay: 1
            },
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                'Este mes': [moment().startOf('month'), moment().endOf('month')],
                'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')],
                'El año pasado': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            }
        });
    </script>


@stop
