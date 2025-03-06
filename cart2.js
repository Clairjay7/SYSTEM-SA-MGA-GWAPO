document.addEventListener("DOMContentLoaded", function () {
    const buyButtons = document.querySelectorAll(".buy-button");

    buyButtons.forEach(button => {
        button.addEventListener("click", function () {
            const productCard = button.closest(".product-card");
            const productName = productCard.querySelector("h3").textContent;
            const productPrice = productCard.querySelector(".product-price").textContent;
            const productImage = productCard.querySelector("img").src;

            const cartItem = {
                name: productName,
                price: productPrice,
                image: productImage,
            };

            let cart = localStorage.getItem("cart") ? JSON.parse(localStorage.getItem("cart")) : [];
            cart.push(cartItem);
            localStorage.setItem("cart", JSON.stringify(cart));

            alert("Item added to cart!");
        });
    });
});
