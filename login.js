document.addEventListener("DOMContentLoaded", function() {
    // Password visibility toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('userPassword');

    togglePassword.addEventListener('click', function() {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            togglePassword.classList.remove('fa-eye');
            togglePassword.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            togglePassword.classList.remove('fa-eye-slash');
            togglePassword.classList.add('fa-eye');
        }
    });

    // Login form submission
    document.getElementById("loginForm").onsubmit = async function(event) {
        event.preventDefault(); // Prevent the default form submission

        const identifier = document.getElementById("userIdentifier").value;
        const password = document.getElementById("userPassword").value;

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const mobilePattern = /^[0-9]{10}$/; 

        if (!emailPattern.test(identifier) && !mobilePattern.test(identifier)) {
            alert("Please enter a valid email address or mobile number.");
            return;
        }

        const passwordPattern = /^(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
        if (!passwordPattern.test(password)) {
            alert("Password must be at least 8 characters long, and include at least one numeric and one special character.");
            return;
        }

        try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ identifier, password })
            });

            const result = await response.json();
            if (response.ok) {
                alert(result.message); 
            } else {
                alert(result.error || 'Login failed. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Login failed. Please try again.');
        }
    };

    document.getElementById("forgotPasswordLink").onclick = async function(event) {
        event.preventDefault(); 

        const identifier = document.getElementById("userIdentifier").value;

        // Validate email or mobile number format
        if (!emailPattern.test(identifier) && !mobilePattern.test(identifier)) {
            alert("Please enter a valid email address or mobile number.");
            return;
        }

        try {
            const response = await fetch('/send-password-reset', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ identifier })
            });

            const result = await response.json();
            if (response.ok) {
                alert(result.message); 
            } else {
                alert(result.error || 'Failed to send password reset link. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to send password reset link. Please try again later.');
        }
    };
});
