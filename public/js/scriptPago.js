import {recoger_info} from "/js/proceso_compra.js";

export function pasarela () {

    const stripe = Stripe("pk_test_51R31bdBODyJ1QBSiXlqyWVU77OEtisKC9hiFSdpng6RGN4VVY9YrI3ws5aSc412nVfhMjwmzNHpggB67auvItnAq00PrkRlsAq");

    let elements;
    let clientSecret;
    // request al back de pago
    async function payment() {
        try {
            let response = await fetch("/stripe/payment", { method: "POST",  headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    } } );
            let data = await response.json();
           
            if (data.clientSecret) {
                clientSecret = data.clientSecret;
                const appearance = {};
                elements = stripe.elements({ clientSecret, appearance });
                const options = {  layout: {
                type: 'tabs',
                defaultCollapsed: false,
                
  }
}
                const paymentElement = elements.create('payment', options);
                paymentElement.mount('#payment-element');

                document.getElementById("payButton").disabled = false; 
            } else {
                console.log(data.error);
            }
        } catch (error) {
            console.error("Error al inicializar el pago", error.message || error.text);
        }
    }
 // procesar el pago 
    document.getElementById("paymentForm").addEventListener("submit", async (event) => {
        event.preventDefault();
        if (!clientSecret) return;

        document.getElementById("payButton").disabled = true;
        document.getElementById("paymentMessage").textContent = "Procesado pago..."
        

        const { error, paymentIntent } = await stripe.confirmPayment({
            elements,
            confirmParams: { return_url: "http://localhost/stripe/success.php" },
            redirect: "if_required", // omitir recargar otra pagina
        });
        // notificaciones segun el hecho
        if (error) {
            document.getElementById("paymentMessage").textContent = `❌ Error: ${error.message}`;
            document.getElementById("payButton").disabled = false;
        } else if (paymentIntent && paymentIntent.status === "succeeded") {
            document.getElementById("paymentModal").close();
            recoger_info()
            swal.fire({
                title: "Pago",
                text: "pago realizado con exito",
                icon: "success"
            }).then((result) => {
                if(result.isConfirmed) {
                    window.location.href = "/seller";
                }else {
                    window.location.href = "/seller";
                   
                }
            })
        } else {
            document.getElementById("paymentMessage").textContent = "⚠️ Pago no completado.";
        }
    });

   //abrir modal
   function opendModal () {
        document.getElementById("paymentModal").showModal();
        payment();
    }
    opendModal()

    // Cierra el modal
    document.getElementById("closeModal").addEventListener("click", function () {
        document.getElementById("paymentModal").close();
    });
    
}