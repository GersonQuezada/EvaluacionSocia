@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Pre Evaluadores')

@section('js')

        <script>
            'use strict';
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
                                            url: "{{route('PreEvaluadorSocia.index')}}", // or "/ajax-handler/" depending on your setup
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

                        ajax: {
                            url: "{{route('PreEvaluadorSocia.index')}}",
                            data : function(data){
                                data.from_date = $('#dateRange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                                data.end_date = $('#dateRange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                            }
                        },
                        aoColumns: [
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
                            { data: 'FECHAVIGENCIA', searchable: false },
                            { data: null,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `
                                        <button type="button"
                                        class="btn btn-info col-sm-3"
                                        data-toggle="modal"
                                        data-target="#modal_1"
                                        onclick="editarRegistro('${row.CODPREEVALUADOR}')">
                                        <i class="fa-solid fa-user-plus"></i>
                                        </button>
                                    `;
                                }
                            }

                        ],
                        bPaginate:true,
                        bDestroy: true,
                });

            });
            // Escucha el evento 'hidden.bs.modal' del modal
            $('#modal_1').on('hidden.bs.modal', function () {
                // Limpia los campos del modal
                $('#modal_1').find('input[type=text], input[type=number]').val('');
                 // Elimina la clase 'is-invalid' y otras clases de error
                $('#modal_1').find('input[type=text], input[type=number]').removeClass('is-invalid').removeClass('is-valid');
                // Limpia los mensajes de error
                $('#modal_1').find('.invalid-feedback').html('');
            });
            let CapacidadPagosOriginal = '0.00';
            let id;
            function editarRegistro(id) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('PreEvaludores.id') }}",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}" // Agregar el token CSRF como un encabezado
                    },
                    success: function (data) {
                        //Pasammos Valores a los campos del Modal
                        document.getElementById('SociaName').value = data[0].nombrecompleto;
                        document.getElementById('BancaComunal').value = data[0].bancocomunal;
                        document.getElementById('SubIngresosNetos').value = data[0].subneto;
                        document.getElementById('IngresoNeto').value = data[0].ingresoneto;
                        document.getElementById('CapacidadPago').value = data[0].capacidadpago;
                        document.getElementById('DeudaExterna').value = data[0].deudaexterna;
                        CapacidadPagosOriginal = data[0].capacidadpago;
                        document.getElementById('id').value = data[0].CODPREEVALUADOR;
                    }
                });
            }

            function validateDecimal(event) {
                const input = event.target.value;
                const parts = input.split('.');

                // Si hay más de una parte (es decir, si se ingresó un punto), limitamos la parte decimal a dos dígitos
                if (parts.length > 1) {
                    const integerPart = parts[0];
                    let decimalPart = parts[1];

                    // Limitamos la parte decimal a dos dígitos
                    decimalPart = decimalPart.substring(0, 2);

                    // Volvemos a unir las partes
                    event.target.value = integerPart + '.' + decimalPart;
                }
            }

            function CalculaCapacidadPago(event){
                validateDecimal(event);
                let CuotaActual = document.getElementById('CuotaEvaluado').value;
                let IngresoNeto = document.getElementById('IngresoNeto').value;
                // Verificar si CuotaActual es un número válido y no es cero
                if (!isNaN(CuotaActual) && CuotaActual !== 0 && CuotaActual !== null) {
                    // Calcular la nueva Capacidad de Pago
                    let nuevaCapacidadPago = IngresoNeto / CuotaActual;
                    // Verificar si la nueva Capacidad de Pago es un número finito
                    if (isFinite(nuevaCapacidadPago)) {
                        // Asignar el nuevo valor de CapacidadPago
                        document.getElementById('CapacidadPago').value = nuevaCapacidadPago.toFixed(2);
                    } else {
                        // Si la división resulta en Infinity o NaN, regresar al valor original
                        document.getElementById('CapacidadPago').value = CapacidadPagosOriginal;
                    }
                } else {
                    // Si CuotaActual no es válido o es cero, regresar al valor original
                    document.getElementById('CapacidadPago').value = CapacidadPagosOriginal;
                }
            }

            function CalcularIngresoNeto(event){
                validateDecimal(event);
                let SubIngresosNetos = document.getElementById('SubIngresosNetos').value;
                let DeudaExterna = document.getElementById('DeudaExterna').value;
                let Resultado = SubIngresosNetos - DeudaExterna;
                document.getElementById('IngresoNeto').value =  Resultado.toFixed(2);
            }

            function AgregarPreSolicitud(){
                $('#modal_1').find('input').removeClass('is-valid');
                $.ajax({
                    type: "POST",
                    url: "{{ route('PreEvaludores.register') }}",
                    data: {
                        id: document.getElementById('id').value,
                        nombrecompleto : document.getElementById('SociaName').value,
                        bancocomunal : document.getElementById('BancaComunal').value,
                        monto : document.getElementById('MtoEvaluado').value,
                        plazo : document.getElementById('PlazoEvaluado').value,
                        cuota : document.getElementById('CuotaEvaluado').value,
                        subneto : document.getElementById('SubIngresosNetos').value,
                        deudaexterna : document.getElementById('DeudaExterna').value,
                        ingresoneto : document.getElementById('IngresoNeto').value,
                        capacidadpago: document.getElementById('CapacidadPago').value
                    },
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}" // Agregar el token CSRF como un encabezado
                    },
                    success: function(data, status, xhr) {
                            if (data.error === true) {
                                // Mostrar mensaje de error por otro motivo
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message
                                });
                            } else {
                                // Mostrar mensaje de éxito
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Operación Exitosa',
                                    text: data.message
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Cerrar el modal
                                        $('#modal_1').modal('hide');
                                        // Recargar la página
                                        location.reload();
                                    }
                                });
                            }
                    },
                        error: function(xhr, status, error) {
                            // console.log(xhr.status);
                            if (xhr.status === 422) {
                                // Mostrar mensaje de error general
                                var response = xhr.responseJSON;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                                if (response.errors) {
                                    $('input').removeClass('is-invalid');
                                    $('#modal_1').find('.invalid-feedback').html('');
                                    $.each(response.errors, function(key, value) {
                                        // Agregar clase de error al campo correspondiente
                                        $('input[name="' + key + '"]').addClass('is-invalid');
                                        // Mostrar el mensaje de error de validación
                                        $('input[name="' + key + '"]').closest('.col-sm-4').find('.invalid-feedback').html('<strong>' + value[0] + '</strong>');
                                    });

                                }
                            } else {
                                // Manejar otros códigos de estado si es necesario
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error ' + xhr.status + ': ' + error
                                });
                            }
                    }
                });

            }
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
    <div class="modal fade-primary" data-backdrop="static" id="modal_1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header info">
                    <h5 class="modal-title">Registro - Pre Evaluador con mismo Analisis cualitativo y cuantitativo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id">
                                <label class="form-label">Nombres Completos:</label>
                                <input type="text" class="form-control" name="SociaName" id="SociaName" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Banca Comunal:</label>
                                <input type="text" class="form-control" name="BancaComunal" id="BancaComunal">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-label">Nuevo Monto Evaluado:</label>
                                <input type="number" step="any" class="form-control @error('monto') is-invalid @enderror " name="monto" id="MtoEvaluado" oninput="validateDecimal(event)">
                                <span class="invalid-feedback" role="alert">
                                    {{-- <strong>{{ $message }}</strong>  --}}
                                </span>

                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Nuevo Plazo Evaluado:</label>
                                <input type="number" class="form-control  @error('plazo') is-invalid @enderror" name="plazo" id="PlazoEvaluado" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" >

                                    <span class="invalid-feedback" role="alert">
                                        {{-- <strong>{{ $message }}</strong> --}}
                                    </span>
                                {{-- @enderror --}}
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Nueva Cuota Evaluado:</label>
                                <input type="number" step="any" class="form-control  @error('cuota') is-invalid @enderror" name="cuota" id="CuotaEvaluado" oninput="CalculaCapacidadPago(event)">
                                {{-- @error('cuota') --}}
                                    <span class="invalid-feedback" role="alert">
                                        {{-- <strong>{{ $message }}</strong> --}}
                                    </span>
                                {{-- @enderror --}}
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <label class="form-label">SubTotal Ingresos Netos:</label>
                                <input type="text" class="form-control" name="SubIngresosNetos" id="SubIngresosNetos" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Deuda Externa:</label>
                                <input type="number" step="any" class="form-control" name="DeudaExterna" id="DeudaExterna" oninput="CalcularIngresoNeto(event)">

                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ingresos Netos:</label>
                                <input type="text"  class="form-control" name="IngresoNeto" id="IngresoNeto" disabled>

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Capacidad de Pago:</label>
                                <input type="text" class="form-control" name="CapacidadPago" id="CapacidadPago" disabled>

                            </div>
                        </div>


                    {{-- <input type="number" class="form-control" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="NRODNI" id="NRODNI" placeholder="Nro Documento"> --}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary sm" onclick="AgregarPreSolicitud();">Grabar</button>
                </div>
            </div>
        </div>
    </div>
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
                            <th class="align-middle text-center text-black-50">Recalculo Pre Evaluador</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@stop





