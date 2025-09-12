<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GogoShop</title>
    <link rel="icon" type="image/x-icon" href="../images/iconGOGO.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset ('css/style.css')}}">
  
</head>
<body >

    <header class="header" >
        <div class="menu container">
            <a href="#" class="logo">GogoShop</a>
            <input type="checkbox" id="menu"/>
            <label for="menu">
                <i class="bi bi-list"></i>
               
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#lista-1">Productos</a></li>
                    <li><a href="#">Contacto</a></li>
                    <!-- <li><form method="POST" action="{{ route('logout') }}"> @csrf <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">Cerrar session</button></form></li> -->
                <li><a href="{{ route('profile.edit') }}">{{ Auth::user()->name }}</a></li>
                </ul>
            </nav>

            <div>
                <ul>
                    <li class="submenu">
                        
                            <i class="bi bi-bag-check" ></i>
                        
                        <div id="carrito">
                            <table id="lista-carrito">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th class="remover-nombre">Nombre</th>
                                        <th>Precio</th>
                                        <th>cantidad</th>

                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="botonera">
                                <a href="#" id="vaciar-carrito" onclick="vaciar_carrito()" class="btn-2">Vaciar carrito</a>
                                <a onclick="validar_productos()" id="pag" class="btn-2" >pagar</a>
                            </div>
                        </div>
                    </li>
                </ul>
               
            </div>
        </div>
        <div class="header-content container">
            <div class="header-img">
                <img src="../images/right.png" alt="">

            </div>
            <div class="header-txt" >
                <h1>Ofertas especiales</h1>
                <p>estrena las mejores prendas</p>
                <a href="#" class="btn-1">Informacion</a>
            </div>
        </div>
        
    </header>

    <section class="ofert container" id="remove-2">
        <div class="ofert-1">
            <div class="ofert-img">
                <img src="../images/f1.png" alt="">
            </div>
            <div class="ofert-txt">
                <h3>Producto 1</h3>
                <a href="#" class="btn-2">Informacion</a>
            </div>
        </div>
        <div class="ofert-1">
            <div class="ofert-img">
                <img src="../images/f2.png" alt="">
            </div>
            <div class="ofert-txt">
                <h3>Producto 2</h3>
                <a href="#" class="btn-2">Informacion</a>
            </div>
        </div>
        <div class="ofert-1">
            <div class="ofert-img">
                <img src="../images/f3.png" alt="">
            </div>
            <div class="ofert-txt">
                <h3>Producto 3</h3>
                <a href="#" class="btn-2">Informacion</a>
            </div>
        </div>
    </section>

<div id="notificacion">producto agregado con exito</div>

    <main class="productos container" id="lista-1">
        <h2 id="remove-3">Productos</h2>


        <div class="product-cards" id="productoss">

        </div>

        <div class="all-products" id="all-products">
            <h1 class="titleC">----- Ropa clasica</h1>
            <div class="product-cards" id="product-cards-clasico"></div>
            <h1 class="titleC">----- Dispositivos</h1>
            <div class="product-cards" id="product-cards-tecnologia"></div>
            <h1 class="titleC">----- Deporte</h1>
            <div class="product-cards" id="product-cards-deportivo"></div>
        

        
            
        </div>
        
    </main>
 
    
    <section class="icons container" id="remove-4">

        <div class="icon-1">
            <div class="icon-img">
                <img src="../images/i1.svg" alt="">
            </div>
            <div class="icon-text">
                <h3>Lorem ipsum, dolor sit.</h3>
               <p>amet consectetur adipisicing elit.</p>
            </div>
        </div>

        <div class="icon-1">
            <div class="icon-img">
                <img src="../images/i2.svg" alt="">
            </div>
            <div class="icon-text">
                <h3>Lorem ipsum, dolor sit.</h3>
               <p>amet consectetur adipisicing elit.</p>
            </div>
        </div>

        <div class="icon-1">
            <div class="icon-img">
                <img src="../images/i3.svg" alt="">
            </div>
            <div class="icon-text">
                <h3>Lorem ipsum, dolor sit.</h3>
               <p>amet consectetur adipisicing elit.</p>
            </div>
        </div>
    </section>

    <section class="blog container" id="remove-5">
        <div class="blog-1">
            <img src="../images/b1.jpg" alt="">
            <h3>Blog 1</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis maiores, alias
                 nemo praesentium facilis necessitatibus beatae magnam, nesciunt, itaque natus omnis
                  molestiae nobis. Similique eligendi, rem ratione cumque odio labore.
            </p>
        </div>

        <div class="blog-1">
            <img src="../images/b2.jpg" alt="">
            <h3>Blog 2</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis maiores, alias
                 nemo praesentium facilis necessitatibus beatae magnam, nesciunt, itaque natus omnis
                  molestiae nobis. Similique eligendi, rem ratione cumque odio labore.
            </p>
        </div>
        <div class="blog-1">
            <img src="../images/b3.jpg" alt="">
            <h3>Blog 3</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis maiores, alias
                 nemo praesentium facilis necessitatibus beatae magnam, nesciunt, itaque natus omnis
                  molestiae nobis. Similique eligendi, rem ratione cumque odio labore.
            </p>
        </div>
    </section>




    <footer class="footer">
        <div class="footer-content container">
            <div class="link">
                <h3>Lorem</h3>
                <ul>
                    <li><a href="#">Lorem</a></li>
                    <li><a href="#">Lorem</a></li>
                    <li><a href="#">Lorem</a></li>
                    <li><a href="#">Lorem</a></li>
                </ul>
            </div>
            
        </div>
    </footer>

    

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
   <script src="{{ asset('js/script.js')}}"></script>
</body>
</html>