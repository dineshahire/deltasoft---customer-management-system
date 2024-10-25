
document.getElementById("registerBtn").onclick = function() {
    const name = document.getElementById("nameField").value; 
    localStorage.setItem("profileName", name);
    alert("Registration done");
};


window.onload = function() {
    const profileName = localStorage.getItem("profileName");
    if (profileName) {
        document.getElementById("profileName").innerText = profileName;
    }
};
