export let renderProducts = () => {

    let addProducts = document.querySelectorAll(".add-product");

    addProducts.forEach(addProduct => {

        addProduct.addEventListener("click", (event) => {
            
            // async siempre va acompañada de un await

            let sendPostRequest = async () => {
                
                let data = {};
                data["route"] = 'addProduct';
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