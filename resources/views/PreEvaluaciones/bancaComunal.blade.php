@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Pre Evaluadores')

@section('js')

        <script>
                new DataTable('#PreEvaluadores', {
                    responsive: true,
                    autowidth: false,
                    processing: true,
                    serverSide: true,
                    // dom: 'Bfrtip',
                    buttons:[
                        {
                            extend:    'excelHtml5',
                            text:      '<i class="fas fa-file-excel"></i> ',
                            titleAttr: 'Exportar a Excel',
                            footer: true,
                            title: "Lista de Pre Evaluaciones"
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
                        topStart: 'buttons'
                    },
                    language: {
                        url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    ajax: "{{route('pre-evaluaciones.data')}}",
                    columns: [
                        { data: 'nombrecompleto',searchable: false }, // Nombre de la columna y clave en el JSON
                        { data: 'dni', searchable: false  },
                        { data: 'bancocomunal' , searchable: true },
                        { data: 'fecha' , searchable: false  },
                        { data: 'asesor', searchable: true },
                        { data: 'monto' , searchable: false },
                        { data: 'plazo', searchable: false  },
                        { data: 'cuota' , searchable: false },
                        { data: 'nivelriesgo', searchable: false },
                        { data: 'subneto' , searchable: false },
                        { data: 'deudaexterna', searchable: false  },
                        { data: 'ingresoneto' , searchable: false },
                        { data: 'capacidadpago' , searchable: false  },
                        { data: 'CODREGION' , searchable: false  },
                        { data: 'fechamodificada'  , searchable: false },
                        { data: 'fechamodi_actual' , searchable: false  },
                        { data: 'FECHAVIGENCIA' , searchable: false  },
                        // { data: 'dni' }, // Otra columna y su clave

                    ]
                });
        </script>


@stop

{{-- Content body: main page content --}}

@section('content_body')
    <section class="content-header">
        <h1> Listado de Pre Evaluadores - Busqueda Por Bancos Comunales</h1>
    </section>

    <div class="card card-primary">
        <div class="card-header">
        </div>
        <div class="card-body">
            {{-- <section>
                <form class="form-horizontal" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" id='search-input' class="form-control col-4" placeholder="Escriba el DNI para buscar" aria-label="Escriba el DNI para buscar" aria-describedby="button-addon2" value="{{ old('search') }}" style="color: #212529; placeholder-color: #212529;">
                        <button class="btn btn-outline-info" type="submit" id="button-addon2">Buscar</button>
                    </div>
                </form>
            </section> --}}
            <table id="PreEvaluadores"  class="table table-hover  table-responsive border" style="width:100%">
                <thead class="thead-light ">
                        <th class="align-middle text-center text-black-50">Nombre Socia</th>
                        <th class="align-middle text-center text-black-50">DNI</th>
                        <th class="align-middle text-center text-black-50">Banca Comunal</th>
                        <th class="align-middle text-center text-black-50">Fecha de Creacion</th>
                        <th class="align-middle text-center text-black-50">Asesor</th>
                        <th class="align-middle text-center text-black-50">Monto</th>
                        <th class="align-middle text-center text-black-50">Plazo</th>
                        <th class="align-middle text-center text-black-50">Cuota</th>
                        <th class="align-middle text-center text-black-50">Nivel Riesgo</th>
                        <th class="align-middle text-center text-black-50">Sub Neto</th>
                        <th class="align-middle text-center text-black-50">Deuda Externa</th>
                        <th class="align-middle text-center text-black-50">Ingreso Neto</th>
                        <th class="align-middle text-center text-black-50">Capacidad de Pago</th>
                        <th class="align-middle text-center text-black-50">Sucursal</th>
                        <th class="align-middle text-center text-black-50">Fecha de 1er Modificacion</th>
                        <th class="align-middle text-center text-black-50">Fecha de 2da Modificacion</th>
                        <th class="align-middle text-center text-black-50">Fecha Vigente del Pre Evaluador</th>
                </thead>
            </table>
        </div>
        <div class="card-footer clearfix">
            <ul class="pagination-sm m-0 float-right">
                {{-- {{$PreEvaluaciones->links()}} --}}
            </ul>
        </div>
    </div>

@stop



