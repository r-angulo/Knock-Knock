document.querySelector("#logo").addEventListener("click", function() {
    console.log("sdfdsf");

    let restaurantLink = document.querySelector("#restaurants-link");
    let shoppingCart = document.querySelector("#shopping-cart");
    if (restaurantLink.style.display == "flex") {
        restaurantLink.style.display = "none";
        shoppingCart.style.display = "none";


    } else {
        restaurantLink.style.display = "flex";
        shoppingCart.style.display = "flex";
    }
});