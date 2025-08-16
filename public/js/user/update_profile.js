import { Massage } from "../massage/massage.js";

document.getElementById('profileForm').addEventListener('submit' , function (e) {
    e.preventDefault();

    const data = new FormData(this);

    fetch(this.action, {
        method: this.method,
        body: data,
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(response => {
            Massage(response);
            // Reload the page after a short delay
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        })
        .catch(error => {
            console.error('Server Error:', error);
            alert('Something went wrong. Try again later.');
        });
})
