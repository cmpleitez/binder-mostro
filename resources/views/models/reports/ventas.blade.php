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
                    <table id="ventas" class="table table-hover table-striped table-bordered" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">ID</th>
                                <th>OFERTA</th>
                                <th>PRODUCTO/SERVICIO</th>
                                <th class="text-center">UNIDADES</th>
                                <th class="text-center">PRECIO</th>
                                <th class="text-right">MONTO</th>
                                <th class="text-center">RESERVA</th>
                                <th class="text-center">COMPRA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventas as $venta)
                                <tr>
                                    <td class="text-center">{{ $venta->id }}</td>
                                    <td>{{ $venta->offer->offer }}</td>
                                    <td>{{ $venta->service->service }}</td>
                                    <td class="text-center">{{ $venta->supply_quantity }}</td>
                                    <td class="text-center">${{ number_format($venta->supply_charge, 2, '.', ',') }}</td>
                                    <td class="text-right">${{ number_format($venta->requisition_amount, 2, '.', ',') }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($venta->created_at)->format('d-m-Y H:i') }}</td>
                                    <td class="text-center"><span
                                            class="badge badge-light-warning">{{ \Carbon\Carbon::parse($venta->cart->purchased_date)->format('d-m-Y H:i') }}</span>
                                    </td>
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
                                <th class="text-right">TOTAL: ${{ number_format($total, 2, '.', ',') }}</th>
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
    <script src="{{ asset('app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>

    <script>
        $("#ventas").DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "language": {
                "url": "{{ asset('assets/Spanish.json')}}"
            }
        });
        $('input[name="periodo"]').daterangepicker({
            locale: {
                format: 'DD.MM.YYYY',
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
                'El año pasado': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf(
                    'year')]
            }
        });
    </script>


@stop
