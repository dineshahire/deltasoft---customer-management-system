document.getElementById("registrationForm").onsubmit = async function(event) {
    event.preventDefault(); 

    const userName = document.getElementById("userName").value;
    const userEmail = document.getElementById("userEmail").value;
    const userPassword = document.getElementById("userPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (userPassword !== confirmPassword) {
        alert("Passwords do not match.");
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(userEmail)) {
        alert("Please enter a valid email address.");
        return;
    }

    const passwordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    if (!passwordRegex.test(userPassword)) {
        alert("Password must be at least 8 characters long and include at least one number and one special character.");
        return;
    }

    try {
        const response = await fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: userName, email: userEmail, password: userPassword })
        });

        const result = await response.json();
        if (response.ok) {
            alert(result.message); 
        } else {
            alert(result.error || 'Registration failed. Please try again.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Registration failed. Please try again.');
    }
};
