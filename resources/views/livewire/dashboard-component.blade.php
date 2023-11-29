<div>
    <div class="card-body">
        <section class="row">
            <div class="col-6">
            </div>
            <div class="col-6">
                <div class="d-flex">
                    <div class="w-50">
                        <label for="">Fecha Inicial</label>
                        <input type="date" class="form-control" wire:model='start'>
                    </div>
                    <div class="w-50">
                        <label for="">Fecha Final</label>
                        <input type="date" class="form-control" wire:model='end'>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <div class="dashboard-content">
            <section class="row" wire:loading.class="opacity">
                <div class="col-md-12">
                    <p class="text-center">Usuarios/Total de Leads</p>
                    <canvas id="myChartBarCreated" width="400" height="150"></canvas>
                </div>
                <div class="w-100">
                    <br>
                </div>
                <div class="col-md-8">
                    <p class="text-center">Usuarios/Monto Total</p>
                    <canvas id="myChartBarMoney" width="400" height="200"></canvas>
                </div>
                <div class="col-md-4">
                    <p class="text-center">Usuarios que no han creado un lead</p>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataUserInfoTickets[2] as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::limit($item[0], 25, '...') }}</td>
                                    <td>{{ $item[1] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <div wire:loading.flex>
                <div class="spinnerloading w-100 d-flex justify-content-center">
                    <div>
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .spinnerloading {
            position: absolute;
            top: 10px;
        }

        .dashboard-content {
            position: relative;
        }

        .opacity {
            opacity: .5;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        let dataQuoteCompany = @json($dataQuoteCompany);
        let dataUserInfoTicketsNames = @json($dataUserInfoTickets[0]);
        let dataUserInfoTicketsTotal = @json($dataUserInfoTickets[1]);
        let dataUserMountTicketsNames = @json($dataUserMountTickets[0]);
        let dataUserMountTicketsTotal = @json($dataUserMountTickets[1]);

        let myChartType, myChart, myChartMount;
        window.addEventListener('refreshData', event => {
            dataQuoteCompany = event.detail.dataQuoteCompany;
            dataUserInfoTicketsNames = event.detail.dataUserInfoTickets[0];
            dataUserInfoTicketsTotal = event.detail.dataUserInfoTickets[1];
            dataUserMountTicketsNames = event.detail.dataUserMountTickets[0];
            dataUserMountTicketsTotal = event.detail.dataUserMountTickets[1];
            crearGraficas()
        })

        function crearGraficas() {
            // Chart Type
            if (myChartType) {
                myChartType.destroy();
            }
            if (myChart) {
                myChart.destroy();
            }
            if (myChartMount) {
                myChartMount.destroy();
            }
            const ctxType = 'myChart';
            const dataType = {
                labels: [
                    'PROMO LIFE',
                    'PROMO ZALE',
                    'BH TRADEMARKET'
                ],
                datasets: [{
                    label: 'Tipos de Tickets Creados',
                    data: dataQuoteCompany,
                    backgroundColor: [
                        'rgb(2, 158, 250)',
                        'rgb(44,240, 190)',
                        'rgb(9, 67, 227)',
                    ],
                    hoverOffset: 4
                }]
            };
            myChartType = new Chart(ctxType, {
                type: 'pie',
                data: dataType,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart Creadores
            const ctx = 'myChartBarCreated';
            // $dataUserInfoTickets = [$dataUserCreatedTickets, $dataUserCountTickets];
            const labels = dataUserInfoTicketsNames;
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Total de Leads',
                    data: dataUserInfoTicketsTotal,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            };
            myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            });
            const ctxMount = 'myChartBarMoney';
            // $dataUserInfoTickets = [$dataUserCreatedTickets, $dataUserCountTickets];
            const labelsMount = dataUserMountTicketsNames;
            const dataMount = {
                labels: labelsMount,
                datasets: [{
                    label: 'Monto Total',
                    data: dataUserMountTicketsTotal,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            };
            myChartMount = new Chart(ctxMount, {
                type: 'bar',
                data: dataMount,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            });
        }
        crearGraficas()
        /*
        // Chart Type
        const ctxDesigner = 'chartDesigner';
        const dataDesigner = {
            labels: []
            datasets: [{
                label: 'Tipos de Tickets Creados',
                data: [],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };
        const myChartDesigner = new Chart(ctxDesigner, {
            type: 'pie',
            data: dataDesigner,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        // Chart Type
        const ctxStatus = 'chartStatus';
        const dataStatus = {
            labels: [],
            datasets: [{
                label: 'Tipos de Tickets Creados',
                data: [],
                backgroundColor: [
                    'rgb(155, 99, 232)',
                    'rgb(4, 162, 23)',
                    'rgb(54, 12, 235)',
                    'rgb(255, 25, 86)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };
        const myChartStatus = new Chart(ctxStatus, {
            type: 'pie',
            data: dataStatus,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });*/
    </script>
</div>
