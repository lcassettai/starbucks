<?php  
session_start();

if(!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])){
    header('Location: login.php?sinLoguear=true');
}

include_once 'db/DbConection.php';

try{
    $DbConection = new DbConection();
    $pdo = $DbConection->dbConnect();

    $obtenerProductos = $pdo->prepare(
        "SELECT * FROM productos");
    $obtenerProductos->execute();
    
    if($obtenerProductos->rowCount() > 0){
        $productos = $obtenerProductos->fetchAll(PDO::FETCH_ASSOC);    
    }else{
        $productos = [];
    }
   
}catch (PDOException $e) {
    $mensaje = ["danger","Algo salio mal"];
}

include 'layout/header.php';
include 'layout/menu.php';

?>

<div class="container mt-3">
    <div class="row">
        <h1 class="text-center">LISTADO DE PRODUCTOS</h1>
        <div class="panel-large">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($productos as $i => $p):?>
                    <tr>
                        <th scope="row"><?= $i+1;?> </th>
                        <td><?=$p['producto'];?></td>
                        <td>$<?=$p['precio'];?></td>
                        <td><input style="max-width: 60px;" type="number"></td>
                        <td><button class="btn btn-sm btn-success">Agregar</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a style="width: 100%;" href="productos.php" class="btn btn-primary">FINALIZAR PEDIDO</a>
        </div>
    </div>
</div>

<?php include 'layout/footer.php';?>