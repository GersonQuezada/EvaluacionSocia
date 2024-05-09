@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Pre Evaluadores')

@section('js')
    <script>
        new DataTable('#PreEvaluadores', {
            responsive: true,
            processing: true,
            serverSide: true,
            autowidth: false,
            // dom: 'QBfrtip',
            buttons:[
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fas fa-file-excel"></i> ',
                    titleAttr: 'Exportar a Excel',
                    footer: true,
                    title: "Malla Sentinel"
                },
                {
                    extend:    'pdfHtml5',
                    text:      '<i class="fas fa-file-pdf"></i> ',
                    titleAttr: 'Exportar a PDF'
                },
                {
                    extend:    'print',
                    text:      '<i class="fa fa-print"></i> ',
                    titleAttr: 'Imprimir'
                }
            ],
            layout: {
                top : 'buttons'
            },
            language: {
                url : "{{asset('es-ES.json')}}"
            },
            ajax: {
                url : "{{route('malla-sentinel.data')}}",
                type : "POST",
                data : {
                    _token: "{{ csrf_token() }}"
                }
            },
            columns: [
                { data: 'BancoComunal',searchable: false },
                { data: 'REGION',searchable: false },
                { data: 'NRODNISOCIA',searchable: true },
                { data: 'NombreSocia',searchable: true },
                { data: 'IDSOCIA',searchable: false },
                { data: 'DIASMORAMMR',searchable: false },
                { data: 'CAPACIDADPAGO',searchable: false },
                { data: 'EVALUACION',searchable: false },
                { data: 'MOTIVO',searchable: false },
                { data: 'BANCARIZACIÓN',searchable: false },
                { data: 'CUOTAPROMEDIO',searchable: false },
                { data: 'DeudaTotalSistemaFinanciero',searchable: false },
                { data: 'DeudaVencidaEnSistemaFinancieroSBS',searchable: false },
                { data: 'CreditoVehicular',searchable: false },
                { data: 'CreditoHipotecario',searchable: false },
                { data: 'DeudaEnProtestos',searchable: false },
                { data: 'DeudaEnProtestosPorEntidades',searchable: false },
                { data: 'Deudaimpaga',searchable: false },
                { data: 'DeudaEnEntidades',searchable: false },
                { data: 'NroEntidades',searchable: false },
                { data: 'Entidad1',searchable: false },
                { data: 'Entidad2',searchable: false },
                { data: 'Entidad3',searchable: false },
                { data: 'Entidad4',searchable: false },
                { data: 'Entidad5',searchable: false },
                { data: 'Entidad6',searchable: false },
                { data: 'Entidad7',searchable: false },
                { data: 'Entidad8',searchable: false },
                { data: 'Entidad9',searchable: false },
                { data: 'Entidad10',searchable: false },
                { data: 'NOR',searchable: false },
                { data: 'CPP',searchable: false },
                { data: 'DEF',searchable: false },
                { data: 'DUD',searchable: false },
                { data: 'PER',searchable: false },
                { data: 'PeorCalifSBS',searchable: false },
            ]
        });
    </script>

@stop

{{-- Content body: main page content --}}

@section('content_body')
    <section class="content-header">
        <h1> Malla Riesgo Sentinel - Busqueda Por Socias</h1>
    </section>

    <div class="card card-primary">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table id="PreEvaluadores"  class="table table-hover  table-responsive border" style="width:100%">
                <thead class="thead-light ">
                    <th class="align-middle text-center text-black-50">Banca Comunal</th>
                    <th class="align-middle text-center text-black-50">Sucursal</th>
                    <th class="align-middle text-center text-black-50">DNI</th>
                    <th class="align-middle text-center text-black-50">Nombre Socia</th>
                    <th class="align-middle text-center text-black-50">ID - BC</th>
                    <th class="align-middle text-center text-black-50">DIAS MORA MMR</th>
                    <th class="align-middle text-center text-black-50">CAPACIDAD PAGO</th>
                    <th class="align-middle text-center text-black-50">EVALUACION</th>
                    <th class="align-middle text-center text-black-50">MOTIVO</th>
                    <th class="align-middle text-center text-black-50">BANCARIZACIÓN</th>
                    <th class="align-middle text-center text-black-50">CUOTAPROMEDIO</th>
                    <th class="align-middle text-center text-black-50">DeudaTotalSistemaFinanciero</th>
                    <th class="align-middle text-center text-black-50">DeudaVencidaEnSistemaFinancieroSBS</th>
                    <th class="align-middle text-center text-black-50">CreditoVehicular</th>
                    <th class="align-middle text-center text-black-50">CreditoHipotecario</th>
                    <th class="align-middle text-center text-black-50">DeudaEnProtestos</th>
                    <th class="align-middle text-center text-black-50">DeudaEnProtestosPorEntidades</th>
                    <th class="align-middle text-center text-black-50">Deudaimpaga</th>
                    <th class="align-middle text-center text-black-50">DeudaEnEntidades</th>
                    <th class="align-middle text-center text-black-50">NroEntidades</th>
                    <th class="align-middle text-center text-black-50">Entidad1</th>
                    <th class="align-middle text-center text-black-50">Entidad2</th>
                    <th class="align-middle text-center text-black-50">Entidad3</th>
                    <th class="align-middle text-center text-black-50">Entidad4</th>
                    <th class="align-middle text-center text-black-50">Entidad5</th>
                    <th class="align-middle text-center text-black-50">Entidad6</th>
                    <th class="align-middle text-center text-black-50">Entidad7</th>
                    <th class="align-middle text-center text-black-50">Entidad8</th>
                    <th class="align-middle text-center text-black-50">Entidad9</th>
                    <th class="align-middle text-center text-black-50">Entidad10</th>
                    <th class="align-middle text-center text-black-50">NOR</th>
                    <th class="align-middle text-center text-black-50">CPP</th>
                    <th class="align-middle text-center text-black-50">DEF</th>
                    <th class="align-middle text-center text-black-50">DUD</th>
                    <th class="align-middle text-center text-black-50">PER</th>
                    <th class="align-middle text-center text-black-50">PeorCalifSBS</th>
                </thead>
            </table>
        </div>
    </div>

@stop



