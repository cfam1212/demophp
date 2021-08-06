$(document).ready(function(){
    var _mensaje,_continuar,_crear,_modificar,_eliminar,_result,_fila,_row,_data,_id,_perfil,_observacion,_estado;

    _mensaje = $('input#mensaje').val();
    
    if(_mensaje != ''){
        alertify.success(_mensaje,'mensaje', 2, function(){console.log('dismissed');});
    }

    _continuar = true;
    _crear = 'NO', _modificar = 'NO', _eliminar = 'NO';
    _result = [];

    $('#btnNuevo').click(function(){        
        $.redirect('perfilnew.php', {'mensaje': ''});
    });

    $('#btnRegresar').click(function(){        
        $.redirect("perfil.php");
    });    

    $(document).on("click","#chkCrear",function(){
        if($("#chkCrear").is(":checked")){
            $("#lblCrear").text("SI");
            _crear = 'SI';
        }else{
            $("#lblCrear").text("NO");
            _crear = 'NO';
        }
    });

    $(document).on("click","#chkModificar",function(){
        if($("#chkModificar").is(":checked")){
            $("#lblModificar").text("SI");
            _modificar = 'SI';
        }else{
            $("#lblModificar").text("NO");
            _modificar = 'NO';
        }
    }); 
    
    $(document).on("click","#chkEliminar",function(){
        if($("#chkEliminar").is(":checked")){
            $("#lblEliminar").text("SI");
            _eliminar = 'SI';
        }else{
            $("#lblEliminar").text("NO");
            _eliminar = 'NO';
        }
    });
    
    $(document).on("click","#btnEditar",function(){        
        _fila = $(this).closest("tr");
        _data = $('#tabledata').dataTable().fnGetData(_fila);
        _id = _data[0];
        _perfil = _fila.find('td:eq(0)').text();
        //location.href='menuedit.php?id='+id; //POR METODO GET
        $.redirect('perfiledit.php', {'idperfil': _id}); //POR METODO POST
    });      

    $(document).on("click","#btnEliminar",function(e){
        _fila = $(this);  
        _row = $(this).closest('tr');
        _data = $('#tabledata').dataTable().fnGetData(_row);
        _id = _data[0];
        _perfil = $(this).closest("tr").find('td:eq(0)').text(); 
        
        if(_id == 1){
            alertify.warning('Perfil de Administrador no se puede Eliminar..!','mensaje', 2, function(){console.log('dismissed');}); 
        }else{
            $.ajax({
                url: "../bd/consultadatos.php",
                type: "POST",
                dataType: "json",
                data: {tipo:12, auxv1:"", auxv2:"", auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:_id, auxi2:0, auxi3:0, auxi4:0, auxi5:0, 
                auxi6:0, opcion:0},
                success: function(data){
                    if(data[0].contar == "0"){
                        _continuar = true;
                    }else{
                        _continuar = false;
                    }
                    FunValidar(_continuar);
                },
                error: function (error){
                    console.log(error);
                }
            });
        }
    });

    function FunValidar(respuesta){
        if(!respuesta){
            alertify.warning('Perfil tiene Menú/Tareas Asociadas..!','mensaje', 2, function(){console.log('dismissed');}); 
        }else{
            Swal.fire({
                title: 'Está Seguro de Borrar '+ _perfil ,
                text: 'El registro será eliminado..',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                            url: "../bd/consultadatos.php",
                            type: "POST",
                            dataType: "json",
                            data: {tipo:15, auxv1:"", auxv2:"", auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:_id, auxi2:0, auxi3:0, auxi4:0, 
                            auxi5:0, auxi6:0, opcion:0},
                            success: function(data){
                                Swal.close();
                                tableData.row(fila.parents('tr')).remove().draw();
                                alertify.error('Regisro Eliminado..!','mensaje', 2, function(){console.log('dismissed');});
                            },
                            error: function (error) {
                                console.log(error);
                            }                  
                        });
                    });
                  }            
            });
        }
    }

    $('#btnSave').click(function(){
        _perfil = $.trim($("#txtPerfil").val());
        _observacion = $.trim($("#txtDescripcion").val());
        _estado = "Activo";

        if(_perfil == '')
        {
            alertify.warning('Ingrese Nombre del Perfil..!','mensaje', 2, function(){console.log('dismissed');});  
            return;
        }
        var i = 0;

        $("input[type=checkbox]:checked").map(function(){
            if($(this).val() != 'on'){
                _result[i] = $(this).val();
                i++;
            }
        });

        if(i == 0)
        {
            alertify.warning('Seleccione al menos un opción Menu/Tareal..!','mensaje', 2, function(){console.log('dismissed');});
            return;
        }

        $.ajax({
            url: "../bd/consultadatos.php",
            type: "POST",
            dataType: "json",
            data: {tipo:14, auxv1:"", auxv2:_perfil, auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:0, auxi2:0, auxi3:0, auxi4:0, auxi5:0, auxi6:0, 
            opcion:0},
            success: function(data){                    
                if(data[0].contar == "0"){                         
                    _continuar = true;
                }else{                      
                    _continuar = false;
                }   
                FunGrabar(_continuar);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }); 
    
    function FunGrabar(respuesta){
        if(!respuesta){
            alertify.warning('Nombre del Perfil ya Existe..!','mensaje', 2, function(){console.log('dismissed');});
        }else{
            $.ajax({
                url: "../bd/perfilcrud.php",
                type: "POST",
                dataType: "json",
                data: {nombreperfil:_perfil, observacion:_observacion, result:_result, estado:_estado, crear:_crear, modificar:_modificar, 
                    eliminar:_eliminar, id:0, opcion:0},          
                success: function(data){                                        
                    $.redirect('perfil.php', {'mensaje': 'Guardado con Exito..!'});
                },
                error: function (error){
                    console.log(error);
                }                            
            });   
        }
    }
});