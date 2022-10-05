<?php  
session_start();

if(!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])){
    header('Location: login.php?sinLoguear=true');
}

include 'layout/header.php';
include 'layout/menu.php';

?>

<div class="container jumbotron">
    <div class="row">
        <div class="mt-3">
            <h1 class="text-center">STARBUCKS</h1>
            <h1 class="text-center mb-4">Bienvenido <?=$_SESSION['usuario']['nombre']?></h1>
            <div class="d-flex justify-content-center flex-column">
                <a class="btn btn-lg btn-success mb-3 btn-home" href="pedidos.php">VER MIS PEDIDOS</a>
                <a class="btn btn-lg btn-primary btn-home" href="nuevoPedido.php">NUEVO PEDIDO</a>
            </div>
        </div>
    </div>
</div>

<?php  include 'layout/footer.php';?>