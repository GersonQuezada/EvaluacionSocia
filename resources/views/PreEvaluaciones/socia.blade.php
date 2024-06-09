@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Pre Evaluadores')

@section('js')

        <script>

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

                                            // console.log(data.data);

                                            const workbook = {
                                                Sheets:{
                                                    'PreEvaluadores':worksheet
                                                },
                                                SheetNames:['PreEvaluadores']
                                            };

                                            // Agregar estilos a las celdas de encabezado
                                            const headerRange = XLSX.utils.decode_range(worksheet['!ref']);
                                            for (let C = headerRange.s.c; C <= headerRange.e.c; ++C) {
                                                const address = XLSX.utils.encode_col(C) + "1"; // Primera fila (encabezado)
                                                if (!worksheet[address]) continue;
                                                worksheet[address].s = {
                                                    font: {
                                                        bold: true,
                                                        color: { rgb: "#666666" }
                                                    },
                                                    fill: {
                                                        fgColor: { rgb: "4F81BD" }
                                                    }
                                                };
                                            }


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
                            className: 'btn btn-danger'
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
                    ajax: "{{route('pre-evaluaciones.data')}}",
                    aoColumns: [
                        { data: 'nombrecompleto', searchable: true }, // Nombre de la columna y clave en el JSON
                        { data: 'dni', searchable: true  },
                        { data: 'bancocomunal' , searchable: false },
                        { data: 'fecha', searchable: false },
                        { data: 'asesor', searchable: false },
                        { data: 'monto', searchable: false ,
                            render: function ( data, type, row) {
                                    let to = (row.cuota).split('.');
                                    let tot = 0;
                                    if(to[0] == ""){
                                        tot = 'S/'+0.00;
                                    }else{
                                    tot = 'S/'+row.cuota;
                                    }
                                    return tot;
                                }
                        },
                        { data: 'plazo', searchable: false  },
                        { data: 'cuota' , searchable: false ,
                            render: function ( data, type, row) {
                                let to = (row.cuota).split('.');
                                let tot = 0;
                                if(to[0] == ""){
                                    tot = 'S/'+0.00;
                                }else{
                                tot = 'S/'+row.cuota;
                                }
                                return tot;
                            }
                        },
                        { data: 'nivelriesgo' , searchable: false},
                        { data: 'subneto' , searchable: false ,
                            render: function ( data, type, row) {
                                    let to = (row.subneto).split('.');
                                    let tot = 0;
                                    if(to[0] == ""){
                                        tot = 'S/'+0.00;
                                    }else{
                                    tot = 'S/'+row.subneto;
                                    }
                                    return tot;
                                }
                        },
                        { data: 'deudaexterna', searchable: false ,
                            render: function ( data, type, row) {
                                    let to = (row.deudaexterna).split('.');
                                    let tot = 0;
                                    if(to[0] == ""){
                                        tot = 'S/'+0.00;
                                    }else{
                                    tot = 'S/'+row.deudaexterna;
                                    }
                                    return tot;
                                }
                        },
                        { data: 'ingresoneto' , searchable: false ,
                            render: function ( data, type, row) {
                                        let to = (row.deudaexterna).split('.');
                                        let tot = 0;
                                        if(to[0] == ""){
                                            tot = 'S/'+0.00;
                                        }else{
                                        tot = 'S/'+row.deudaexterna;
                                        }
                                        return tot;
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
            <table id="preevaluacion-table"  class="table table-hover  table-responsive border" style="width:100%">
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





