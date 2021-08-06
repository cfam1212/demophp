$(document).ready(function(){
    
    var _id, _opcion, _data, _estado, _fila, _nameoldtarea, _ruta, _icono, _checked, _row, _tarea

    $("#modalTAREA").draggable({
        handle: ".modal-header"
    }); 

    $("#btnNuevo").click(function(){
        $("#formTarea").trigger("reset");
        $("#divcheck").hide();
        $("#header").css("background-color","#6491C2");
        $("#header").css("color","white");
        $(".modal-title").text("Nueva Tarea");  
        $("#modalTAREA").modal("show");
        _id = 0;
        _opcion = 1;
        _data = null;
        _estado = 'Activo';
    });

    $(document).on("click","#btnEditar",function(e){      
        _fila = $(this).closest("tr");
        _data = $('#tabledata').dataTable().fnGetData(_fila);
        _id = _data[0];
        _nameoldtarea = $.trim(_fila.find('td:eq(0)').text());
        _ruta = $.trim(_fila.find('td:eq(1)').text());
        _icono = $.trim(_fila.find('td:eq(2)').text());
        _estado = $.trim(_fila.find('td:eq(3)').text());

        $("#txtTarea").val(_nameoldtarea);
        $("#txtRuta").val(_ruta);
        $("#txtIcono").val(_icono);

        _opcion = 2;

        if(_estado == "Activo"){
            $("#chkEstado").prop("checked", true);
            $("#lblEstado").text("Activo");            
        }else{
            $("#chkEstado").prop("checked", false);
            $("#lblEstado").text("Inactivos");
        }

        $("#divcheck").show();
        $("#header").css("background-color","#6491C2");
        $("#header").css("color","white");
        $(".modal-title").text("Editar Tarea");
        $("#modalTAREA").modal("show");
    });

    
    $(document).on("click","#chkEstado",function(){
        _checked = $("#chkEstado").is(":checked");
      
        if(_checked){
          $("#lblEstado").text("Activo");
          _estado = 'Activo';
      }else{
          $("#lblEstado").text("Inactivo");
          _estado = 'Inactivo';
      }
    });

    $(document).on("click","#btnEliminar",function(e){
        _fila = $(this);  
        _row = $(this).closest('tr');
        _data = $('#tabledata').dataTable().fnGetData(_row);
        _id = _data[0];
        _tarea = $(this).closest("tr").find('td:eq(0)').text(); 
        _opcion = 3;
        DeleteTarea();        
    });
    
    function DeleteTarea(){
        Swal.fire({
            icon: 'error',
            title: 'Está Seguro de Borrar '+ _tarea ,
            text: 'El registro será eliminado..',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: "../bd/tareacrud.php",
                        type: "POST",
                        dataType: "json",
                        data: {opcion: 1, id: _id},                        
                        success: function(data){
                            //console.log(data);
                            if(data == "NO"){
                                swal.close();
                                alertify.notify('Tarea no se puede Eliminar, está asociada a un Menú..!', 'success', 2, 
                                function () { console.log('dismissed'); });  
                            }       
                            else {
                                Swal.close();
                                TableData.row(_fila.parents('tr')).remove().draw();
                                alertify.notify('Registro Eliminado..!', 'error', 2, function () { console.log('dismissed'); });
                            }                            
                        },
                        error: function (error) {
                            console.log(error);
                        }                  
                    });
                });
              }            
        });
    }
    
    $("#formTarea").submit(function(e){
        e.preventDefault();
        _tarea = $.trim($("#txtTarea").val());
        _ruta = $.trim($("#txtRuta").val());
        _icono = $.trim($("#txtIcono").val());
        if(_opcion == 2){            
            if(_nameoldtarea != _tarea){
                $.ajax({
                    url: "../bd/tareacrud.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:2, id: _id, tarea: _tarea, ruta:_ruta, icono:_icono, estado:_estado},            
                    success: function(data){
                        if(data == '1'){
                            Swal.fire({
                                icon: 'info',
                                title: 'Información',
                                text: 'Tarea ya Existe!!.'                                
                            });                    
                        }else{
                            FunGrabar();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }                            
                });                
            }else{
                FunGrabar();
            }
        }else{
            FunGrabar();
        }        
    });
    
    function FunGrabar(){
        $.ajax({
            url: "../bd/tareacrud.php",
            type: "POST",
            dataType: "json",
            data: {opcion:0, id:_id, tarea:_tarea, ruta:_ruta, icono:_icono, estado:_estado},            
            success: function(data){
                if(data == 'SI'){
                    Swal.fire({
                        icon: 'info',
                        title: 'Información',
                        text: 'Tarea ya Existe!!.'
                    });                    
                }else{
                    //console.log(data);
                    _tareaid = data[0].TareaId;
                    _tarea = data[0].Tarea;
                    _ruta = data[0].Ruta;
                    _icono = data[0].Icono
                    _estado = data[0].Estado;
                    if(_tareaid == 100001 || _tareaid == 100002 || _tareaid == 100003 || _tareaid == 100004){
                        _desactivar = 'disabled="disabled"';
                    }else{
                        _desactivar = '';
                    }
                    _boton = '<td><div class="text-center"><div class="btn-group"><button class="btn btn-outline-info btn-sm ml-3"' +
                             'id="btnEditar"><i class="fas fa-file"></i></button><button class="btn btn-outline-danger btn-sm ml-3"'+
                            _desactivar + 'id="btnEliminar"><i class="fas fa-trash"></i></button></div></div></td>'   
                    if(_opcion == 1){
                        TableData.row.add([_tareaid, _tarea, _ruta, _icono, _estado, _boton]).draw();
                    }
                    else{
                        TableData.row(_fila).data([_tareaid, _tarea, _ruta, _icono, _estado, _boton]).draw();
                    }  
                    alertify.success("Grabado Correctamente..!");  
                    $("#modalTAREA").modal("hide");
                }
            },
            error: function (error) {
                console.log(error);
              }                            
        }); 
    }    

});