window.onload = function() {
   
    const dateField = document.getElementById("date");
    const today = new Date().toISOString().split('T')[0]; 
    dateField.value = today;
};


document.getElementById("complaintForm").onsubmit = function(event) {
    event.preventDefault(); 

    const date = document.getElementById("date").value;
    const product = document.getElementById("product").value;
    const title = document.getElementById("title").value;
    const description = document.getElementById("description").value;

    
    alert(`Complaint submitted:
    Date: ${date}
    Product: ${product}
    Title: ${title}
    Description: ${description}`);

   
    document.getElementById("complaintForm").reset();
};
