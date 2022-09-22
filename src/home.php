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
            <h1 class="text-center">Bienvenido <?=$_SESSION['usuario']['nombre']?></h1>
        </div>
    </div>
</div>

<?php  include 'layout/footer.php';?>