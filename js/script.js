document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ script.js loaded successfully!");

    // ----------------- LOGIN/SIGNUP TOGGLE -----------------
    const signInForm = document.getElementById("signIn");
    const signUpForm = document.getElementById("signUp");

    if (signInForm && signUpForm) {
        signInForm.style.display = "block";
        signUpForm.style.display = "none";

        document.getElementById("signUpButton")?.addEventListener("click", function () {
            signInForm.style.display = "none";
            signUpForm.style.display = "block";
        });

        document.getElementById("signInButton")?.addEventListener("click", function () {
            signUpForm.style.display = "none";
            signInForm.style.display = "block";
        });
    } else {
        console.warn("⚠️ Sign In or Sign Up form not found.");
    }

    document.getElementById("guestButton")?.addEventListener("click", function () {
        window.location.href = "homepage.php";
    });

    // ----------------- BUY BUTTON FUNCTIONALITY -----------------
    document.querySelectorAll(".buy-button").forEach(button => {
        button.addEventListener("click", function () {
            console.log("🛒 Buy button clicked!");

            const productCard = button.closest(".product-card");
            if (!productCard) {
                console.error("❌ Product card not found!");
                return;
            }

            const productName = productCard.querySelector("h3")?.innerText.trim() || "Unknown Product";
            let productPrice = productCard.querySelector(".product-price")?.innerText.trim() || "0";
            productPrice = productPrice.replace(/[^\d.]/g, ''); // Remove non-numeric characters
            const productImage = productCard.querySelector("img")?.src || "";

            if (!productName || !productPrice || !productImage) {
                alert("⚠️ Error: Product details are missing!");
                console.error("❌ Missing product details:", { productName, productPrice, productImage });
                return;
            }

            console.log(`🛍️ Selected: ${productName} - $${productPrice}`);

            // Send order details to the API
            const orderData = {
                customer_name: "Guest", // Replace with actual customer name if available
                product_name: productName,
                quantity: 1, // Set quantity to 1 for this example
                payment_method: "Cash" // Set payment method; can be dynamic based on user input
            };

            fetch('http://localhost/your_project/api/orders.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(orderData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Order created successfully') {
                    alert("🛒 Order placed successfully!");
                    window.location.href = `../php/checkout.php?name=${encodeURIComponent(productName)}&price=${encodeURIComponent(productPrice)}&image=${encodeURIComponent(productImage)}`;
                } else {
                    alert("❌ Error placing order: " + data.message);
                }
            })
            .catch(error => {
                console.error("❌ Error placing order:", error);
                alert("⚠️ There was an error while placing your order.");
            });
        });
    });

    // ----------------- USER SIGNUP -----------------
    const signUpSubmitButton = document.getElementById("signUpSubmit");
    if (signUpSubmitButton) {
        signUpSubmitButton.addEventListener("click", function () {
            const username = document.getElementById("signUpUsername").value.trim();
            const password = document.getElementById("signUpPassword").value.trim();

            if (!username || !password) {
                alert("⚠️ Enter ka muna man.");
                return;
            }

            const userData = {
                username: username,
                password: password,
            };

            fetch('http://localhost/your_project/api/users.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'User created successfully') {
                    alert("🎉 Signup successful! Redirecting to login...");
                    window.location.href = 'login.php'; // Redirect to login page after successful signup
                } else {
                    alert("❌ Error signing up: " + data.message);
                }
            })
            .catch(error => {
                console.error("❌ Error signing up:", error);
                alert("⚠️ There was an error while signing up.");
            });
        });
    }

    // ----------------- USER LOGIN -----------------
    const signInSubmitButton = document.getElementById("signInSubmit");
    if (signInSubmitButton) {
        signInSubmitButton.addEventListener("click", function () {
            const username = document.getElementById("signInUsername").value.trim();
            const password = document.getElementById("signInPassword").value.trim();

            if (!username || !password) {
                alert("⚠️ Please fill in both username and password.");
                return;
            }

            // Send login data to API
            const loginData = {
                username: username,
                password: password,
            };

            fetch('http://localhost/your_project/api/users.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(loginData),
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.username === username) {
                    alert("🎉 Login successful!");
                    window.location.href = 'homepage.php'; // Redirect to homepage or dashboard after login
                } else {
                    alert("❌ Invalid login credentials.");
                }
            })
            .catch(error => {
                console.error("❌ Error logging in:", error);
                alert("⚠️ There was an error while logging in.");
            });
        });
    }
});
