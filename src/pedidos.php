<?php  
session_start();

if(!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])){
    header('Location: login.php?sinLoguear=true');
}

include_once 'db/DbConection.php';

try{
    $DbConection = new DbConection();
    $pdo = $DbConection->dbConnect();

    $obtenerPedidos = $pdo->prepare(
        "SELECT * 
        FROM pedidos as p INNER JOIN estados_pedidos as ep ON p.id_estado = ep.id_estado 
        WHERE id_cliente = :id_cliente");
    $obtenerPedidos->bindParam(':id_cliente',$_SESSION['usuario']['id_cliente']);
    $obtenerPedidos->execute();
    
    if($obtenerPedidos->rowCount() > 0){
        $pedidos = $obtenerPedidos->fetchAll(PDO::FETCH_ASSOC);    
        
        foreach($pedidos as $i =>  $p){
            $obtenerPedidos = $pdo->prepare(
                "SELECT cantidad,producto,pd.precio
                FROM pedido_detalle as pd INNER JOIN productos as p ON p.id_producto = pd.id_producto
                WHERE id_pedido = :id_pedido");
            $obtenerPedidos->bindParam(':id_pedido',$p['id_pedido']);
            $obtenerPedidos->execute();
            $pedidos[$i]['pedido_detalle'] = $obtenerPedidos->fetchAll(PDO::FETCH_ASSOC);
        }
    }else{
        $pedidos = [];
    }
   
}catch (PDOException $e) {
    $mensaje = ["danger","Algo salio mal"];
}

include 'layout/header.php';
include 'layout/menu.php';
?> 

<div class="container jumbotron">
    <div class="row">
        <div class="mt-3">
            <h1 class="text-center">MIS PEDIDOS</h1>
            <a href="productos.php" class="btn btn-primary mb-3">Nuevo Pedido</a>
            <div class="pedidos">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Cantidad de productos</th>
                            <th scope="col">Estado</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>              
                        <?php if(!empty($pedidos)): ?>                
                        <?php foreach($pedidos as $pedido): ?>
                            <tr>  
                            <th scope="row"><?= $pedido['id_pedido']; ?></th>
                            <td><?=  date("d/m/Y", strtotime($pedido['fecha'])); ?></td>
                            <td class=>Cantidad</td>
                            <td><span class="badge text-bg-success"><?= strtoupper($pedido['estado']); ?></span></td>
                            <td><button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#pedido_<?= $pedido['id_pedido'] ?>">
                                    Ver
                                </button></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                                <tr>
                                    <td colspan="5">No existen pedidos</td>
                                </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->

<?php foreach($pedidos as $pedido): ?>
<!-- Modal -->
<div class="modal fade" id="pedido_<?= $pedido['id_pedido']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">PEDIDO #<?= $pedido['id_pedido']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0;?>
                        <?php foreach($pedido['pedido_detalle'] as $i => $detalle): ?>
                        <tr>
                            <th scope="row"><?= $i+1 ;?></th>
                            <td><?= $detalle['producto'] ?></td>
                            <td><?= $detalle['cantidad'] ?></td>
                            <td>$<?= $detalle['precio'] ?></td>
                        </tr>
                        <?php $total += $detalle['precio'];?>
                        <?php endforeach; ?>
                        <tr>
                        <td colspan="3" class="label-total text-end">Total</td>
                        <td>$<?= $total;?></td>
                        </tr>
                    </tbody>
                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php include 'layout/footer.php';?>