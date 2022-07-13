export let renderVentas = () => {

    let cobrar = document.querySelectorAll(".cobrar");
    let ticketContainer = document.querySelector(".ticket-container");
    let totals = document.querySelector(".totals");

    cobrar.forEach(cobrar => {
            
        cobrar.addEventListener("click", (event) => {
            
            // async siempre va acompañada de un await
            let sendPostRequest = async () => {
                // se abre json
                let data = {};
                // se le da clave y valor
                data["route"] = 'cobrar';
                // se captura el dato del elemento html
                data["pago_id"] = cobrar.dataset.pago;
                data["table_id"] = cobrar.dataset.table;

                
                let response = await fetch('web.php', {
                    headers: {
                        'Accept': 'application/json',
                    },
                    method: 'POST',
                    body: JSON.stringify(data)
                })
                .then(response => {
                
                    if (!response.ok) throw response;
                    
                    return response.json();
                })
                .then(json => {
                    
                    ticketContainer.querySelector('.no-products').classList.remove('d-none');

                    let products = ticketContainer.querySelectorAll('li:not(.add-product-layout)');
                    
                    totals.querySelector('.iva-percent').innerHTML = '';
                    totals.querySelector('.base').innerHTML = 0;
                    totals.querySelector('.iva').innerHTML = 0;
                    totals.querySelector('.total').innerHTML = 0;

                    products.forEach(product => {
                        product.remove();
                    });
                })
                .catch ( error =>  {
                    console.log(JSON.stringify(error));
                });
            };

            sendPostRequest();
        }); 
    });
}