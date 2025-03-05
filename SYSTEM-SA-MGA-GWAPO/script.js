document.addEventListener("DOMContentLoaded", function () {
    const signUpButton = document.getElementById("signUpButton");
    const signInButton = document.getElementById("signInButton");
    const guestButton = document.getElementById("guestButton");
    const signInForm = document.getElementById("signIn");
    const signUpForm = document.getElementById("signup");

    if (signUpButton) {
        signUpButton.addEventListener("click", function () {
            signInForm.style.display = "none";
            signUpForm.style.display = "block";
        });
    }

    if (signInButton) {
        signInButton.addEventListener("click", function () {
            signInForm.style.display = "block";
            signUpForm.style.display = "none";
        });
    }

    if (guestButton) {
        guestButton.addEventListener("click", function () {
            console.log("Guest button clicked. Redirecting...");
            window.location.href = "homepage.php"; // Redirects guest to dashboard
        });
    }

    console.log("Script loaded. Checking elements...");
    console.log("signUpButton:", signUpButton);
    console.log("signInButton:", signInButton);
    console.log("guestButton:", guestButton);
    console.log("signInForm:", signInForm);
    console.log("signUpForm:", signUpForm);
});

function toggleFaq(index) {
    let answers = document.querySelectorAll('.faq p');
    if (answers[index]) {
        let isVisible = answers[index].style.display === 'block';

        // Hide all answers first
        answers.forEach(answer => answer.style.display = 'none');

        // Toggle the selected one
        answers[index].style.display = isVisible ? 'none' : 'block';
    }
}

function sendHelpRequest(event) {
    event.preventDefault();
    alert('Help request submitted! Our support team will contact you soon.');
}

function goBack() {
    window.location.href = 'homepage.php';
}
