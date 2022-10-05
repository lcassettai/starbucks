<?php  
session_start();

if(!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])){
    header('Location: login.php?sinLoguear=true');
}

define("PRODUCTOS_POR_PAGINA",5);

include_once 'db/DbConection.php';

$detalle = $_SESSION['pedido'] ?? [];

if(isset($_GET['pagina']) && !empty($_GET['pagina'])){  
    $pagina =  filter_var($_GET['pagina'] , FILTER_SANITIZE_STRING);
    $pagina = ($pagina-1) * PRODUCTOS_POR_PAGINA;
}else{
    $pagina = 0;
}


if(isset($_GET['filtro']) && !empty($_GET['filtro'])){  
    $filtro =  ' UPPER(producto) LIKE \'%' . strtoupper(filter_var($_GET['filtro'] , FILTER_SANITIZE_STRING)) . '%\' ';
}else{
    $filtro = ' 1 = 1 ';
}

try{
    $DbConection = new DbConection();
    $pdo = $DbConection->dbConnect();

    $obtenerProductos = $pdo->prepare(
        "SELECT * FROM productos WHERE ". $filtro  . ' LIMIT '.$pagina.','.PRODUCTOS_POR_PAGINA);
    $obtenerProductos->execute();
 
    if($obtenerProductos->rowCount() > 0){
        $productos = $obtenerProductos->fetchAll(PDO::FETCH_ASSOC);   
        
        $obtenerTotalProductos = $pdo->prepare(
            "SELECT count(*) as total FROM productos WHERE ". $filtro);
        $obtenerTotalProductos->execute();
        $totalProductos = $obtenerTotalProductos->fetch(PDO::FETCH_ASSOC);
        $totalProductos = $totalProductos['total'];
    }else{
        $productos = [];
        $totalProductos = 0;
    }
   
}catch (PDOException $e) {
    $mensaje = ["danger","Algo salio mal"];
}

if(isset($_POST['agregar'])){    
    $_SESSION["pedido"] = null;
    
    $id_producto = filter_var($_POST['id_producto'] , FILTER_SANITIZE_NUMBER_INT);
    $cantidad = filter_var($_POST['cantidad'] , FILTER_SANITIZE_NUMBER_INT);
    
    $stock = 0;
    foreach($productos as $p){
        if($p['id_producto'] == $id_producto){
            if($p['stock'] >= $cantidad){
                $nuevoItem = $p;
                $stock = $p['stock'];
                $nuevoItem['cantidad'] = $cantidad;
            }else{
                $_GET['cantidadMayorStock'] = true;
            }
            
            break;
        }
    }

    $existe = false;
    foreach($detalle as $i => $d){
        if($d['id_producto'] == $id_producto){
            if(($stock >= $detalle[$i]['cantidad'] + $cantidad)){
                $detalle[$i]['cantidad'] += $cantidad;
                $existe = true;
            }else{
                $_GET['cantidadMayorStock'] = true;
                $existe = true;
            }
            
            break;
        }
    }

    if(!$existe && !empty($nuevoItem)){
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

<div class="container mt-3 mb-3">
    <div class="row">
        <h1 class="text-center">NUEVO PEDIDO</h1>
        <?php if(isset($_GET['pedidoVacio'])):?>
        <div class="alert alert-danger" role="alert">
            Debes agregar al menos 1 producto a tu pedido!
        </div>
        <?php endif; ?>
        <?php if(isset($_GET['cantidadMayorStock'])):?>
        <div class="alert alert-danger" role="alert">
            No puedes agregar una cantidad mayor al stock!
        </div>
        <?php endif; ?>
        <div class="col mt-3">
            <h2 class="text-center">Listado de productos</h2>
            <div class="panel">
                <form class="row" method="GET">
                    <div class="col-auto">
                        <label for="filtro" class="visually-hidden">Filtrar producto</label>
                        <input type="text" class="form-control" id="filtro" name="filtro">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Filtrar</button>
                    </div>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($productos as $i => $p):?>
                        <form action="" method="post">
                            <input type="hidden" value="<?= $p['id_producto']?>" name="id_producto">
                            <tr>
                                <td><?=$p['producto'];?></td>
                                <td>$<?=$p['precio'];?></td>
                                <td><?=$p['stock'];?></td>
                                <td><input style="max-width: 60px;" type="number" name="cantidad" min="1" max="10"
                                        required></td>
                                <td><button type="submit" name="agregar" class="btn btn-sm btn-success">+</button></td>
                            </tr>
                        </form>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if($totalProductos > PRODUCTOS_POR_PAGINA):  ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php for($i = 1 ; $i <  ceil($totalProductos / PRODUCTOS_POR_PAGINA)+1 ; $i++):?>

                        <li class="page-item"><a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
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
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0;?>
                        <?php foreach($detalle as $i => $p):?>
                        <form action="" method="post">
                            <input type="hidden" value="<?= $p['id_producto']?>" name="id_producto">
                            <tr>
                                <th scope="row"><?= $i+1;?> </th>
                                <td><?=$p['producto'];?></td>
                                <td><?=$p['cantidad']; ?></td>
                                <td>$<?=$p['precio'];?></td>
                                <td><button type="submit" name="eliminar" class="btn btn-sm btn-danger">x</button></td>
                            </tr>
                        </form>
                        <?php $total += $p['cantidad'] * $p['precio'];?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="label-total text-end"><strong>Total</strong></td>
                            <td>$<?= $total;?></td>
                        </tr>
                    </tbody>
                </table>
                <a style="width: 100%;" href="finalizarPedido.php" class="btn btn-primary"
                    onclick="return confirm('Esta seguro que desea finalizar el pedido?')">FINALIZAR PEDIDO</a>
            </div>
        </div>
    </div>
</div>

<script src="../assets/Js/pedido.js"></script>
<?php include 'layout/footer.php';?>