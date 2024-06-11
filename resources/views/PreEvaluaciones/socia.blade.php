@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Pre Evaluadores')

@section('js')

        <script>
            
            $(document).ready(function() {
                moment.locale('es');
                var start_date = moment().subtract(2, 'month');
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
                                            url: "{{route('pre-evaluaciones.data')}}", // or "/ajax-handler/" depending on your setup
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
                            $('input.dt-input').attr('placeholder', 'Ingrese nombre o DNI');
                        }
                        ,
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All']
                        ],
                        language: {
                            url : "{{asset('es-ES.json')}}"
                        },
                        // ajax: "{{route('pre-evaluaciones.data')}}",
                        ajax: {
                            url: "{{route('PreEvaluadorSocia.index')}}",
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
                            { data: 'nombrecompleto', searchable: true }, // Nombre de la columna y clave en el JSON
                            { data: 'dni', searchable: true  },
                            { data: 'bancocomunal' , searchable: false },
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

                const EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
                const EXCEL_EXTENSION = '.xlsx';

                function saveAsExcel(buffer,filename){
                    const data = new Blob([buffer],{ type : EXCEL_TYPE});
                    saveAs(data,filename+EXCEL_EXTENSION);
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
            <div class="form-group">
                <div class="form-group">
                    <div class="col col-9">Fecha :</div>
                    <div class="col col-3"> 
                        <div id = "dateRange" class="float-end" style="background: #ffff ; cursor : pointer ; padding: 5px 10px ;border: 1px solid #ccc; width: 100%; text-align: center; "  >
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span>
                        <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>            
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





