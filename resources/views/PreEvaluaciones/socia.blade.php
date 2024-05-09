@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Pre Evaluadores')

@section('js')

        <script>

            var table =  new DataTable('#PreEvaluadores', {
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
                        top1: {
                            searchBuilder: {
                                depthLimit: 2 // Limit the depth of search conditions
                            }
                        }
                    },
                    language: {
                        url : "{{asset('es-ES.json')}}"
                    },
                    ajax: "{{route('pre-evaluaciones.data')}}",

                    columns: [
                        { data: 'nombrecompleto', searchable: true }, // Nombre de la columna y clave en el JSON
                        { data: 'dni', searchable: true  },
                        { data: 'bancocomunal' , searchable: false },
                        { data: 'fecha', searchable: false },
                        { data: 'asesor', searchable: false },
                        { data: 'monto' , searchable: false },
                        { data: 'plazo', searchable: false  },
                        { data: 'cuota' , searchable: false },
                        { data: 'nivelriesgo' , searchable: false},
                        { data: 'subneto' , searchable: false },
                        { data: 'deudaexterna', searchable: false  },
                        { data: 'ingresoneto' , searchable: false },
                        { data: 'capacidadpago', searchable: false },
                        { data: 'CODREGION' , searchable: false},
                        { data: 'fechamodificada' , searchable: false},
                        { data: 'fechamodi_actual' , searchable: false},
                        { data: 'FECHAVIGENCIA', searchable: false },
                        // { data: 'dni' }, // Otra columna y su clave

                    ]
                });

            $('#search-btn').click(function() {
                var nroDocumento = $('#NRODNI').val();
                table.search(nroDocumento).draw();
            });
            $('#NRODNI').on('keyup', function(e) {
                if (e.keyCode === 13) {
                    $('#search-btn').click();
                }
            });


        </script>


@stop

{{-- Content body: main page content --}}

@section('content_body')
    <section class="content-header">
        <h1> Listado de Pre Evaluadores - Busqueda Por Socias</h1>
    </section>
    <div class="modal fade" data-backdrop="static" id="modal">
        <div class="modal-dialog modal-">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Buscar Pre Evaluador - DNI</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <input type="number" class="form-control" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  name="NRODNI" id = "NRODNI" placeholder="Nro Documento">
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary sm" id="search-btn">Buscar</button>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="card card-primary">
        <div class="card-header">
        </div>
        <div class="card-body">
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
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>

@stop



