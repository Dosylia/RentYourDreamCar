class LocalStorage {
    constructor(choice, price, quantity,userId,productCode) {
        this.cart = {
            produit: choice,
            prix: price,
            quantite: quantity,
            id: userId,
            codeProduit: productCode
        };
    }

    static loadCart() {
        const cartDataString = window.localStorage.getItem("cart");
        const existingCartData =  JSON.parse(cartDataString);
        return existingCartData;
    }

    saveCart() {
        const cartDataString = window.localStorage.getItem("cart");
        const existingCartData = JSON.parse(cartDataString) || [];
        existingCartData.push(this.cart);
        window.localStorage.setItem("cart", JSON.stringify(existingCartData));   
    }

    static deleteRow(indexToDelete) {
        let showDatas = LocalStorage.loadCart();
        showDatas.splice(indexToDelete, 1);
        window.localStorage.setItem("cart", JSON.stringify(showDatas));
        window.location.reload();
    }

    static clearCart() {
        localStorage.clear();
    }
}

export default LocalStorage;
