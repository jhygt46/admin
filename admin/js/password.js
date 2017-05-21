$(document).ready(function(){

    $('#entrar').click(function(){
        
        var id = $('#id').val();
        var code = $('#code').val();
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();
        
        $.ajax({
            url: "ajax/index.php",
            type: "POST",
            data: "accion=recuperar_password&id="+id+"&code="+code+"&pass1="+pass1+"&pass2="+pass2,
            success: function(data){
                
                if(data.op == 1){
                    
                    $('.msg').html("Se ha creado su Contrase&ntilde;a con Exito");
                    $('#pass1').val("");
                    $('#pass2').val("");
                }
                

            },
            error: function(e){
                console.log(e);
            }
        });

    });
    

});
