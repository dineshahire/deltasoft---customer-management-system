document.getElementById("passwordForm").onsubmit = function(event) {
    event.preventDefault(); 

    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (newPassword === confirmPassword) {
        alert("Password has been updated successfully!");
        
    } else {
        alert("Passwords do not match. Please try again.");
    }
};


document.getElementById("toggleNewPassword").onclick = function() {
    const newPasswordField = document.getElementById("newPassword");
    const type = newPasswordField.getAttribute("type") === "password" ? "text" : "password";
    newPasswordField.setAttribute("type", type);
    this.classList.toggle("fa-eye-slash");
};

document.getElementById("toggleConfirmPassword").onclick = function() {
    const confirmPasswordField = document.getElementById("confirmPassword");
    const type = confirmPasswordField.getAttribute("type") === "password" ? "text" : "password";
    confirmPasswordField.setAttribute("type", type);
    this.classList.toggle("fa-eye-slash");
};
