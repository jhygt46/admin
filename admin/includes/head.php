<input type="hidden" id="id_user" value="1">
<div class="header clearfix">
    <div class="titles"><strong>Fireapp</strong> - Software de Gesti&oacute;n de Bomberos</div>
    <div class="user-guide">
        <div class="image"></div>
        <div class="name"><?php echo $_SESSION['user']['info']['nombre']; ?></div>
        <div class="user-info">
            <ul class="clearfix">
                <li>Foto Aca</li>
                <li>
                    <div><?php echo $_SESSION['user']['info']['nombre']; ?></div>
                    <div>Administrador</div>
                    <div><a href="">Editar Perfil</a></div>
                    <div><a href="" onclick="salir()">Salir</a></div>
                </li>
            </ul>
        </div>
    </div>
</div>