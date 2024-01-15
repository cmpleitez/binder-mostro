@extends('forestLayout')
@section('content')
    <!-- line chart section start -->
    <section id="chartjs-charts">
        <div class="row">

            <!-- Detail infomation reports -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">REPORTES DE INFORMACION DETALLADA</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="height-450">
                                <div class="row">
                                  <div class="col-xl-4 col-sm-6 col-12">


                                    <a href="{{route('automation.reporte-ventas')}}">

                                        <div class="card bg-primary bg-lighten-5">
                                            <div class="card-content">
                                                <div class="row no-gutters">
                                                    <div class="col-12">
                                                        <div class="card-body text-center">

                                                            <div class="p-2">
                                                                <h4 class="card-title">Reporte de Ventas</h4>
                                                                <p class="card-text">Detalle</p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </a>



                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Line Chart -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">INDICADORES DE CALIDAD</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body pl-0">
                            <div class="height-450">
                                <canvas id="line"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bar Chart -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">STACKED BAR CHART</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body pl-0">
                            <div class="height-450">
                                <canvas id="bar-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // line chart section end -->
@endsection

@section('public_reports')
    <script src="{{ asset('app-assets/vendors/js/charts/chart.min.js') }}"></script>
    <script type="text/javascript">
        var etiquetas = {!! json_encode($etiquetas) !!}
        var atenciones = {!! json_encode($atenciones) !!}
        var procesos = {!! json_encode($procesos) !!}
        var anulaciones = {!! json_encode($anulaciones) !!}
        var sinrevisar = {!! json_encode($sinrevisar) !!}
        var sinreportar = {!! json_encode($sinreportar) !!}
        var $primary = '#5A8DEE',
            $success = '#39DA8A',
            $danger = '#FF5B5C',
            $warning = '#FDAC41',
            $info = '#00CFDD',
            $label_color = '#475F7B',
            grid_line_color = '#dae1e7',
            scatter_grid_color = '#f3f3f3',
            $scatter_point_light = '#E6EAEE',
            $scatter_point_dark = '#5A8DEE',
            $white = '#fff',
            $black = '#000';
        var themeColors = [$primary, $warning, $danger, $success, $info, $label_color];

        // Line Chart
        // ----------------------------------------------------------------------------
        //Get the context of the Chart canvas element we want to select
        var lineChartctx = $("#line");
        // Chart Options
        var linechartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'top',
            },
            hover: {
                mode: 'label'
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: grid_line_color,
                    },
                    scaleLabel: {
                        display: true,
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: grid_line_color,
                    },
                    scaleLabel: {
                        display: true,
                    }
                }]
            },
            title: {
                display: true,
                text: 'CATEGORIAS'
            }
        };

        // Chart Data
        var linechartData = {
            labels: etiquetas,
            datasets: [{
                    label: "Atenciones",
                    data: atenciones,
                    borderColor: $primary,
                    fill: false
                },
                {
                    label: "Procesos",
                    data: procesos,
                    borderColor: $danger,
                    fill: false
                },
                {
                    label: "Anulaciones",
                    data: anulaciones,
                    borderColor: $success,
                    fill: false
                },
                {
                    label: "Sin reportar",
                    data: sinreportar,
                    borderColor: $warning,
                    fill: false
                },
                {
                    label: "Sin revisar",
                    data: sinrevisar,
                    borderColor: $black,
                    fill: false
                },
            ]
        };
        var lineChartconfig = {
            type: 'line',

            // Chart Options
            options: linechartOptions,
            data: linechartData
        };

        // Create the chart
        var lineChart = new Chart(lineChartctx, lineChartconfig);

        // Stacked Bar Chart----------------------------------------------------------------------------
        var barChartctx = $("#bar-chart");
        var stackedBar = new Chart(barChartctx, {
            type: 'bar',
            data: {
                labels: ['bar1', 'bar2', 'bar3', 'bar1', 'bar2', 'bar3'],
                datasets: [{
                        label: 'Dataset 1',
                        data: [50, 35, -15, 50, 35, -15],
                        backgroundColor: $primary,
                    },
                    {
                        label: 'Dataset 2',
                        data: [-25, 35, -30, 50, 35, -15],
                        backgroundColor: $success,
                    },
                    {
                        label: 'Dataset 3',
                        data: [25, -33, 33, 50, 35, -15],
                        backgroundColor: $info,
                    },
                ],
            },
            options: {
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    </script>
@endsection
