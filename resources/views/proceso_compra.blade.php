
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GogoShop</title>
    <link rel="icon" type="image/x-icon" href="../images/iconGOGO.png">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/payment.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    

<div class="product-content" id="product-content">
   
    <div class="order" id="order">
                <img src="../images/GogoShop.png" id="logo-orden" alt="Logo">
                <br>
                <br>
                <br>
               
                <h2 >Orden</h2>
                <br>
            
                    <div class="table-2">
            
                        <table class="order-table" id="order-table">
                           
                            </table>
                            <h1  id="order-total"></h1>
                       <div class="order-address">
                        <h1>Dirección de envio</h1>
                        <div class="form-group">
                            <label for="country">Pais:</label>
                            <select id="country" name="country" required>
                                <option value="">Selecciona un país</option>
                            </select>
                        </div>
                        <input  id="id" type="hidden">
                        <input  id="id_usuario">
                        <div class="form-group">
                            <label for="name">Nombre completo:</label>
                            <input type="text" name="name" id="name" >
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Eletronico:</label>
                            <input type="email" name="email" id="email" >
                        </div>
                        <div class="form-group">
                            <label for="numberPhone">Numero de telefono:</label>
                            <input type="number" name="numberPhone" id="numberPhone" >
                        </div>
                        <div class="form-group">
                            <label for="addressLine">Nombre de la calle:</label>
                            <input type="text" name="addressLine" id="addressLine" >
                        </div>
                        <div class="form-group">
                            <label for="Apto">Apto, suite, unidad, etc. (opcional):</label >
                            <input type="text" name="apto" id="apto" >
                        </div>
                        
                        <div class="form-group">
                            <label for="department">Departamento:</label>
                            <select id="department" name="department" required>
                                <option value="">Selecciona un departamento</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">Ciudad:</label>
                            <select id="city" name="city" required>
                                <option value="">Selecciona un país</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="postalCode">Codigo postal:</label>
                            <input type="number" name="postalCode" id="postalCode" >
                        </div>
                        <br>
                        <div id="control_direccion">

                            
                        </div>
                       </div>
                    
                       
                    </div>
                    <div class="order-actions">
                    <p onclick="window.location.href = '/seller'"><< devolver</p>
                    <p onclick="continuar_compra()" id="pagoHecho">continuar >></p>
                </div>
            </div>
                <dialog id="paymentModal" >
        <form id="paymentForm">
        <div id="payment-element" style="text-align: center; width: 70vh; padding-left:60px"></div>
        <div id="partPay">

            <button id="payButton" type="submit" style="background-color: blue; color: white; border: none; border-radius: 25px; padding: 10px; width: 30vh" disabled>Pagar</button>
            <button type="button" id="closeModal">Cerrar</button>
            <p id="paymentMessage"></p>
        </div>
    </form>
</dialog>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://js.stripe.com/v3/"></script>
<script type="module" src="{{asset('js/proceso_compra.js')}}"  ></script>
<script type="module"src="{{asset('js/scriptPago.js')}}" ></script>
</body>
</html>