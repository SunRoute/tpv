export let renderProducts = () => {

    // En caso de haber un solo botón se utilizaría querySelector y no habría bucle
    let addProducts = document.querySelectorAll(".add-product");
    // Se crea un bucle porque se trata de diferentes botones
    addProducts.forEach(addProduct => {
        // Pero si fuese un botón único, debemos añadir verificador de que existe el elemento (if())
        addProduct.addEventListener("click", (event) => {
            
            // async siempre va acompañada de un await
            let sendPostRequest = async () => {
                // se abre json
                let data = {};
                // se le da clave y valor
                data["route"] = 'addProduct';
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
    
                })
                .catch ( error =>  {
                    console.log(JSON.stringify(error));
                });
            };
    
            sendPostRequest();
        }); 
    });
        

};