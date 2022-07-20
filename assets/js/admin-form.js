export let renderAdminForm = () => {

    let adminForm = document.querySelector('.admin-form');
    let createFormButton = document.querySelector('.create-form-button');
    let sendFormButton = document.querySelector('.send-form-button');
    let createLayout = document.querySelector('.create-layout');
    let tableContainer = document.querySelector('tbody');
    // Al pulsar el botón de añadir se resetea el formulario para que se borren los datos anteriores.
    if(createFormButton) {
        
        createFormButton.addEventListener("click", (event) => {
            adminForm.reset();
            document.getElementsByName('id')[0].value = '';
        });
    }

    if(sendFormButton) {

        sendFormButton.addEventListener("click", (event) => {

            event.preventDefault();
                
            let sendPostRequest = async () => {
                
                let data = {};
                // Objeto nativo de javascript -FormData- Todos los datos del form son atrapados en este objeto.
                // Los datos se convierten a FormData...
                let formData = new FormData(adminForm);
                formData.append("route", adminForm.dataset.route);

                // ...y hay que convertirlos a json.
                formData.forEach(function(value, key){

                    if(value instanceof File && value.size > 0) {

                        let file = {
                            'lastMod'    : value.lastModified,
                            'lastModDate': value.lastModifiedDate,
                            'name'       : value.name,
                            'size'       : value.size,
                            'type'       : value.type,
                        } 

                        data[key] = file;

                        fetch ('upload.php', {
                            method: 'POST',
                            body: formData
                        });
                    }
                    else {
                        data[key] = value;
                    }
                });

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
                    // Si la id viene vacía, 

                    if(json.id == "") {
                        // Trae el clon del html y se le enchufa el data-element con su id al principio de la tabla (bucle)
                        let newElement = createLayout.cloneNode(true);
                        newElement.classList.remove('d-none', 'create-layout');
                        newElement.dataset.element = json.newElement.id;
                        // Del elemento clonado se busca en el botón eliminar el data-id
                        newElement.querySelector('.delete-table-button').dataset.id = json.newElement.id;
                        newElement.querySelector('.edit-table-button').dataset.id = json.newElement.id;

                        // El último registro añadido en la tabla. Todos los campos son recogidos y dentro del elemento clonado busca los datos y les enchufa el valor
                        Object.entries(json.newElement).forEach(([key, value]) => {
                            if(newElement.querySelector("." + key)){

                                if(newElement.querySelector("." + key).tagName == "IMG") {

                                    newElement.querySelector("." + key).src = value;
                                }else{
                                    newElement.querySelector("." + key).innerHTML = value;
                                }
                            }
                        });
                        // Y finalmente se añade el registro a continuación del último. tableContainer es el contenedor de la tabla (tbody)
                        tableContainer.appendChild(newElement);

                        document.dispatchEvent(new CustomEvent('renderAdminTable'));

                    }else{
                        // y para editar...
                        let element = document.querySelector("[data-element='" + json.id + "']");

                        console.log(json.newElement);


                        Object.entries(json.newElement).forEach(([key, value]) => {

                            if(element.querySelector("." + key)){

                                if(element.querySelector("." + key).tagName == "IMG") {

                                    element.querySelector("." + key).src = value;
                                }else{
                                    element.querySelector("." + key).innerHTML = value;
                                }
                            }
                        });

                        document.dispatchEvent(new CustomEvent('renderAdminTable'));
                    }
                })
                .catch ( error =>  {
                    console.log(error);
                });
            };

            sendPostRequest();
        }); 
    }
    
};