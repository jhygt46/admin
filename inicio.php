<?php
session_start();
error_reporting(E_ALL);

if(isset($_SESSION['user']['info']['id_user'])){
        
    $page = "layout";
    include("includes/header.php");
    ?>
    <body>
        <?php include("includes/head.php"); ?>
        <div class="contenido">
            <?php include("includes/nav.php"); ?>
            <div class="cont">
                <div class="contenedor">
                    <div class='load error'>
                        <div class='msgloading'>

                            <div class='textload'>Error porfavor vuelva a intentarlo mas tarde</div>
                        </div>
                    </div>
                    <div class='load loading'>
                        <div class='msgloading'>
                            <div class="cssload-jumping">
                                <span></span><span></span><span></span><span></span><span></span>
                            </div>
                            <div class='textload'>Cargando...</div>
                        </div>
                    </div>
                    <ul class="sock_cont"></ul>
                    <div class='conthtml'>
                        
                        <?php
                            
                            /*
                            echo "<pre>";
                            print_r($_SESSION);
                            echo "</pre>";
                            */
                        
                        ?>
                            
                    </div>
                </div>
            </div>
            <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAq6hw0biMsUBdMBu5l-bai9d3sUI-f--g&libraries=places" async defer></script>-->
        </body>
    </html>
    
<?php } ?>