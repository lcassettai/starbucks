<?php  
session_start();

if(!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])){
    header('Location: login.php?sinLoguear=true');
}

include_once 'db/DbConection.php';

$detalle = $_SESSION['pedido'] ?? [];

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

if(isset($_POST['agregar'])){    
    $_SESSION["pedido"] = null;
    
    $id_producto = filter_var($_POST['id_producto'] , FILTER_SANITIZE_NUMBER_INT);
    $cantidad = filter_var($_POST['cantidad'] , FILTER_SANITIZE_NUMBER_INT);

    foreach($productos as $p){
        if($p['id_producto'] == $id_producto){
            $nuevoItem = $p;
            $nuevoItem['cantidad'] = $cantidad;
            break;
        }
    }

    $existe = false;
    foreach($detalle as $i => $d){
        if($d['id_producto'] == $id_producto){
            $detalle[$i]['cantidad'] += $cantidad;
            $existe = true;
            break;
        }
    }

    if(!$existe){
        $detalle[] = $nuevoItem; 
    }
    
    $_SESSION['pedido'] = $detalle;
}

if(isset($_POST['eliminar'])){
    $id_producto = filter_var($_POST['id_producto'] , FILTER_SANITIZE_NUMBER_INT);

    foreach( $_SESSION['pedido'] as $i => $p){
        if($p['id_producto'] == $id_producto){
            unset($_SESSION['pedido'][$i]);
            break;
        }
    }

    $detalle = $_SESSION['pedido'];
}

include 'layout/header.php';
include 'layout/menu.php';

?>

<div class="container mt-3">
    <div class="row">
        <h1 class="text-center">NUEVO PEDIDO</h1>
        <div class="col mt-3">
            <h2 class="text-center">Listado de productos</h2>
            <div class="panel">
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
                        <form action="" method="post">
                            <input type="hidden" value="<?= $p['id_producto']?>" name="id_producto">
                            <tr>
                                <th scope="row"><?= $i+1;?> </th>
                                <td><?=$p['producto'];?></td>
                                <td>$<?=$p['precio'];?></td>
                                <td><input style="max-width: 60px;" type="number" name="cantidad"  min="1" max="10" required></td>
                                <td><button type="submit" name="agregar" class="btn btn-sm btn-success">+</button></td>
                            </tr>
                        </form>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="col mt-3">
            <h2 class="text-center">Detalle Pedido</h2>
            <div class="panel">
                <table class="table" id="table-detalle">
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
                        <?php foreach($detalle as $i => $p):?>
                        <form action="" method="post">
                            <input type="hidden" value="<?= $p['id_producto']?>" name="id_producto">
                            <tr>
                                <th scope="row"><?= $i+1;?> </th>
                                <td><?=$p['producto'];?></td>
                                <td>$<?=$p['precio'];?></td>
                                <td><?=$p['cantidad']; ?></td>
                                <td><button type="submit" name="eliminar" class="btn btn-sm btn-danger">x</button></td>
                            </tr>
                        </form>
                        <?php endforeach; ?>                        
                    </tbody>
                </table>
                <a style="width: 100%;" href="productos.php" class="btn btn-primary">FINALIZAR PEDIDO</a>
            </div>
        </div>
    </div>
</div>

<script src="../assets/Js/pedido.js"></script>
<?php include 'layout/footer.php';?>