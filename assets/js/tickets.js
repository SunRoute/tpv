export let renderTickets= () => {

    // En caso de haber un solo botón se utilizaría querySelector y no habría bucle
    let deleteProducts = document.querySelectorAll(".delete-product");
    let deleteAll = document.querySelector(".delete-all");
    let ticketContainer = document.querySelector(".ticket-container");
    let totals = document.querySelector(".totals");

    document.addEventListener("renderTicket",( event =>{
        renderTickets();
    }), {once: true});

    // Se crea un bucle porque se trata de diferentes botones
    deleteProducts.forEach(deleteProduct => {

        deleteProduct.addEventListener("click", (event) => {

            // async siempre va acompañada de un await
            let sendPostRequest = async () => {
                // se abre json
                let data = {};
                // se le da clave y valor
                data["route"] = 'deleteTicketProduct';
                // se captura el dato del elemento html
                data["ticket_id"] = deleteProduct.dataset.ticket;
                data["table_id"] = deleteProduct.dataset.table;
                
                let response = await fetch('web.php', {
                    headers: {
                        'Accept': 'application/json',
                    },
                    method: 'DELETE',
                    body: JSON.stringify(data)
                })
                .then(response => {
                
                    if (!response.ok) throw response;
                     
                    return response.json();
                })
                .then(json => {

                    deleteProduct.parentElement.remove();

                    if(json.total == false){

                        ticketContainer.querySelector('.no-products').classList.remove('d-none');
                        totals.querySelector('.iva-percent').innerHTML = '';
                        totals.querySelector('.base').innerHTML = 0;
                        totals.querySelector('.iva').innerHTML = 0;
                        totals.querySelector('.total').innerHTML = 0;
                        
                    }else{
                        totals.querySelector('.iva-percent').innerHTML = json.total.iva;
                        totals.querySelector('.base').innerHTML = json.total.base;
                        totals.querySelector('.iva').innerHTML = json.total.total_iva;
                        totals.querySelector('.total').innerHTML = json.total.precio_total;
                    }
                })
                .catch ( error =>  {
                    console.log(error);
                });
            };
    
            sendPostRequest();
        }); 
    });


    // Se crea un bucle porque se trata de diferentes botones
    // Pero si fuese un botón único, debemos añadir verificador de que existe el elemento -if()
    if(deleteAll) {
        
        deleteAll.addEventListener("click", (event) => {
            
            // async siempre va acompañada de un await
            let sendPostRequest = async () => {
                // se abre json
                let data = {};
                // se le da clave y valor
                data["route"] = 'deleteAllTicketProducts';
                // se captura el dato del elemento html
                data["table_id"] = deleteAll.dataset.table;
                
                let response = await fetch('web.php', {
                    headers: {
                        'Accept': 'application/json',
                    },
                    method: 'DELETE',
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
                    console.log(error);
                });
            };
    
            sendPostRequest();
        }); 
    };

    
        

};