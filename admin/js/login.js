$(document).ready(function(){

    $('#entrar').click(function(){
        
        var user = $('#user').val();
        var pass = $('#pass').val();
        var tipo = $('#accion').val();
        
        $.ajax({
            url: "ajax/ingreso.php",
            type: "POST",
            data: "accion=ingreso&tipo="+tipo+"&user="+user+"&pass="+pass,
            success: function(data){
                
                console.log(data); // ELIMINAR
                if(data.op == 1){
                    
                    bien(data.message);
                    setTimeout(function () {
                        $(location).attr('href',"");
                    }, 2000);

                }
                if(data.op == 2){
                    
                    mal(data.message);
                    
                }

            },
            error: function(e){
                console.log(e);
            }
        });

    });
    
    $('.ltpass a').click(function(){
        
        $('.msg').html("");
        
        $('#user').css("border-color", "#ccc");
        $('#pass').css("border-color", "#ccc");
    
        $('#user').css("background-color", "#fcfcfc");
        $('#pass').css("background-color", "#fcfcfc");
        
        var tipo = $('#accion').val();
        if(tipo == "1"){
            $('#accion').val("2");
            $('.pa').hide();
            $(this).html("Desea Ingresar");
        }
        if(tipo == "2"){
            $('#accion').val("1");
            $('.pa').show();
            $(this).html("Perdio su contrase&ntilde;a?");
        }

        return false;
        
    });

});

function bien(msg){
    
    $('.msg').html(msg);
    $('.msg').css("color", "#666");
    
    $('#user').css("border-color", "#ccc");
    $('#pass').css("border-color", "#ccc");
    
    $('#user').css("background-color", "#fcfcfc");
    $('#pass').css("background-color", "#fcfcfc");
    
}

function mal(msg){
    
    $('#pass').val("");
    
    $('.msg').html(msg);
    $('.msg').css("color", "#E34A25");
    
    $('#user').css("border-color", "#E34A25");
    $('#pass').css("border-color", "#E34A25");
    
    $('#user').css("background-color", "#FCEFEB");
    $('#pass').css("background-color", "#FCEFEB");
    
    login1();
    login2();
    login3();
    login2();
    login3();
    login2();
    login3();
    login4();
    
}
function login1(){
    
    $(".login").animate({
        'padding-left': '+=15px'
    }, 200, function() {
        // Animation complete.
    });
    
}

function login2(){
    
    $(".login").animate({
        'padding-left': '-=30px'
    }, 200, function() {
        // Animation complete.
    });
    
}
function login3(){
    
    $(".login").animate({
        'padding-left': '+=30px'
    }, 200, function() {
        // Animation complete.
    });
    
}

function login4(){
    
    $(".login").animate({
        'padding-left': '-=15px'
    }, 200, function() {
        // Animation complete.
    });
    
}

