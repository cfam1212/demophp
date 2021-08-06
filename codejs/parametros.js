$(document).ready(function(){
    
    var error_parametro = '', tipoSave = 'add', count = 0, result = [], continuar = true;

    // $('#parameter_dialog').dialog({
    //     autoOpen:false,
    //     width:400
    // });
    
    mensaje = $('input#mensaje').val();
    if(mensaje != ''){
        alertify.success(mensaje);
    }

    $('#btnNuevo').click(function(){
        //$.redirect('parametronew.php', {'mensaje': ''});
        $.redirect('parametronew.php', {'mensaje': ''});
    });

    $(document).on("click","#btnEditar",function(){        
        fila = $(this).closest("tr");
        data = $('#tabledata').dataTable().fnGetData(fila);
        id = data[0];
        $.redirect('parametroedit.php', {'id': id});
    });

    $(document).on("click","#btnEliminar",function(){        
        fila = $(this).closest("tr");
        data = $('#tabledata').dataTable().fnGetData(fila);
        id = data[0];
        alert(id);
        //$.redirect('parametroedit.php', {'id': id});
    });

    $('#btnNext').click(function(){
        if($.trim($('#parametro').val()).length == 0)
        {
            error_parametro = 'Nombre del Parámetro es requerido';
            $('#error_parametro').text(error_parametro);
            $('#parametro').addClass('has-error');
        }else{
            error_parametro = '';
            $('#error_parametro').text(error_parametro);
            $('#parametro').removeClass('has-error');
        }

        if(error_parametro != '')
        {
            return false;
        }else
        {
            $('#list_parametrocab').removeClass('active active_tab1');
            $('#list_parametrocab').removeAttr('href data-toggle');
            $('#parametrocab').removeClass('active');
            $('#list_parametrocab').addClass('inactive_tab1');
            $('#list_parametrodet').removeClass('inactive_tab1');
            $('#list_parametrodet').addClass('active_tab1 active');
            $('#list_parametrodet').attr('href', '#parametrodet');
            $('#list_parametrodet').attr('data-toggle', 'tab');
            $('#parametrodet').addClass('active in');
        }
    });

    $('#btnPrev1').click(function(){
        $.redirect('parametroadmin.php');
    });

    $('#btnPrev2').click(function(){
        $('#list_parametrodet').removeClass('active active_tab1');
        $('#list_parametrodet').removeAttr('href data-toggle');
        $('#parametrodet').removeClass('active in');
        $('#list_parametrodet').addClass('inactive_tab1');
        $('#list_parametrocab').removeClass('inactive_tab1');
        $('#list_parametrocab').addClass('active_tab1 active');
        $('#list_parametrocab').attr('href', '#parametrocab');
        $('#list_parametrocab').attr('data-toggle', 'tab');
        $('#parametrocab').addClass('active in');
    });

    $("#btnAdd").click(function(){
        $("#formParam").trigger("reset");
        $("#divcheck").hide();
        $("#header").css("background-color","#6491C2");
        $("#header").css("color","white");
        $(".modal-title").text("Nuevo Parametro");  
        $("#btnAgregar").text("Agregar");
        $("#modalPARAMETER").modal("show");
        tipoSave = 'add';
        estado = 'Activo';
    });    

    $('#btnAgregar').click(function(){
        if($.trim($('#detalle').val()).length == 0)
        {
            Swal.fire({
                title: 'Información',
                type:'warning',
                text: 'Ingrese Detalle del Parámetro..!',
                showCloseButton: true,
            });
            return false;
        }

        if($.trim($('#valorv').val()).length == 0 && $.trim($('#valori').val()).length == 0 )
        {
            Swal.fire({
                title: 'Información',
                type:'warning',
                text: 'Ingrese Valor Texto o Valor Entero..!',
                showCloseButton: true,
            });
            return false;
        }

        if($.trim($('#valorv').val()).length > 0 && $.trim($('#valori').val()).length > 0 )
        {
            Swal.fire({
                title: 'Información',
                type:'warning',
                text: 'Ingrese Solo Valor Texto o Valor Entero..!',
                showCloseButton: true,
            });
            return false;
        }

        detalle = $.trim($('#detalle').val());
        valorv = $.trim($('#valorv').val());
        
        if($.trim($('#valori').val()).length == 0){
            valori = 0;
        }else{
            valori = $.trim($('#valori').val());
        }

        if(tipoSave == 'add')
        {
            $.each(result,function(i,item){
                if(item.arrydetalle.toUpperCase() == detalle.toUpperCase())
                {
                    Swal.fire({
                        title: 'Información',
                        type:'warning',
                        text: 'Nombre del Parámetro ya Existe..!'
                    });                    
                    continuar = false;
                    return false;
                }else{
                    $.each(result,function(i,item){
                        if(valori == 0)
                        {
                            if(item.arryvalorv.toUpperCase() == valorv.toUpperCase())
                            {
                                Swal.fire({
                                    title: 'Información',
                                    type:'warning',
                                    text: 'Valor Texto de Parámetro ya Existe..!'
                                });
                                continuar = false;
                                return false;
                            }else{
                                continuar = true;
                            }
                        }else
                        {
                            if(item.arryvalori == valori)
                            {
                                Swal.fire({
                                    title: 'Información',
                                    type:'warning',
                                    text: 'Valor Entero de Parámetro ya Existe..!'
                                });
                                continuar = false;
                                return false;
                            }else{
                                continuar = true;
                            }                            
                        }
                    });
                }
            });

            if(continuar){
                count = count + 1;
                let deshabilitar = ''
                if(count == 1){
                    deshabilitar  = 'disabled="disabled"';
                }
                output = '<tr id="row_' + count + '">';
                output += '<td style="display: none;">' + count + ' <input type="hidden" name="hidden_orden[]" id="orden' + count + '" value="' + count + '" /></td>';                
                output += '<td>' + detalle + ' <input type="hidden" name="hidden_detalle[]" id="detalle' + count + '" value="' + detalle + '" /></td>';
                output += '<td>' + valorv + ' <input type="hidden" name="hidden_valorv[]" id="valorv' +count + '" value="' + valorv + '" /></td>';
                output += '<td>' + valori + ' <input type="hidden" name="hidden_valori[]" id="valori' + count + '" value="' + valori + '" /></td>';
                output += '<td>' + estado + ' <input type="hidden" name="hidden_estado[]" id="estado' + count + '" value="' + estado + '" /></td>';
                output += '<td><div class="text-center"><div class="btn-group">'
                output += '<button type="button" name="subirnivel" class="btn btn-outline-primary btn-sm btnUp" ' + deshabilitar + ' id="btnUp' + count + '"><i class="fas fa-arrow-up"></i></button>';
                output += '<button type="button" name="btnEdit" class="btn btn-outline-info btn-sm ml-3 btnEdit" id="' + count + '"><i class="fas fa-file"></i></button>';
                output += '<button type="button" name="btnDelete" class="btn btn-outline-danger btn-sm ml-3 btnDelete" id="' + count + '"><i class="fas fa-trash"></i></button></div></div></td>';
                output += '</tr>';
                //console.log(output);
                
                $('#tblparameter').append(output);

                objeto = {
                    arryid : count,
                    arrydetalle : detalle,
                    arryvalorv : valorv,
                    arryvalori : valori,
                    arryestado : estado,
                    arrydisable :deshabilitar
                }
                result.push(objeto);
                $("#modalPARAMETER").modal("hide");
            }
        }
        else
        {
            continuar = false, seguir = false;
            if(detalleold.toUpperCase() != detalle.toUpperCase())
            {
                $.each(result,function(i,item)
                {
                    if(item.arrydetalle.toUpperCase() == detalle.toUpperCase())
                    {
                        Swal.fire({
                            title: 'Información',
                            type:'warning',
                            text: 'Nombre del Parámetro ya Existe..!'
                        });                    
                        continuar = false;
                        return false;
                    }else{
                        continuar = true;
                    }
                });
            }else continuar = true;

            if(continuar)
            {
                if(valori != 0)
                {
                    if(valoriold != valori)
                    {
                        $.each(result,function(i,item)
                        {
                            if(item.arryvalori == valori)
                            {
                                Swal.fire({
                                    title: 'Información',
                                    type:'warning',
                                    text: 'Valor Entero de Parámetro ya Existe..!'
                                });                    
                                seguir = false;
                                return false;
                            }else{
                                seguir = true;
                            }
                        });                        
                    }
                }else{
                    if(valorvold.toUpperCase() != valorv.toUpperCase())
                    {
                        $.each(result,function(i,item)
                        {
                            if(item.arryvalorv.toUpperCase() == valorv.toUpperCase())
                            {
                                Swal.fire({
                                    title: 'Información',
                                    type:'warning',
                                    text: 'Valor Texto de Parámetro ya Existe..!'
                                });                    
                                seguir = false;
                                return false;
                            }else{
                                seguir = true;
                            }
                        });
                    }else seguir = true;    
                }
            }

            if(seguir)
            {
                row_id = $('#hidden_row_id').val();
                output = '<td style="display: none;">' + norden + ' <input type="hidden" name="hidden_orden[]" id="orden' + row_id + '" value="'+ row_id + '" /></td>';
                output += '<td>' + detalle + ' <input type="hidden" name="hidden_detalle[]" id="detalle' + row_id + '" value="' + detalle + '" /></td>';
                output += '<td>' + valorv + ' <input type="hidden" name="hidden_valorv[]" id="valorv' + row_id + '" value="'+ valorv + '" /></td>';
                output += '<td>' + valori + ' <input type="hidden" name="hidden_valori[]" id="valori' + row_id + '" value="'+ valori + '" /></td>';
                output += '<td>' + estado + ' <input type="hidden" name="hidden_estado[]" id="estado' + row_id + '" value="'+ estado + '" /></td>';
    
                output += '<td><div class="text-center"><div class="btn-group">'
                output += '<button type="button" name="btnUp" class="btn btn-outline-primary btn-sm btnUp" ' + deshabilitar + ' id="btnUp' + row_id + '"><i class="fas fa-arrow-up"></i></button>';
                output += '<button type="button" name="btnEdit" class="btn btn-outline-info btn-sm ml-3 btnEdit" id="' + row_id + '"><i class="fas fa-file"></i></button>';
                output += '<button type="button" name="btnDelete" class="btn btn-outline-danger btn-sm ml-3 btnDelete" id="'+ row_id + '"><i class="fas fa-trash"></i></button></div></div></td>';
                $('#row_'+row_id+'').html(output);

                objIndex = result.findIndex((obj => obj.arryid == row_id));
                result[objIndex].arrydetalle = detalle;
                result[objIndex].arryvalorv = valorv;
                result[objIndex].arryvalori = valori;
                $("#modalPARAMETER").modal("hide");
            }
        }
    });

    $(document).on("click",".btnEdit",function(){
        $("#formParam").trigger("reset");
        row_id = $(this).attr("id");
        norden = $('#orden'+row_id+'').val();
        detalleold = $('#detalle'+row_id+'').val();
        valorvold = $('#valorv'+row_id+'').val();
        valoriold = $('#valori'+row_id+'').val();
        estadoold = $('#estado'+row_id+'').val();
        deshabilitar = $('#btnUp'+row_id+'').attr('disabled');
        tipoSave = 'edit';
        if(estadoold == "Activo"){
            $("#chkestado").prop("checked", true);
            $("#lblestado").text("Activo");
        }else{
            $("#chkestado").prop("checked", false);
            $("#lblestado").text("Inactivo");
        }
        $('#detalle').val(detalleold);
        $('#valorv').val(valorvold);
        $('#valori').val(valoriold == 0 ? '': valoriold);
        $('#hidden_row_id').val(row_id);
        $("#header").css("background-color","#6491C2");
        $("#header").css("color","white");
        $(".modal-title").text("Editar Parametro");
        $("#divcheck").show();
        $("#btnAgregar").text("Modificar");
        $("#modalPARAMETER").modal("show");
    });

    $("#chkestado").click(function(){
        checked = $("#chkestado").is(":checked");
        if(checked){
            $("#lblestado").text("Activo");
            estado = 'Activo';
        }else{
            $("#lblestado").text("Inactivo");
            estado = 'Inactivo';
        }
    });

    $(document).on("click",".btnDelete",function(){
        row_id = $(this).attr("id");
        detalle = $('#detalle'+row_id+'').val();
        Swal.fire({
            title: 'Está Seguro de Borrar '+ detalle ,
            text: 'El registro será eliminado..',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    Swal.close();                    
                    FunRemoveItemFromArr( result, detalle );
                    $('#row_'+row_id+'').remove();
                    count--;
                    if(count > 0)
                    {
                        FunInactivaButton();
                    }
                    FunReorganizarOrder(result);
                });
              }
        });
    });

    function FunInactivaButton() 
    {
        x = document.getElementsByClassName("btnUp");
        $("#"+x[0].id).prop('disabled',true);
    }
    
    function FunRemoveItemFromArr (arr, deta)
    {
        $.each(arr,function(i,item){
            if(item.arrydetalle == deta)
            {
                arr.splice(i, 1);
                return false;
            }else{
                continuar = true;
            }
        });        
    };

    function FunReorganizarOrder(arr)
    {
        otroval = 0;
        $.each(arr,function(i,item){
            otroval = otroval + 1;             
            FunOrderDelete(otroval,item.arryid,item.arrydetalle,item.arryvalorv,item.arryvalori,item.arryestado,item.arrydisable);
            item['arryid'] = parseInt(otroval);
        });
        
        FunCambiarId();
    }

    $(document).on("click",".btnUp",function(){
        row_id = $(this).attr("id");

        id_now = $('#orden'+row_id.substr(5)+'').val();
        ordennow = $('#orden'+id_now+'').val();
        detallenow = $('#detalle'+id_now+'').val();
        valorvnow = $('#valorv'+id_now+'').val();
        valorinow = $('#valori'+id_now+'').val();
        estadonow = $('#estado'+id_now+'').val();
        disablenow = $('#btnUp'+id_now+'').attr('disabled');
        //$('#hidden_row_id').val(id_now);
        //rowidnow = $('#hidden_row_id').val();

        id_ant = id_now-1;
        ordenant = $('#orden'+id_ant+'').val();
        detalleant = $('#detalle'+id_ant+'').val();       
        valorvant = $('#valorv'+id_ant+'').val();
        valoriant = $('#valori'+id_ant+'').val();
        estadoant = $('#estado'+id_ant+'').val();
        disableant = $('#btnUp'+id_ant+'').attr('disabled');
        //$('#hidden_row_id').val(id_ant);
        //rowidant = $('#hidden_row_id').val();

        // $.each(result,function(i,item){
        //     console.log(item);
        //     if(item.arrydetalle == detallenow){
        //         filanow = item.arryid;
        //         return false;
        //     }   
        // });

        // $.each(result,function(i,item){
        //     console.log(item);
        //     if(item.arrydetalle == detalleant){
        //         filaant = item.arryid;
        //     }
        //     if(item.arrydetalle == detallenow){
        //         filanow = item.arryid;
        //     }
        // });

        //filanow = $(this).closest('tr').attr('id');
        //$('tr').prop('id','row_' + id_ant);
        //filaant = $(this).closest('tr').attr('id');

        // resultado = result.find(deta => deta.arrydetalle == detallenow);
        // filanow = resultado['arryid'];
        // resultado = result.find(deta => deta.arrydetalle == detalleant);
        // filaant = resultado['arryid'];       
        // alert(filanow+' '+filaant);

        FunOrderFirts(id_ant,ordenant,detallenow,valorvnow,valorinow,estadonow,disableant);
        FunOrderLast(id_now,ordennow,detalleant,valorvant,valoriant,estadoant,disablenow);
        
    });

    function FunOrderFirts(rowid,orden,detalle,valorv,valori,estado,disable)
    {
        if(disable == 'disabled'){
            deshabilitar  = 'disabled="disabled"';
        }
        else{
            deshabilitar = ''
        }

        resultado = result.find(deta => deta.arrydetalle == detalle);
        resultado['arryid'] = parseInt(orden);

        output = '<td style="display: none;">' + orden + ' <input type="hidden" name="hidden_orden[]" id="orden' + rowid + '" value="'+ rowid + '" /></td>';
        output += '<td>' + detalle + ' <input type="hidden" name="hidden_detalle[]" id="detalle' + rowid + '" value="' + detalle + '" /></td>';
        output += '<td>' + valorv + ' <input type="hidden" name="hidden_valorv[]" id="valorv' + rowid + '" value="'+ valorv + '" /></td>';
        output += '<td>' + valori + ' <input type="hidden" name="hidden_valori[]" id="valori' + rowid + '" value="'+ valori + '" /></td>';
        output += '<td>' + estado + ' <input type="hidden" name="hidden_estado[]" id="estado' + rowid + '" value="'+ estado + '" /></td>';
        output += '<td><div class="text-center"><div class="btn-group">'
        output += '<button type="button" name="btnUp" class="btn btn-outline-primary btn-sm btnUp" ' + deshabilitar + ' id="btnUp' + rowid + '"><i class="fas fa-arrow-up"></i></button>';
        output += '<button type="button" name="btnEdit" class="btn btn-outline-info btn-sm ml-3 btnEdit" id="' + rowid + '"><i class="fas fa-file"></i></button>';
        output += '<button type="button" name="btnDelete" class="btn btn-outline-danger btn-sm ml-3 btnDelete" id="'+ rowid + '"><i class="fas fa-trash"></i></button></div></div></td>';
        $('#row_' + rowid + '').html(output);
    }

    function FunOrderLast(rowid,orden,detalle,valorv,valori,estado,disable)
    {
        if(disable == 'disabled'){
            deshabilitar  = 'disabled="disabled"';
        }
        else{
            deshabilitar = ''
        }

        resultado = result.find(deta => deta.arrydetalle == detalle);
        resultado['arryid'] = parseInt(orden);

        output = '<td style="display: none;">' + orden + ' <input type="hidden" name="hidden_orden[]" id="orden' + rowid + '" value="'+ rowid + '" /></td>';
        output += '<td>' + detalle + ' <input type="hidden" name="hidden_detalle[]" id="detalle' + rowid + '" value="' + detalle + '" /></td>';
        output += '<td>' + valorv + ' <input type="hidden" name="hidden_valorv[]" id="valorv' + rowid + '" value="'+ valorv + '" /></td>';
        output += '<td>' + valori + ' <input type="hidden" name="hidden_valori[]" id="valori' + rowid + '" value="'+ valori + '" /></td>';
        output += '<td>' + estado + ' <input type="hidden" name="hidden_estado[]" id="estado' + rowid + '" value="'+ estado + '" /></td>';
        output += '<td><div class="text-center"><div class="btn-group">'
        output += '<button type="button" name="btnUp" class="btn btn-outline-primary btn-sm btnUp" ' + deshabilitar + ' id="btnUp' + rowid + '"><i class="fas fa-arrow-up"></i></button>';
        output += '<button type="button" name="btnEdit" class="btn btn-outline-info btn-sm ml-3 btnEdit" id="' + rowid + '"><i class="fas fa-file"></i></button>';
        output += '<button type="button" name="btnDelete" class="btn btn-outline-danger btn-sm ml-3 btnDelete" id="'+ rowid + '"><i class="fas fa-trash"></i></button></div></div></td>';
        $('#row_' + rowid + '').html(output);
    }

    function FunOrderDelete(ordenx,rowmod,detalle,valorv,valori,estado,disable)
    {
        output = '<td style="display: none;">' + ordenx + ' <input type="hidden" name="hidden_orden[]" id="orden' + ordenx + '" value="'+ ordenx + '" /></td>';
        output += '<td>' + detalle + ' <input type="hidden" name="hidden_detalle[]" id="detalle' + ordenx + '" value="' + detalle + '" /></td>';
        output += '<td>' + valorv + ' <input type="hidden" name="hidden_valorv[]" id="valorv' + ordenx + '" value="'+ valorv + '" /></td>';
        output += '<td>' + valori + ' <input type="hidden" name="hidden_valori[]" id="valori' + ordenx + '" value="'+ valori + '" /></td>';
        output += '<td>' + estado + ' <input type="hidden" name="hidden_estado[]" id="estado' + ordenx + '" value="'+ estado + '" /></td>';
        output += '<td><div class="text-center"><div class="btn-group">'
        output += '<button type="button" name="btnUp" class="btn btn-outline-primary btn-sm btnUp" ' + disable + ' id="btnUp' + ordenx + '"><i class="fas fa-arrow-up"></i></button>';
        output += '<button type="button" name="btnEdit" class="btn btn-outline-info btn-sm ml-3 btnEdit" id="' + ordenx + '"><i class="fas fa-file"></i></button>';
        output += '<button type="button" name="btnDelete" class="btn btn-outline-danger btn-sm ml-3 btnDelete" id="'+ ordenx + '"><i class="fas fa-trash"></i></button></div></div></td>';
        $('#row_' + rowmod + '').html(output);
    }

    function FunCambiarId()
    {
        $("#tblparameter tbody tr").each(function (index) {
            id = $(this).attr('id');
            underScoreIndex = id.indexOf('_');
            id = id.substring(0,underScoreIndex+1)+(parseInt(index)+1);
            $(this).attr('id',id);
        });        
    }

    $('#btnSave').click(function(){
        nomparametro = $.trim($("#parametro").val());
        detalle = $.trim($("#descrip").val());

        if(nomparametro == ''){
            Swal.fire({
                title: 'Información',
                type:'warning',
                text: 'Ingrese Nombre del  Parámetro..!'
            });
            return false;            
        }

        if(count == 0)
        {
            Swal.fire({
                title: 'Información',
                type:'warning',
                text: 'Ingrese al menos un Parámetro..!'
            });
            return false;
        }

        $.ajax({
            url: "../../bd/parametrocrud.php",
            type: "POST",
            dataType: "json",
            data: {nomparametro:nomparametro, detalle:detalle, result:result, estado:'Activo', id:0, opcion:0},            
            success: function(data){
                if(data == 'OK-Insert'){
                    $.redirect('parametroadmin.php', {'mensaje': 'Grabado con Exito..!'}); 
                }else{
                    Swal.fire({
                        title: 'Información',
                        type:'warning',
                        text: 'Nombre del Parámetro ya Existe..!'
                    });
                }                
            },
            error: function (error) {
                console.log(error);
            }                            
        }); 

        // $("#tblparameter tbody tr").each(function (items) {
        //     var _orden, _detalle, _valorv, _valori, _estado;
        //     //console.log($(this).closest('tr').attr('id'));
        //     $(this).children("td").each(function (index) {
        //         switch(index){
        //             case 0:
        //                 _orden = $(this).text();
        //                 break;
        //             case 1:
        //                 _detalle = $(this).text();
        //                 break;
        //             case 2:
        //                 _valorv = $(this).text();
        //                 break;
        //             case 3:
        //                 _valori = $(this).text();
        //                 break;
        //             case 4:
        //                 _estado = $(this).text();
        //                 break;
        //         }
               
        //     });
        //     alert(_orden+' '+_detalle+' '+_valorv+' '+_valori+' '+_estado);
        // });
    });

});