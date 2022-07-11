export let renderVentas = () => {

    let cobrar = document.querySelectorAll(".cobrar");

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

                })
                .catch ( error =>  {
                    console.log(JSON.stringify(error));
                });
            };

            sendPostRequest();
        }); 
    });
}