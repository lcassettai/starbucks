<?php
session_start();

if(!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])){
    header('Location: login.php?sinLoguear=true');
    exit;
}


if(!isset($_SESSION['pedido']) || empty($_SESSION['pedido'])){   
    header('Location: nuevoPedido.php?pedidoVacio=true') ;
    exit;
}

include_once 'db/DbConection.php';

try{
    $DbConection = new DbConection();
    $pdo = $DbConection->dbConnect();

    $pdo->beginTransaction();
    $sql = "INSERT INTO pedidos(id_cliente,id_empleado,id_estado,fecha) VALUES(?,?,?,NOW())";
    $resultado = $pdo->prepare($sql)->execute([$_SESSION['usuario']['id_cliente'],1,1,]);

    $pedido_detalle = $_SESSION['pedido'];

    //Obtenemos el id del pedido que insertamos arriba para asociarlo a el detalle
    $id_pedido = $pdo->lastInsertId();

    foreach($pedido_detalle as $p){
        $sql = "UPDATE productos SET stock = (stock  - ". $p['cantidad'].") where id_producto = ".  $p['id_producto'] ;
        $pdo->prepare($sql)->execute();

        $sql = "INSERT INTO pedido_detalle(id_pedido,cantidad,precio,id_producto) VALUES(?,?,?,?)";
        $pdo->prepare($sql)->execute([$id_pedido,$p['cantidad'],$p['precio'],$p['id_producto']]);
    }
    
    unset($_SESSION['pedido']);
    $pdo->commit();     
    if($resultado = true){
        header('Location: pedidos.php?pedidoGenerado=true') ;  
        exit;
    }else{
        header('Location: pedidos.php?errorPedido=true') ;
        exit;
    }
  
   
}catch (PDOException $e) {
    $pdo->rollback();
    header('Location: pedidos.php?errorPedido=true') ;
    exit;
}

?>