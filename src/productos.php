<?php  
session_start();

if(!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])){
    header('Location: login.php?sinLoguear=true');
}

include 'layout/header.php';
include 'layout/menu.php';

?> 

<div class="container mt-3">
    <div class="row">
            <div class="prod d-flex  justify-content-between align-items-center">
                <div class="prod-imagen img-responsive">
                    <img src="../assets/img/cafe.png" alt="">
                </div>
                <div class="prod-nombre">
                    CAFE CON LECHE
                </div>
                <div class="prod-precio">
                    $250.00
                </div>
                <div class="prod-precio">
                    <button class="btn btn-primary">
                        Agregar
                    </button>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="prod d-flex  justify-content-between align-items-center">
            <div class="prod-imagen img-responsive">
                <img src="../assets/img/te.jpg" alt="">
            </div>
            <div class="prod-nombre">
                TÉ CON MENTA
            </div>
            <div class="prod-precio">
                $200.00
            </div>
            <div class="prod-precio">
                <button class="btn btn-primary">
                    Agregar
                </button>
            </div>
    </div>
</div>

<?php include 'layout/footer.php';?>