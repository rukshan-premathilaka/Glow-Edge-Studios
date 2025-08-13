import { Massage } from "../massage/massage.js";

document.getElementById('signupForm').addEventListener('submit' , function (e) {
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
        })
        .catch(error => {
            console.error('Server Error:', error);
            alert('An error occurred. Please try again.');
        });
})
