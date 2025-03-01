document.getElementById('registerForm').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const phone = document.getElementById('phone').value;

    if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        event.preventDefault();
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        event.preventDefault();
    }

    if (!/^\d{10,15}$/.test(phone)) {
        alert('Phone number must be between 10 and 15 digits.');
        event.preventDefault();
    }
});
