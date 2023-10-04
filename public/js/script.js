"use strict";
import Order from "./Class/Order.js";
import LocalStorage from "./Class/LocalStorage.js";

let btnAddCart;
let btnValidateCart;
const table = document.querySelector('table');
const displayCart = document.getElementById("displayCart");
const totalPrice = document.getElementById("totalPrice")
let input = document.getElementById("quantite");  
let select = document.getElementById("choice");
let price = document.getElementById("price");
let id = document.getElementById("userId");
let finalPrice;
let newOrder;
let errorSelect = document.getElementById("errorSelect");
let tableHide = document.getElementById('tableHide');



function onClickValider(event)
{

    let idValue = id.value;
    newOrder = new Order();
    newOrder.validateOrder(finalPrice);
    LocalStorage.clearCart();
    event.preventDefault();
}

function resetNbr(){
    input.value="";
}

function OrderSubmit(event)
{
    let priceString = price.textContent;
    let priceValue = parseInt(priceString);
    let idValue = id.value;

    const selectIndex = select.selectedIndex;
    const selectedOption = select.options[selectIndex];
    const selectedText = selectedOption.textContent;


    if(select.value !== "" && input.value > 0 )
    {
        // errorSelect.innerText = "";
        let localstorage = new LocalStorage(selectedText,priceValue,input.value,idValue,select.value);
        localstorage.saveCart();
        showCart();
    }else{
        errorSelect.innerText = "Votre commande n'est pas valide";
    }
    
    resetNbr();
    event.preventDefault();
}

function showCart() {
    tableHide.style.display = "block";
    finalPrice = 0;
    let showDatas = LocalStorage.loadCart();

    while(displayCart.firstChild){
        displayCart.firstChild.remove();
    }

    if (showDatas) {

        if (showDatas.length != 0) {
            table.style.display = "block";
            showDatas.forEach((data, index) => {
                let newRow = document.createElement("tr");
        
                let cartData1 = document.createElement("td");
                cartData1.innerHTML = data.produit;
                newRow.appendChild(cartData1);
        
                let cartData2 = document.createElement("td");
                cartData2.innerHTML = data.prix;
                newRow.appendChild(cartData2);
        
                let cartData3 = document.createElement("td");
                cartData3.innerHTML = data.quantite;
                newRow.appendChild(cartData3);

                let cartData4 = document.createElement("td");
                let sousTotal = (data.prix*data.quantite)
                cartData4.innerHTML = sousTotal;
                newRow.appendChild(cartData4);

                finalPrice += Number(sousTotal);
                totalPrice.innerText = finalPrice;

        
                let deleteButton = document.createElement("td");
                let deleteBtnElement = document.createElement("button");
                deleteBtnElement.classList.add("deleteButton");
                deleteBtnElement.textContent = "Supprimer";

                
                deleteBtnElement.addEventListener("click", () => {
                    LocalStorage.deleteRow(index);
                });
        
                deleteButton.appendChild(deleteBtnElement);
                newRow.appendChild(deleteButton);
        
                displayCart.appendChild(newRow);
            });
        } else {
            table.style.display = "none";
        }
    }

}

function displayProductData() {

    let order = new Order();
    order.getSelectedProduct(select.value);
}


document.addEventListener("DOMContentLoaded",function(){

    showCart();

    if(document.getElementById("ajouter"))
    {
        btnAddCart = document.getElementById("ajouter");
        btnAddCart.addEventListener("click",OrderSubmit);
    }

    if(document.getElementById("valider"))
    {
        btnValidateCart = document.getElementById("valider");
        btnValidateCart.addEventListener("click",onClickValider);
        
    }

    select.addEventListener("change",displayProductData);
})