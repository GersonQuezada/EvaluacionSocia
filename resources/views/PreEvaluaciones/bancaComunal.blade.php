@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Pre Evaluadores')

@section('js')

        <script>

            const EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
            const EXCEL_EXTENSION = '.xlsx';

            function saveAsExcel(buffer,filename){
                const data = new Blob([buffer],{ type : EXCEL_TYPE});
                saveAs(data,filename+EXCEL_EXTENSION);
            }


            $(document).ready(function() {
                moment.locale('es');
                var start_date = moment().subtract(1, 'year');
                var end_date = moment();
                $('#dateRange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
                $('#dateRange').daterangepicker({
                    startDate: start_date,
                    endDate: end_date,
                    locale: {
                        format: 'MMMM D, YYYY',
                        separator: ' - ',
                        applyLabel: 'Aplicar',
                        cancelLabel: 'Cancelar',
                        fromLabel: 'Desde',
                        toLabel: 'Hasta',
                        customRangeLabel: 'Personalizado',
                        weekLabel: 'S',
                        daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        firstDay: 1
                    }
                }, function(start_date, end_date) {
                    $('#dateRange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
                    oTable.draw();
                });

                var oTable =  new DataTable('#preevaluacion-table', {
                        responsive: true,
                        bProcessing: true,
                        bServerSide: true,
                        bAutoWidth: false,
                        sDom: '<"row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-4"B><"col-sm-12 col-md-4"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                        buttons:[
                            {
                                extend:    'excelHtml5',
                                text:      '<i class="fas fa-file-excel"></i> ',
                                titleAttr: 'Exportar a Excel',
                                title: "Lista de Pre Evaluaciones",
                                action: function(e, dt, button, config) {
                                    // Recuperar los parámetros actuales de filtrado, búsqueda y ordenación
                                    var aParams = dt.ajax.params();
                                    // Modificar los parámetros para obtener todos los registros
                                    aParams.length = -1;
                                        $.ajax({
                                            type: "GET",
                                            url: "{{route('PreEvaluadorBancaComunal.index')}}", // or "/ajax-handler/" depending on your setup
                                            data: aParams,
                                            success: function(data) {
                                                const worksheet = XLSX.utils.json_to_sheet(  data.data );
                                                const workbook = {
                                                    Sheets:{
                                                        'PreEvaluadores':worksheet
                                                    },
                                                    SheetNames:['PreEvaluadores']
                                                };
                                                // Agregar un encabezado personalizado
                                                const header = [
                                                    "Id",
                                                    "Nombre Socia",
                                                    "DNI",
                                                    "Banca Comunal",
                                                    "Fecha de Creacion",
                                                    "Asesor",
                                                    "Monto",
                                                    "Plazo",
                                                    "Cuota",
                                                    "Nivel Riesgo",
                                                    "Sub Neto",
                                                    "Deuda Externa",
                                                    "Ingreso Neto",
                                                    "Capacidad de Pago",
                                                    "Sucursal",
                                                    "Fecha de 1er Modificacion",
                                                    "Fecha de 2da Modificacion",
                                                    "Fecha Vigente del Pre Evaluador"
                                                ];
                                                const headerRow = XLSX.utils.aoa_to_sheet([header]);
                                                XLSX.utils.sheet_add_aoa(worksheet, [header], { origin: "A1" });
                                                const excelBuffer = XLSX.write(workbook,{bookType:'xlsx',type:'array'});
                                                saveAsExcel(excelBuffer,"Lista de Pre Evaluaciones");
                                                $(button).prop('disabled', false).removeClass('processing');
                                            },error: function(xhr, status, error) {
                                                console.error("AJAX error: ", error);
                                                $(button).prop('disabled', false).removeClass('processing'); // Desactivar estado de procesamiento en caso de error
                                            }
                                        });
                                }
                            },
                            {
                                extend:    'pdfHtml5',
                                text:      '<i class="fas fa-file-pdf"></i> ',
                                titleAttr: 'Exportar a PDF',
                                className: 'btn btn-danger',
                                orientation: 'landscape',
                                filename : 'ListaPreEvaluadores',
                                title: 'Lista de Pre Evaluaciones'
                            }
                        ],
                        initComplete: function(settings, json) {
                            $('input.dt-input').attr('placeholder', 'Ingrese Banca Comunal');
                        }
                        ,
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All']
                        ],
                        language: {
                            url : "{{asset('es-ES.json')}}"
                        },
                        ajax: {
                            url: "{{route('PreEvaluadorBancaComunal.index')}}",
                            data : function(data){
                                data.from_date = $('#dateRange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                                data.end_date = $('#dateRange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                            }
                        },
                        aoColumns: [
                            // {data : null,
                            //     render: function ( data, type, row) {
                            //                     var botonEliminar = '<button type="button"  class="btn btn-danger col" onclick = "EliminarOrdenesPagos(\''+row.CODSUCURSAL+'_'+row.NroRegistro+'_'+row.FECHA_CREACION+'\');" id = "BotonEliminar"><i class="fas fa-user-slash"></i></button>'+
                            //                     '<br><button type="button"   class="btn btn-info col" onclick = "HabilitarItems(\''+row.CODSUCURSAL+'_'+row.NroRegistro+'_'+row.FECHA_CREACION+'_'+row.CODASOCIACION+'_'+row.CODASOCIACION_anillo+'\');" id = "BotonEditar_'+row.CODSUCURSAL+'_'+row.NroRegistro+'_'+row.FECHA_CREACION+'"><i class="fas fa-pencil-alt"></i></button>'+
                            //                     '<button type="button" style = "display : none;"   class="btn btn-success col" onclick = "GuardarOrdenesPagos(\''+row.NroRegistro+'_'+row.CODSUCURSAL+'_'+row.CODASOCIACION+'_'+row.CODASOCIACION_anillo+'_'+row.FECHA_OPERACION+'\');" id = "BotonAgregar_'+row.CODSUCURSAL+'_'+row.NroRegistro+'_'+row.FECHA_OPERACION+'"><i class="fas fa-save"></i></button>';
                            //                     return botonEliminar;
                            //     }
                            // },
                            { data: 'nombrecompleto', searchable: false }, // Nombre de la columna y clave en el JSON
                            { data: 'dni', searchable: false  },
                            { data: 'bancocomunal' , searchable: true },
                            { data: 'fecha', searchable: false },
                            { data: 'asesor', searchable: false },
                            { data: 'monto', searchable: false ,
                                render: function ( data, type, row) {
                                    return row.monto ? 'S/'+row.monto : 'S/'+0.00;
                                }
                            },
                            { data: 'plazo', searchable: false  },
                            { data: 'cuota' , searchable: false ,
                                render: function ( data, type, row) {
                                    return row.cuota ? 'S/'+row.cuota : 'S/'+0.00;
                                }
                            },
                            { data: 'nivelriesgo' , searchable: false},
                            { data: 'subneto' , searchable: false ,
                                render: function ( data, type, row) {
                                        return row.subneto ? 'S/'+row.subneto : 'S/'+0.00;
                                    }
                            },
                            { data: 'deudaexterna', searchable: false ,
                                render: function ( data, type, row) {
                                        return row.deudaexterna ? 'S/'+row.deudaexterna : 'S/'+0.00;
                                    }
                            },
                            { data: 'ingresoneto' , searchable: false ,
                                render: function ( data, type, row) {
                                        return row.ingresoneto ? 'S/'+row.ingresoneto : 'S/'+0.00;
                                    }
                            },
                            { data: 'capacidadpago', searchable: false },
                            { data: 'CODREGION' , searchable: false},
                            { data: 'fechamodificada' , searchable: false},
                            { data: 'fechamodi_actual' , searchable: false},
                            { data: 'FECHAVIGENCIA', searchable: false }

                        ],
                        bPaginate:true,
                        bDestroy: true,
                });

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
            <div class="form-group">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <label for="dateRange" class="form-label">Fecha de Creacion:</label>
                            <div id="dateRange" class="d-inline-flex align-items-center p-2 border" style="background: #ffff; cursor: pointer;">
                                <i class="fa fa-calendar mr-2"></i>
                                <span></span>
                                <i class="fa fa-caret-down ml-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                    <table id="preevaluacion-table"  class="table table-hover  table-responsive border" style="width:100%">
                        <thead class="thead-light ">
                                {{-- <th>Accion</th> --}}
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




        </div>
    </div>

@stop



