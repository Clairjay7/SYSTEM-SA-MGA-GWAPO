// Function to show error messages using SweetAlert2
function showError(message) {
    Swal.fire({
        title: 'Error',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK',
        background: '#0a1929',
        color: 'white',
        customClass: {
            popup: 'swal-error-popup'
        },
        didClose: () => {
            // Keep the modal open after error message is closed
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        }
    });
}

// Form validation function
function validateForm() {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;

    if (!username || !password) {
        showError('Please enter both username and password');
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