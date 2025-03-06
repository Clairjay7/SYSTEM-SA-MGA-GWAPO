document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ script.js loaded successfully!");

    // Get elements
    const signUpButton = document.getElementById("signUpButton");
    const signInButton = document.getElementById("signInButton");
    const guestButton = document.getElementById("guestButton");
    const signInForm = document.getElementById("signIn");
    const signUpForm = document.getElementById("signUp");

    console.log("🔍 Checking elements...");
    console.log("signUpButton:", signUpButton);
    console.log("signInButton:", signInButton);
    console.log("guestButton:", guestButton);
    console.log("signInForm:", signInForm);
    console.log("signUpForm:", signUpForm);

    // Ensure both forms exist in the DOM
    if (!signInForm || !signUpForm) {
        console.error("❌ Error: Sign In or Sign Up form not found.");
        return;
    }

    // Initial visibility
    signInForm.style.display = "block";
    signUpForm.style.display = "none";

    // Toggle to Sign Up
    if (signUpButton) {
        signUpButton.addEventListener("click", function () {
            console.log("🔄 Switching to Sign Up");
            signInForm.style.display = "none";
            signUpForm.style.display = "block";
        });
    } else {
        console.warn("⚠️ Sign Up button not found!");
    }

    // Toggle to Sign In
    if (signInButton) {
        signInButton.addEventListener("click", function () {
            console.log("🔄 Switching to Sign In");
            signUpForm.style.display = "none";
            signInForm.style.display = "block";
        });
    } else {
        console.warn("⚠️ Sign In button not found!");
    }

    // Guest Button Redirect
    if (guestButton) {
        guestButton.addEventListener("click", function () {
            console.log("🔀 Guest button clicked. Redirecting...");
            window.location.href = "homepage.php";
        });
    } else {
        console.warn("⚠️ Guest button not found!");
    }
});
