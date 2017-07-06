<?php
// TODOS LOS ARCHIVOS EN PAGES//
session_start();
if(!isset($_SESSION['user']['info']['id_user'])){
    exit;
}
$path = $_SERVER['DOCUMENT_ROOT'];
if($_SERVER['HTTP_HOST'] == "localhost"){
    $path .= "/";
}
$path_ = $path."admin/class";
require_once($path_."/admin.php");
// TODOS LOS ARCHIVOS EN PAGES//

$admin = new Admin();
//$admin->seguridad(1);
$id_page = 1;
$titulo = "Imagenes";
$sub_titulo = "Crear Thumbr";

if(isset($_GET["nombre"])){
    
    $id = 1;
    $img_name = $_GET["nombre"];
    $path = "images/uploads/".$id_page;
    $complete = $path."/".$img_name;

}

?>

<style>
    /*
    * imgAreaSelect default style
    */
    #imagen{
        padding-left: 110px;
    }
    #imagen ul{

    }
    #imagen ul li{
        float: left;
    }
    #imagen ul li:nth-child(1){
        width: 400px;
    }
    #imagen ul li:nth-child(2){
        width: 150px;
    }
    .crop_preview_box_small{
        width: 150px;
        height: 150px;
        margin-left: 20px;
    }
    .crop_preview_box_big{
        width: 400px;
    }
    .crop_preview_box_big img{
        width: 400px;
    }
    .imgareaselect-border1 {
        background: url(border-v.gif) repeat-y left top;
    }

    .imgareaselect-border2 {
        background: url(border-h.gif) repeat-x left top;
    }

    .imgareaselect-border3 {
        background: url(border-v.gif) repeat-y right top;
    }

    .imgareaselect-border4 {
        background: url(border-h.gif) repeat-x left bottom;
    }

    .imgareaselect-border1, .imgareaselect-border2,
    .imgareaselect-border3, .imgareaselect-border4 {
        filter: alpha(opacity=50);
            opacity: 0.5;
    }

    .imgareaselect-handle {
        background-color: #fff;
        border: solid 1px #000;
        filter: alpha(opacity=50);
        opacity: 0.5;
    }

    .imgareaselect-outer {
        background-color: #000;
        filter: alpha(opacity=50);
        opacity: 0.5;
    }

    .imgareaselect-selection {  
    }
</style>
<script type="text/javascript" src="js/jquery.imgareaselect.js"></script>


<script type="text/javascript">

    $(document).ready(function(){
        
        $(".imgareaselect-selection").parent().remove();
        $(".imgareaselect-outer").remove();
        <?php if($img_name != ""){ ?>
            showResponse('<?php echo $path; ?>', '<?php echo $img_name; ?>');
        <?php } ?>

    });
    
    function resize(){
        
        var id = <?php echo $id; ?>;
        var x1 = $('#x1').val();
	var y1 = $('#y1').val();
	var x2 = $('#x2').val();
	var y2 = $('#y2').val();	
	
	var w = $('#w').val();
	var h = $('#h').val();
        var file = $('#filename').val();
        
        var send = {accion: "Resize", file: file, x1: x1, y1: y1, x2: x2, y2: y2, w: w, h: h, id: id};
        
        $.ajax({
            url: "ajax/index.php",
            type: "POST",
            data: send,
            success: function(data){
                
                if(data.reload == 1){
                    navlink('pages/'+data.page);
                }
                
            }
        });

    }
    
    
    
    function showResponse(path, name){

        $('#thumbviewimage').html('<img src="'+path+'/'+name+'" style="position: relative;" alt="Thumbnail Preview" />');
        $('#viewimage').html('<img class="preview" alt="" src="'+path+'/'+name+'"  id="thumbnail" />');
        $('#filename').val(name); 
        $('#thumbnail').imgAreaSelect({  aspectRatio: '1:1', handles: true  , onSelectChange: preview });

    }
    
    function preview(img, selection) {
        
	var scaleX = 150 / selection.width; 
	var scaleY = 150 / selection.height; 

	$('#thumbviewimage > img').css({
		width: Math.round(scaleX * img.width) + 'px', 
		height: Math.round(scaleY * img.height) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	
	var x1 = Math.round((img.naturalWidth/img.width)*selection.x1);
	var y1 = Math.round((img.naturalHeight/img.height)*selection.y1);
	var x2 = Math.round(x1+selection.width);
	var y2 = Math.round(y1+selection.height);
	
	$('#x1').val(x1);
	$('#y1').val(y1);
	$('#x2').val(x2);
	$('#y2').val(y2);	
	
	$('#w').val(Math.round((img.naturalWidth/img.width)*selection.width));
	$('#h').val(Math.round((img.naturalHeight/img.height)*selection.height));
	
    } 
    
</script>






<input type="hidden" name="x1" value="" id="x1" />
<input type="hidden" name="y1" value="" id="y1" />
<input type="hidden" name="x2" value="" id="x2" />
<input type="hidden" name="y2" value="" id="y2" />
<input type="hidden" name="w" value="" id="w" />
<input type="hidden" name="h" value="" id="h" />
<input type="hidden" name="wr" value="" id="wr" />
<input type="hidden" name="filename" value="" id="filename" />




<div class="title">
    <h1><?php echo $titulo; ?></h1>
    <ul class="clearfix">
        <li class="back" onclick="backurl()"></li>
    </ul>
</div>
<hr>
<div class="info">
    <div class="fc" id="info-0">
        <div class="minimizar m1"></div>
        <div class="close"></div>
        <div class="name"><?php echo $sub_titulo; ?></div>
        <div class="message"></div>
        <div class="sucont">

            <form action="" method="post" class="basic-grey">
                <fieldset>
                    <input id="id" type="hidden" value="<?php echo $id_pro; ?>" />
                    <input id="accion" type="hidden" value="ingresarImagen" />
                    <?php if($img_name == ""){ ?>
                    <label>
                        <span>Imagen:</span>
                        <input id="file_image" type="file" />
                        <div class="mensaje"></div>
                    </label>
                    <?php } ?>
                    <div id='imagen'>
                        <ul class='clearfix'>
                            <li>
                                <?php if($img_name != ""){ ?>
                                <div class="crop_preview_box_big" id="viewimage"><img class="preview" alt="" src="<?php echo $complete; ?>" id="thumbnail"></div>
                                <?php } ?>
                            </li>
                            <li>
                                <?php if($img_name != ""){ ?>
                                <div class="crop_preview_box_small" id="thumbviewimage" style="position:relative; overflow:hidden;"><img src="<?php echo $complete; ?>" style="position: relative;" alt="Thumbnail Preview"></div>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                    
                    <?php if($img_name == ""){ ?>
                    <label style='margin-top:20px'>
                        <span>&nbsp;</span>
                        <a id='button' onclick="form()">Enviar</a>
                    </label>
                    <?php }else{ ?>
                    <label style='margin-top:20px'>
                        <span>&nbsp;</span>
                        <a id='button' onclick="resize()">Enviar</a>
                    </label>
                    <?php } ?>
                </fieldset>
            </form>
            
        </div>
    </div>
</div>