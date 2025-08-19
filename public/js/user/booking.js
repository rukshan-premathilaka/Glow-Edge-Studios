function viewBookingDetails(bookingId) {

    const data = new FormData();
    data.append('id', bookingId);
    data.append(csrf.name, csrf.value);

    // Fetch details from server
    fetch('/user/booking_details', {
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
            if (response.status === 'success') {
                document.getElementById("detailsTitle").innerText = response.data.title;
                document.getElementById("detailsStatus").innerText = response.data.status;
                document.getElementById("detailsCreated").innerText = response.data.created_at;
                document.getElementById("detailsUpdated").innerText = response.data.update_at ?? "Not updated yet";
                document.getElementById("detailsClientMsg").innerText = response.data.client_message || "—";
                document.getElementById("detailsAdminMsg").innerText = response.data.admin_msg || "No message";

                // Show card
                document.getElementById("bookingDetailsCard").style.display = "flex";
            }
        })
        .catch(error => {
            console.error('Server Error:', error);
            alert('An error occurred. Please try again.');
        });
}

function closeBookingDetails() {
    document.getElementById("bookingDetailsCard").style.display = "none";
}
