// llamado de productos al back-end y ordenarlos en el front

let productos = []; // Lista de todos los productos disponibles (con stock)
let productosAñadidos = JSON.parse(localStorage.getItem("productos_carrito")) || []; // Productos en el carrito

// Elementos del DOM
const lista = document.querySelector("#lista-carrito tbody");
const mostrar_total = document.getElementById("pag");

/**
 * Llama a los productos desde el backend, inicializa el control de stock
 * y organiza la visualización en el frontend.
 */
async function llamarProductos() {
    try {
        // Simulación: Asume que el backend ahora devuelve productos con las propiedades necesarias
        // Se asumen valores por defecto si no están en el producto original para la funcionalidad del carrito
        const data = await (await fetch('/productos')).json();
        productos = data.map(p => ({
            ...p,
            // Añade propiedades por defecto para el carrito si no existen en el producto del backend
            peso: p.peso || 1.0, 
            unidadPeso: p.unidadPeso || 'kg',
            marmoleo: p.marmoleo || 'medio',
            maduracion: p.maduracion || 'medio',
            valido: p.valido !== undefined ? p.valido : true,
            contador: p.contador || 1 // contador para la cantidad/unidades, NO peso
        }));

        await control_stock(); // Asegura que el carrito refleje el stock actual
        organizar_categoria(); // Muestra los productos en las categorías del frontend

    } catch (error) {
        console.error("Error al llamar productos:", error);
    }
}

llamarProductos();

//-------------------------------------------------------------------

/**
 * Organiza los productos en sus respectivas categorías del frontend.
 */
function organizar_categoria() {
    let clasico = productos.filter(p => p.category === "clasico");
    productosFrontEnd(clasico, "product-cards-clasico");
    let teconologia = productos.filter(p => p.category === "tecnologia");
    productosFrontEnd(teconologia, "product-cards-tecnologia");
    let deportivo = productos.filter(p => p.category === "deportivo");
    productosFrontEnd(deportivo, "product-cards-deportivo");
}

/**
 * Genera el HTML para mostrar los productos en el frontend.
 * @param {Array} productosByType - Productos a mostrar.
 * @param {string} tag - ID del contenedor en el DOM.
 */
function productosFrontEnd(productosByType, tag) {
    let productosHTML = '';

    productosByType.forEach(p => {
        let botonAgregar = `<button class='agregar-carrito' onclick="agregar_carrito(${p.id})">Agregar al Carrito</button>`;

        if (p.stock === 0) {
            botonAgregar = `<button disabled class="agregar-carrito disabled">Sin stock</button>`;
        }

        productosHTML += `
            <div class="product">
                <img src="${p.image}" alt="">
                <div class="product-txt">
                    <h3>${p.name}</h3>
                    <p>${p.description}</p>
                    <p class="precio">$${p.price.toLocaleString('es-CO')}</p>
                    ${botonAgregar}
                </div>
            </div>`;
    });

    const container = document.getElementById(tag);
    if (container) {
        container.innerHTML = productosHTML;
    }
}

//-------------------------------------------------------------------

/**
 * Genera el HTML del carrito de compras basándose en `productosAñadidos`.
 * Adapta el diseño para reflejar las columnas Peso, Marmoleo y Maduración.
 */
function mostrar_carrito() {
    let precioTotal = 0;
    lista.innerHTML = ""; // Limpia la tabla
    mostrar_total.innerHTML = ""; // Limpia el botón de pagar

    productosAñadidos.forEach((producto, index) => {

        // Opciones para los select
        const unidades = ['kg', 'lb', 'gr'];
        const niveles = ['bajo', 'medio', 'alto'];

        // Genera el HTML para los selects de peso, marmoleo y maduración
        const selectPesoHTML = `
            <input type="number" min="0.1" step="0.1" value="${producto.peso}" 
                   style="width: 50px;" 
                   onchange="actualizar_propiedad_carrito(${producto.id}, 'peso', this.value)">
            <select onchange="actualizar_propiedad_carrito(${producto.id}, 'unidadPeso', this.value)">
                ${unidades.map(u => `<option value="${u}" ${producto.unidadPeso === u ? 'selected' : ''}>${u}</option>`).join('')}
            </select>`;

        const selectMarmoleoHTML = `
            <select onchange="actualizar_propiedad_carrito(${producto.id}, 'marmoleo', this.value)">
                ${niveles.map(n => `<option value="${n}" ${producto.marmoleo === n ? 'selected' : ''}>${n}</option>`).join('')}
            </select>`;

        const selectMaduracionHTML = `
            <select onchange="actualizar_propiedad_carrito(${producto.id}, 'maduracion', this.value)">
                ${niveles.map(n => `<option value="${n}" ${producto.maduracion === n ? 'selected' : ''}>${n}</option>`).join('')}
            </select>`;

        // Botón de borrar adaptado a la estructura original (X como enlace)
        const botonBorrarHTML = `<a href="#" class="borrar" data-id="${producto.id}" onclick="event.preventDefault(); eliminarDelCarrito(${index}, ${producto.id}, ${producto.contador})">X</a>`;
        
        // Estilo condicional si no hay stock
        const rowClass = producto.valido === false ? 'producto-sin-stock' : '';

        const producto_carrito = document.createElement("tr");
        producto_carrito.className = rowClass;

        // Estructura de la fila según el HTML provisto
        producto_carrito.innerHTML = `
            <td><img src="${producto.image}" width="50"></td>
            <td class="remover-nombre">${producto.name}</td>
            <td>${selectPesoHTML}</td>
            <td>${selectMarmoleoHTML}</td>
            <td>${selectMaduracionHTML}</td>
            <td>$${producto.price.toFixed(2)}</td>
            <td>
                <div class="cantidad">
                    <i class="fa fa-minus" onclick="decrementar_cantidad(${producto.id})"></i>
                    <p>${producto.contador}</p>
                    <i class="fa fa-plus" onclick="aumentar_cantidad(${producto.id})"></i>
                </div>
            </td>
            <td>${botonBorrarHTML}</td>`;

        // Cálculo del subtotal: Precio * Peso(kg, lb, gr) * Cantidad (unidades).
        // Simplificado a Precio * Cantidad (se asume que 'price' ya es por la unidad de peso/unidad de conteo)
        // Para cortes de carne, el precio suele ser por unidad de peso (e.g., kg) y se vende por peso * cantidad de cortes.
        // Simplificaremos a Precio * Cantidad (contador) * Peso (en unidad principal, e.g. kg, asumiendo una conversión si no es kg)
        // **Ajuste Importante**: La lógica de carrito original parece usar 'contador' como unidades y 'price' como precio por unidad.
        // El nuevo HTML introduce 'Peso' (input + select), pero la columna 'Cantidad' con +/- todavía existe.
        // Para mantener la consistencia con el código original, usaremos: `total = Precio * Contador (unidades)`
        // Si quisieras usar el peso para el cálculo sería: `total = Precio_por_kg * Peso_en_kg * Contador_unidades`
        // **Simplificando a Contador (unidades) solamente:**
        let subtotal = producto.price * producto.contador;
        precioTotal += subtotal;

        lista.appendChild(producto_carrito);
    });

    // Actualiza el botón de pagar
    if (precioTotal === 0) {
        mostrar_total.className = "a-deshabilitado";
        mostrar_total.innerHTML = `Pagar`;
    } else {
        mostrar_total.className = "btn-2";
        mostrar_total.innerHTML = `Pagar $${precioTotal.toLocaleString('es-CO', { minimumFractionDigits: 2 })}`;
    }
}

// Llama a mostrar_carrito al inicio para cargar la data del localStorage
mostrar_carrito();

//-------------------------------------------------------------------

/**
 * Función para actualizar las propiedades de un producto en el carrito (Peso, Marmoleo, Maduración).
 * @param {number} id - ID del producto.
 * @param {string} propiedad - Nombre de la propiedad a actualizar ('peso', 'unidadPeso', 'marmoleo', 'maduracion').
 * @param {any} valor - Nuevo valor.
 */
function actualizar_propiedad_carrito(id, propiedad, valor) {
    const productoEnCarrito = productosAñadidos.find(p => p.id === id);
    if (productoEnCarrito) {
        // Asegura que el peso sea un número
        if (propiedad === 'peso') {
            productoEnCarrito[propiedad] = parseFloat(valor);
        } else {
            productoEnCarrito[propiedad] = valor;
        }

        // Vuelve a guardar y mostrar para actualizar el carrito visualmente
        localStorage.setItem("productos_carrito", JSON.stringify(productosAñadidos));
        mostrar_carrito();
    }
}

/**
 * Sincroniza el stock de los productos en el carrito con el stock global.
 * Esta función es esencial para manejar productos fuera de stock.
 */
async function control_stock() {
    // Si la lista de productos disponibles (productos) está vacía, no podemos controlar el stock
    if (productos.length === 0) return;

    productosAñadidos.forEach(element => {
        let producto_descontar = productos.find(p => p.id === element.id);

        if (!producto_descontar) {
            // Producto en carrito que ya no existe en el catálogo
            element.valido = false;
            return;
        }

        if (producto_descontar.stock === 0) {
            // Producto en carrito sin stock
            element.valido = false;
            if (element.valido !== false) {
                // Muestra la alerta solo si el estado es nuevo (opcional, para evitar spam de alerta)
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: `El producto ${element.name} ya no tiene stock disponible.`,
                });
            }
            element.valido = false;

        } else if (element.contador > producto_descontar.stock) {
            // La cantidad en el carrito excede el stock disponible
            const stockAnterior = producto_descontar.stock;
            element.contador = producto_descontar.stock;
            producto_descontar.stock = 0; // Agota el stock restante
            element.stock = producto_descontar.stock;
            element.valido = true; // Sigue siendo válido, solo la cantidad fue ajustada
            Swal.fire({
                icon: "warning",
                title: "Stock limitado",
                text: `La cantidad de ${element.name} se ajustó a ${stockAnterior} debido a la disponibilidad.`,
            });
        } else {
            // Descuenta el stock normalmente
            producto_descontar.stock -= element.contador;
            element.stock = producto_descontar.stock;
            element.valido = true;
        }
    });

    localStorage.setItem("productos_carrito", JSON.stringify(productosAñadidos));
    mostrar_carrito();
}

/**
 * Agrega un producto al carrito.
 * @param {number} ident - ID del producto a agregar.
 */
function agregar_carrito(ident) {
    let seek = productos.find(product => product.id === ident);
    let repetido = productosAñadidos.find(look => look.id === ident);

    if (repetido) {
        // Se puede cambiar esta notificación para permitir aumentar la cantidad directamente
        return notificacionAgregarAlCarrito("Producto ya en el carrito.");
    }

    if (seek.stock <= 0) {
        return alert("Sin stock disponible para este producto.");
    }

    // Clonar el producto para no modificar el objeto original del catálogo
    let productoParaCarrito = {
        ...seek,
        contador: 1, // Inicializa la cantidad en 1 unidad/pieza
        valido: true
        // Las propiedades de peso, unidadPeso, marmoleo y maduración ya deberían estar en 'seek'
    };
    productosAñadidos.push(productoParaCarrito);

    // Decrementar el stock global
    seek.stock--;
    productoParaCarrito.stock = seek.stock;

    localStorage.setItem("productos_carrito", JSON.stringify(productosAñadidos));
    mostrar_carrito();
    organizar_categoria();
    notificacionAgregarAlCarrito(`Agregado ${seek.name} al carrito.`);
}

/**
 * Elimina un producto del carrito.
 * @param {number} index - Índice del producto en `productosAñadidos`.
 * @param {number} ident - ID del producto.
 * @param {number} contador - Cantidad (unidades) que se elimina.
 */
function eliminarDelCarrito(index, ident, contador) {
    let producto_aumentar = productos.find(p => p.id === ident);

    // Solo aumenta el stock si el producto todavía existe en el catálogo global
    if (producto_aumentar) {
        producto_aumentar.stock += contador;
    }

    // Elimina del array y actualiza localStorage
    productosAñadidos.splice(index, 1);
    localStorage.setItem("productos_carrito", JSON.stringify(productosAñadidos));

    mostrar_carrito();
    organizar_categoria();
}

/**
 * Aumenta la cantidad (contador) de un producto en el carrito.
 * @param {number} id - ID del producto.
 */
function aumentar_cantidad(id) {
    let encontrar = productosAñadidos.find(p => p.id === id);
    let producto_decrementar = productos.find(p => p.id === id);

    if (producto_decrementar && producto_decrementar.stock <= 0) {
        return alert("No hay más stock disponible para este producto.");
    }

    if (encontrar) {
        encontrar.contador++;
        if (producto_decrementar) {
            producto_decrementar.stock--;
            encontrar.stock = producto_decrementar.stock;
        }
        localStorage.setItem("productos_carrito", JSON.stringify(productosAñadidos));
        mostrar_carrito();
        organizar_categoria();
    }
}

/**
 * Decrementa la cantidad (contador) de un producto en el carrito.
 * @param {number} id - ID del producto.
 */
function decrementar_cantidad(id) {
    let encontrar = productosAñadidos.find(p => p.id === id);
    let producto_aumentar = productos.find(p => p.id === id);

    if (encontrar && encontrar.contador > 1) {
        encontrar.contador--;
        if (producto_aumentar) {
            producto_aumentar.stock++;
            encontrar.stock = producto_aumentar.stock;
        }
        localStorage.setItem("productos_carrito", JSON.stringify(productosAñadidos));
        mostrar_carrito();
        organizar_categoria();
    } else if (encontrar && encontrar.contador === 1) {
        // Opcional: Si el contador llega a 1, se podría preguntar si desea eliminar el producto.
        // Por ahora, lo dejamos en 1 como el código original.
        return;
    }
}

/**
 * Muestra una notificación temporal al agregar al carrito.
 * **Nota**: Asume que hay un elemento con ID 'notificacion' en el DOM.
 * @param {string} mensaje - Mensaje a mostrar.
 */
function notificacionAgregarAlCarrito(mensaje = "Producto agregado correctamente") {
    let noti = document.getElementById("notificacion");
    if (!noti) {
        // Si el elemento no existe, lo crea o simplemente hace un console.log
        console.log("Notificación:", mensaje);
        return;
    }

    noti.textContent = mensaje;
    noti.style.display = "block";
    noti.style.opacity = "1";

    clearTimeout(noti.timer); // Limpia cualquier temporizador anterior

    noti.timer = setTimeout(() => {
        noti.style.opacity = "0";
        // Ocultar después de la transición de opacidad si es necesario
        setTimeout(() => {
            noti.style.display = "none";
        }, 300); // Ajustar al tiempo de la transición CSS
    }, 2000);
}

/**
 * Vacía completamente el carrito y devuelve el stock al catálogo.
 */
function vaciar_carrito() {
    if (confirm("¿Estás seguro de que quieres vaciar la cesta de compra?")) {
        // Para devolver el stock: iteramos sobre los productos añadidos y ajustamos el stock global
        productosAñadidos.forEach(item => {
            const productoOriginal = productos.find(p => p.id === item.id);
            if (productoOriginal) {
                // Solo devuelve el stock si el producto no estaba marcado como inválido (sin stock)
                if (item.valido !== false) {
                    // Sumamos la cantidad que estaba en el carrito
                    productoOriginal.stock += item.contador;
                }
            }
        });

        productosAñadidos = [];
        localStorage.removeItem("productos_carrito"); // Usamos removeItem para una limpieza total

        mostrar_carrito(); // Actualiza la vista del carrito
        organizar_categoria(); // Actualiza los botones de stock en el frontend
    }
}

/**
 * Valida que no haya productos sin stock antes de pasar al proceso de pago.
 */
function validar_productos() {
    let producto_invalido = productosAñadidos.find(p => p.valido === false);

    if (productosAñadidos.length === 0) {
        return alert("El carrito está vacío. Agrega productos para continuar.");
    }

    if (producto_invalido) {
        return alert("Hay productos sin stock disponible en el carrito de compras. Por favor, elimínalos para continuar.");
    } else {
        // Redirección simulada
        window.location.href = "/proceso/compra";
    }
}