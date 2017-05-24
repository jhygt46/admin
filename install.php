<?php

if($_POST["accion"] == "crear"){

    $peso = "$";
    $data = "<?php";
    for($i=0; $i<2; $i++){
        $data .= " ".$peso."db_host[".$i."] = '".$_POST["server"]."'; ".$peso."db_user[".$i."] = '".$_POST["user"]."'; ".$peso."db_database[".$i."] = 'inicio'; ".$peso."db_password[".$i."] = '".$_POST["pass"]."';";
    }
    $data .= " ?>";
    file_put_contents("../config.php", $data);
    
}
    
?>
<!DOCTYPE html>
<html>
    <body>
        <h1>Base de Datos</h1>
        <form action="install.php" method="POST">
            <input type="hidden" name="accion" value="crear">
            Server:<br>
            <input type="text" name="server" value="localhost">
            <br>
            Usuario:<br>
            <input type="text" name="user" value="root">
            <br>
            Password:<br>
            <input type="password" name="pass">
            <br><br>
            <input type="submit" value="Submit">
        </form> 
    </body>
</html>