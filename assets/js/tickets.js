export let renderTickets= () => {

    // En caso de haber un solo botón se utilizaría querySelector y no habría bucle
    let deleteProducts = document.querySelectorAll(".delete-product");
    // En caso de haber un solo botón se utilizaría querySelector y no habría bucle
    let deleteAll = document.querySelector(".delete-all");

    // Se crea un bucle porque se trata de diferentes botones
    deleteProducts.forEach(deleteProduct => {
        // Pero si fuese un botón único, debemos añadir verificador de que existe el elemento (if())
        deleteProduct.addEventListener("click", (event) => {
            
            // async siempre va acompañada de un await
            let sendPostRequest = async () => {
                // se abre json
                let data = {};
                // se le da clave y valor
                data["route"] = 'deleteProduct';
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
    
                })
                .catch ( error =>  {
                    console.log(JSON.stringify(error));
                });
            };
    
            sendPostRequest();
        }); 
    });


    // Se crea un bucle porque se trata de diferentes botones
    if(deleteAll) {
        // Pero si fuese un botón único, debemos añadir verificador de que existe el elemento -if()
        deleteAll.addEventListener("click", (event) => {
            
            // async siempre va acompañada de un await
            let sendPostRequest = async () => {
                // se abre json
                let data = {};
                // se le da clave y valor
                data["route"] = 'deleteAll';
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
    
                })
                .catch ( error =>  {
                    console.log(JSON.stringify(error));
                });
            };
    
            sendPostRequest();
        }); 
    };
        

};