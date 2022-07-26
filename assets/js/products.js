export let renderProducts = () => {

    // En caso de haber un solo botón se utilizaría querySelector y no habría bucle
    let addProducts = document.querySelectorAll(".add-product");
    let addProductLayout = document.querySelector(".add-product-layout");
    let ticketContainer = document.querySelector(".ticket-container");
    let totals = document.querySelector(".totals");

    // Se crea un bucle porque se trata de diferentes botones
    addProducts.forEach(addProduct => {
        // Pero si fuese un botón único, debemos añadir verificador de que existe el elemento (if())
        addProduct.addEventListener("click", (event) => {
        
            // async siempre va acompañada de un await
            let sendPostRequest = async () => {
                // se abre json
                let data = {};
                // se le da clave y valor
                data["route"] = 'addTicketProduct';
                // se captura el dato del elemento html
                data["price_id"] = addProduct.dataset.price;
                data["table_id"] = addProduct.dataset.table;


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

                    let product = addProductLayout.cloneNode(true);
    
                    product.querySelector('.delete-product').dataset.ticket = json.newProduct.id;
                    product.querySelector('.img-ticket').src =  json.newProduct.imagen_url;
                    product.querySelector('.categoria-prod').innerHTML =  json.newProduct.categoria;
                    product.querySelector('.nombre-prod').innerHTML =  json.newProduct.nombre;
                    product.querySelector('.precio-prod').innerHTML =  json.newProduct.precio_base;
                    product.classList.remove('d-none', 'add-product-layout');
    
                    totals.querySelector('.iva-percent').innerHTML = json.total.iva;
                    totals.querySelector('.base').innerHTML = json.total.base;
                    totals.querySelector('.iva').innerHTML = json.total.total_iva;
                    totals.querySelector('.total').innerHTML = json.total.precio_total;

                    if(ticketContainer.querySelector('.no-products')){
                        ticketContainer.querySelector('.no-products').classList.add('d-none');
                        ticketContainer.appendChild(product);
                    }else{
                        ticketContainer.appendChild(product);
                    }    
                    
                    document.dispatchEvent(new CustomEvent('renderTicket'));
                })
                .catch ( error =>  {
                    console.log(error);
                });
            };
    
            sendPostRequest();
        }); 
    });



};