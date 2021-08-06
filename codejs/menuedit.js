$(document).ready(function(){

    var _continuar, _result = [], _menupadre, i, _contar, _menuid, _nameoldmenu, _estado, i, _contar, _checked, _dtbconorder, _row_index, 
    _fila, _tareaid, _check, _tarea, _estado, _checked, _btnchek, _tareaid, _nombremenu, _iconome, _opcionmp, _iconomp, _rowcollection;

    _continuar = true,  i = 0;    
    _nameoldmenu = $.trim($("#txtMenuname").val());
    //cbomenupadre = $.trim($("#cbomenupadre option:selected").text());  
    _menuid = $.trim($("#menuid").val());
    _estado = $("#lblEstado").text();

    if(_estado == "Activo"){
        $("#chkEstado").prop("checked", true);
    }

    $(document).on("click","#chkEstado",function(e){
        _checked = $("#chkEstado").is(":checked");

        if(_checked){
            $("#lblEstado").text("Activo");
            _estado = 'Activo';
        }else{
            $("#lblEstado").text("Inactivo");
            _estado = 'Inactivo';
        }
    });    

    $('#btnRegresar').click(function(){
        location.href="menu.php";
    });

    _dtbconorder = TableConOrder.rows().data();
    _contar = 0;

    _dtbconorder.each(function(value, index){
        if(value[1] == "SI"){
            _contar++;
        } 
    });    
    
    $(document).on("click","#btnSubirNivel",function(e){     
        e.preventDefault();
        _fila = $(this).closest('tr');
        _data = $('#tableconorder').dataTable().fnGetData(_fila);
        _row_index = $(this).closest("tr").index();
        _id = _data[0];

        if(_row_index == 0)
        {
            alertify.notify('No se puede Subir de Nivel..!', 'warning', 5, function () { console.log('dismissed'); });
            return;
        }

        $.ajax({
            url: "../bd/consultadatos.php",
            type: "POST",
            dataType: "json",
            data: {tipo:6, auxv1:"", auxv2:"", auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:0, auxi2:_menuid, auxi3:_id, auxi4:0, auxi5:0, 
            auxi6:0, opcion:1},
            success: function(data){                
                tableConOrder.clear().draw();
                //console.log(btnchek);
                $.each(data,function(i,item){                    
                    _tareaid = data[i].TareaId;
                    _check = data[i].Ckeck;
                    _tarea = data[i].Tarea;
                    _estado = data[i].Estado;
                    _checked = check == "SI" ? " checked='checked'" : "";                
                    _btnchek = '<td><div class="text-center"><input type="checkbox" id="chktarea" name="check[]"' + _checked + " value='" + 
                                _tareaid + "'/></div></td>"; 
                    TableConOrder.row.add([_tareaid, _check, _btnchek, _tarea, _estado]).draw();                
                });
            },
            error: function (error) {
                console.log(error);
            }
        }); 
    }); 

    $(document).on("click","#btnBajarNivel",function(e){     
        _fila = $(this).closest('tr');
        _data = $('#tableconorder').dataTable().fnGetData(_fila);
        _row_index = $(this).closest("tr").index();
        _id = _data[0];

        if(_row_index == _contar-1)
        {
            alertify.notify('No se puede Bajar de Nivel..!', 'warning', 2, function () { console.log('dismissed'); });
            return;
        }

        $.ajax({
            url: "../bd/consultadatos.php",
            type: "POST",
            dataType: "json",
            data: {tipo:6, auxv1:"", auxv2:"", auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:1, auxi2:_menuid, auxi3:_id, auxi4:0, auxi5:0, 
            auxi6:0, opcion:1},
            success: function(data){                
                tableConOrder.clear().draw();
                $.each(data,function(i,item){                    
                    _tareaid = data[i].TareaId;
                    _check = data[i].Ckeck;
                    _tarea = data[i].Tarea;
                    _estado = data[i].Estado;
                    _checked = check == "SI" ? " checked='checked'" : "";                
                    _btnchek = '<td><div class="text-center"><input type="checkbox" id="chktarea" name="check[]"' + _checked+ " value='"+
                                _tareaid+"'/></div></td>"; 
                    TableConOrder.row.add([_tareaid, _check, _btnchek, _tarea, _estado]).draw();                
                });
            },
            error: function (error) {
                console.log(error);
              }
        }); 
    });     

    $('#btnSave').click(function(){        
        _nombremenu = $.trim($("#txtMenuname").val());
        _iconome = $.trim($("#txtIconome").val());
        _opcionmp = $('#cboMenupadre').val();
        _menupadre = $.trim($('#txtMenump').val());
        _iconomp = $.trim($('#txtIconomp').val());
        ///************OBTENER EL VALOR DEL DROPDOWLIST*****************
        // combo = document.getElementById("cbomenupadre");
        // selected = combo.options[combo.selectedIndex].text;
        // alert(selected);

        if(_nombremenu == '')
        {
            alertify.notify('Ingrese Nombre del Menú..!', 'warning', 2, function () { console.log('dismissed'); });    
            return;
        }

        if(_nameoldmenu != _nombremenu){
            //BUSCAR SI EL NOMBRE DE MENU YA EXISTE
            $.ajax({
                url: "../bd/consultadatos.php",
                type: "POST",
                dataType: "json",
                data: {tipo:7, auxv1:"", auxv2:_nombremenu, auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:0, auxi2:0, auxi3:0, auxi4:0, 
                auxi5:0, auxi6:0, opcion:0},
                success: function(data){                    
                    if(data[0].contar == "0"){                         
                        _continuar = true;
                    }else{                      
                        _continuar = false;
                    }   
                    FunValidar(_continuar);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }else{
            FunValidar(true);
        }
    });

    function FunValidar(response){
        if(!response){
            alertify.notify('Nombre del Menú ya Existe..!', 'warning', 5, function () { console.log('dismissed'); });
        }else{
            if(_opcionmp == 2){
                if(_menupadre == ''){
                    alertify.notify('Ingrese Nombre del Menú Padre..!', 'warning', 5, function () { console.log('dismissed'); });
                }else{
                    $.ajax({
                        url: "../bd/consultadatos.php",
                        type: "POST",
                        dataType: "json",
                        data: {tipo:8, auxv1:"", auxv2:_menupadre, auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:0, auxi2:0, auxi3:0, auxi4:0,
                         auxi5:0, auxi6:0, opcion:0},
                        success: function(data){                    
                            if(data[0].contar == '0'){                        
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
                }
            }else{
                FunGrabar(true);
            }                
        }
    }

    function FunGrabar(response){
        if(!response){
            alertify.notify('Nombre del Menú Padre ya Existe..!', 'warning', 5, function () { console.log('dismissed'); });    
        }else{

            _rowcollection =  TableConOrder.$('input[type="checkbox"]', {"page": "all"});

            _rowcollection.each(function(index,elem){
                _objeto = {
                    tareaid : $(elem).val(),
                    check : $(this).prop("checked") == true ? "SI" : "NO"
                }
                _result.push(_objeto);
            });

            $.ajax({
                url: "../bd/menucrud.php",
                type: "POST",
                dataType: "json",
                data: {nombremenu:_nombremenu, iconome:_iconome, opcionmp:_opcionmp, menupadre:_menupadre, iconomp:_iconomp, result:_result, 
                    estado:_estado, id:_menuid, opcion:3},            
                success: function(data){ 
                    //location.href="menu.php";
                    $.redirect('menu.php', {'mensaje': 'Actualizado con Exito..!'}); 
                },
                error: function (error) {
                    console.log(error);
                }                            
            });   
        }
    }    
});