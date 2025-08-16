import { Massage } from "../massage/massage.js";

document.getElementById("logoutButton").addEventListener("click", function() {
    const data = new FormData();
    data.append(csrf.name, csrf.value);

    fetch('/user/logout', {
        method: 'POST',
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
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        })
        .catch(error => {
            console.error('Server Error:', error);
            alert('Something went wrong. Try again later.');
        });
})

