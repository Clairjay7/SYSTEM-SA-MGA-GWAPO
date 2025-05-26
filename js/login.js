// Function to show error messages using SweetAlert2
function showError(message) {
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'Try Again',
        background: '#0a1929',
        color: 'white',
        customClass: {
            popup: 'swal-error-popup'
        }
    });
}

// Form validation function
function validateForm() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (!username || !password) {
        showError('Please fill in all fields');
        return false;
    }
    return true;
}

// Clear form on modal close
document.addEventListener('DOMContentLoaded', function() {
    const loginModal = document.getElementById('loginModal');
    if (loginModal) {
        loginModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('loginForm').reset();
        });
    }
});

// Check for PHP session error and display it
function checkSessionError(error) {
    if (error) {
        showError(error);
    }
} 