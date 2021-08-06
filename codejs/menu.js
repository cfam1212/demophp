$(document).ready(function(){
    
    var _result = [], i = 0, _fila, _data, _id, _opcion, _nombremenu, _iconome, _opcionmp, _iconomp, _estado, _mensaje, _menu, _menuid, _icono;

    _mensaje = $('input#mensaje').val();

    if(_mensaje != ''){
        alertify.success(_mensaje);
    }

    $('#btnNuevo').click(function(){
        $.redirect('menunew.php'); 
    });

    $('#btnRegresar').click(function(){
        $.redirect('menu.php');
    });

    $(document).on("click","#btnSubirNivel",function(e){     
        _fila = $(this).closest('tr');
        _data = $('#tablenoorder').dataTable().fnGetData(_fila);
        // row_index = $(this).closest("tr").index();
        _id = _data[0];
        //nombremenu = "", iconome = "", opcionmp = "", menupadre = "", iconomp = "", estado = "";
        //result = [];
        _opcion = 2;

        // if(row_index == 0)
        // {
        //     Swal.fire({
        //         type: 'warning',
        //         title: 'Información',
        //         text: 'No se puede Subir de Nivel..!'
        //     });             
        //     return;
        // }

        $.ajax({
            url: "../bd/menucrud.php",
            type: "POST",
            dataType: "json",
            data: {id : _id, opcion : _opcion},            
            success: function(data){
                TableNoOrder.clear().draw();
                $.each(data,function(i,item){                    
                    _menuid = data[i].MenuId;
                    _menu = data[i].Menu;
                    _icono = data[i].Icono;
                    _estado = data[i].Estado;
                    TableNoOrder.row.add([_menuid, _menu, _icono, _estado]).draw();                
                });                
            },
            error: function (error) {
                console.log(error);
              }
        }); 
    }); 

    $(document).on("click","#btnEditar",function(){        
        _fila = $(this).closest("tr");
        _data = $('#tablenoorder').dataTable().fnGetData(_fila);
        _id = _data[0];
        _menu = _fila.find('td:eq(0)').text();
        $.redirect('menuedit.php', {'id': _id}); //POR METODO POST
    });   
    
    $(document).on("click","#btnEliminar",function(e){        
        _fila = $(this).closest("tr");
        _data = $('#tablenoorder').dataTable().fnGetData(_fila);
        _id = _data[0];
        _opcion = 1;
        //nombremenu = "", iconome = "", opcionmp = "", menupadre = "", iconomp = "", estado ="Activo";
        //result = [];
        _menu = fila.find('td:eq(0)').text();
        DeleteMenu();
    });     

    function DeleteMenu(){
        Swal.fire({
            title: 'Está Seguro de Borrar '+ _menu ,
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
                        url: "../bd/menucrud.php",
                        type: "POST",
                        dataType: "json",
                        data: {id : _id, opcion : _opcion},
                        success: function(data){
                            if(data == 'NO'){
                                Swal.fire({
                                    type:'warning',
                                    title:'Menu no se puede Eliminar, Tiene Tareas Asociadas..!',
                                });  
                            }       
                            else {
                                Swal.close();
                                tableData.row(fila.parents('tr')).remove().draw();
                                alertify.error('Registro Eliminado..!');
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

    $('#btnSave').click(function(){
        _id = 0;
        _opcion = 0;
        _nombremenu = $.trim($("#txtmenuname").val());
        _iconome = $.trim($("#txticonome").val());
        _opcionmp = $('#cbomenupadre').val();
        _menupadre = $.trim($('#txtmenump').val());
        _iconomp = $.trim($('#txticonomp').val());
        _estado = "Activo";

        if(_nombremenu == '')
        {
            Swal.fire({
                type: 'info',
                title: 'Información',
                text: 'Ingrese Nombre del Menú..!'
            });    
            return false;
        }

        if(_opcionmp == 2){
            if(_menupadre == ''){
                Swal.fire({
                    type: 'info',
                    title: 'Información',
                    text: 'Ingrese Nombre del Menú Padre..!'
                });                  
                return false;                
            }
        }

        $("input[type=checkbox]:checked").map(function(){
            _result[i] = $(this).val();
            i++;       
        });

        if(i == 0)
        {
            Swal.fire({
                type: 'info',
                title: 'Información',
                text: 'Seleccione al menos una tarea..!'
            }); 
            return false;
        }

        $.ajax({
            url: "../bd/menucrud.php",
            type: "POST",
            dataType: "json",
            data: {nombremenu: _nombremenu, iconome: _iconome, opcionmp: _opcionmp, menupadre: _menupadre, iconomp: _iconomp, result: _result, 
                estado: _estado, id: _id, opcion: _opcion},            
            success: function(data){   
                if(data == '0'){
                    $.redirect('menu.php', {'mensaje': 'Guardado con Exito..!'});
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'Información',
                        text: 'Nombre del Menú/o Menú Padre ya Existe..!'
                    });                    
                }
            },
            error: function (error) {
                console.log(error);
              }                            
        });        
    });    

});
