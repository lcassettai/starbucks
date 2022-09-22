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
                        <tr>
                            <th scope="row">1</th>
                            <td>23/12/2020</td>
                            <td class=>2</td>
                            <td><span class="badge text-bg-warning">PENDIENTE</span></td>
                            <td><button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Ver
                                </button></td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>23/12/2020</td>
                            <td class=>2</td>
                            <td><span class="badge text-bg-success">ENTREGADO</span></td>
                            <td><button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Ver
                                </button></td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>23/12/2020</td>
                            <td class=>2</td>
                            <td><span class="badge text-bg-success">ENTREGADO</span></td>
                            <td><button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Ver
                                </button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">PEDIDO #1</h5>
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
                        <tr>
                        <th scope="row">1</th>
                        <td>Café con leche</td>
                        <td>2</td>
                        <td>$250</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Té</td>
                        <td>1</td>
                        <td>$200</td>
                        </tr>
                        <tr>
                        <td colspan="3" class="label-total text-end">Total</td>
                        <td>$450</td>
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
<?php include 'layout/footer.php';?>