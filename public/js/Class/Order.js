import LocalStorage from "./LocalStorage.js";

class Order{

    constructor() {
        this.localstorage = LocalStorage.loadCart();
    }
    
    getSelectedProduct(id) {

        function fetchProduct(id) {
            fetch("index.php?action=orderAJAX", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: "id="+encodeURIComponent(id)
            })
            .then(handleResponseProduct)
            .then(displayData)
            .catch(handleErrorProduct);
        }
    
        function handleResponseProduct(response) {
            // console.log(response.text());
            if(!response.ok) {
                throw new Error("La requete a échoué avec le statut : " + response.status);
            }


            return response.json();
        }

        function displayData(data) {
        
            let price = document.getElementById('price');
            let desc = document.getElementById('desc');
            let img = document.getElementById('img');

                price.innerText = data.productPrice;
                desc.innerText = data.productDesc;   
                img.setAttribute('src',"public/images/upload/"+data.productPicture);        
        }
        
        function handleErrorProduct(error) {
            console.error("Une erreur est survenue lors de la requete : "+error);
        }

        fetchProduct(id);
        
    }


    validateOrder(totalPrice) {
        let prixTotal = totalPrice;

        function fetchOrder(totalPrice,cart) {

            let param = {
                status : "En cours de traitement",
                total : totalPrice,
                cart : JSON.stringify(cart)
            }
            
            const requestOptions = {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded' // Indique que vous envoyez des données JSON
                },
                body: "param="+JSON.stringify(param) // Convertit les données en JSON
              };
    
            fetch("index.php?action=orderInsert", requestOptions)
            .then(handleResponseOrder)
            .catch(handleErrorOrder);
        }
    
        function handleResponseOrder(response) {
                        // console.log(response.text());
            if(!response.ok) {
                throw new Error("La requete a échoué avec le statut : " + response.status);
            } else {
                window.location.href = 'index.php?message=Votre commande de ' + prixTotal + '€ a bien été validée';
            }
        return response.json();
        }
        
        function handleErrorOrder(error) {
            console.error("Une erreur est survenue lors de la requete : "+error);
        }

        if(totalPrice > 0)
        {
            fetchOrder(totalPrice,this.localstorage);
        }
        else
        {
            window.location.href = 'index.php?action=order&message=Votre panier ne peut pas être vide!';
        }
        
        
        
    }
    
}

export default Order;