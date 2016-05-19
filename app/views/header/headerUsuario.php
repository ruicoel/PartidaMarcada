<?php $usuario = $_SESSION['nome']; ?>

<div class="app-bar" id="menu-usuario">
    <span class="app-bar-divider"></span>
    <ul class="app-bar-menu">
        <li>
            <a href="" class="dropdown-toggle"><span class="mif-apps mif-2x"></span> Menu</a>
            <ul class="d-menu" data-role="dropdown">
                <li><a href="/partidamarcada/usuario/amigos">Amigos</a></li>
                
                <li><a href="/partidamarcada/partida/gerenciar/">Partidas</a></li>
            </ul>
        </li>
    </ul>
    <span class="app-bar-divider"></span>
    <ul class="app-bar-menu">
        <li><a href="/partidamarcada">Partida Marcada</a></li>
        <li><a href="">Quadras</a></li>
        <li><a href="">Sobre</a></li>
    </ul>

    <div class="app-bar-element place-right active-container">
        <span class="dropdown-toggle active-toggle"><span class="mif-cog"></span> <?php echo $usuario; ?></span>
        <div class="app-bar-drop-container padding10 place-right no-margin-top block-shadow fg-dark" data-role="dropdown" data-no-close="true" style="width: 220px; display: block;">
            <h2 class="text-light">Opções</h2>
            <ul class="unstyled-list fg-dark">
                <li><a href="/partidamarcada/usuario/perfil/<?php echo $_SESSION['id']; ?>" class="fg-white1 fg-hover-yellow">Meu perfil</a></li>
                <li><a href="/partidamarcada/usuario/atualizarperfil" class="fg-white2 fg-hover-yellow">Atualizar perfil</a></li>
                <li><a href="/partidamarcada/usuario/alteraremail" class="fg-white2 fg-hover-yellow">Alterar e-mail</a></li>
                <li><a href="/partidamarcada/usuario/alterarsenha" class="fg-white2 fg-hover-yellow">Alterar senha</a></li>
                <li><a href="" class="fg-white3 fg-hover-yellow" id="btn-usuario-deslogar">Sair</a></li>
            </ul>
        </div>
    </div>
</div>
<script>
    //deslogar usuário
    $("#btn-usuario-deslogar").on('click', function () {

        $.ajax({
            type: "get",
            url: "/partidamarcada/usuario/deslogar",
            success: function (resposta) {
                window.location.href = "/partidamarcada";
            }
        });

        return false;
    });
</script>