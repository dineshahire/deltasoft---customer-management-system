function searchService() {
    const input = document.getElementById('search').value.toLowerCase();
    const serviceBoxes = document.querySelectorAll('.service-box');

    serviceBoxes.forEach(box => {
        const service = box.getAttribute('data-service');
        if (service.includes(input)) {
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    });
}
