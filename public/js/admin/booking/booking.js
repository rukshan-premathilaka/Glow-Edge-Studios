import { Massage } from "../../massage/massage.js";

document.getElementById('statusFilter').addEventListener('change' , function (e) {
    e.preventDefault();

    const selectedStatus = this.value;
    console.log('Selected status:', selectedStatus);

    const action = '/admin/booking/all';
    const method = 'POST';

    const data = new FormData();
    data.append(csrf.name, csrf.value);
    data.append('status', selectedStatus);
    data.append('offset', '0');
    data.append('limit', '20');

    fetch(action, {
        method: method,
        body: data,
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(response => {
            if (response.status === 'success' && response.data) {
                renderBookings(response.data);
            }
            Massage(response);
        })
        .catch(error => {
            console.error('Server Error:', error);
            alert('An error occurred. Please try again.');
        });
})

function renderBookings(bookings) {
    const tableBody = document.querySelector('tbody');
    tableBody.innerHTML = '';

    const badgeClasses = {
        'pending': 'warn',
        'confirmed': 'ok',
        'cancelled': 'bad',
        'completed': 'info'
    };

    bookings.forEach(booking => {
        const row = document.createElement('tr');
        const normalizedStatus = booking.status.toLowerCase().trim();
        row.dataset.status = normalizedStatus;

        const name = booking.name;
        const service = booking.title;
        const date = new Date(booking.created_at).toLocaleDateString();
        const badgeClass = badgeClasses[normalizedStatus] || 'info';

        // Build the HTML for the row
        row.innerHTML = `
            <td>${name}</td>
            <td>${service}</td>
            <td>${date}</td>
            <td><span class="badge ${badgeClass}">${normalizedStatus}</span></td>
            <td class="toolbar">
                <button class="btn ghost" data-action="details" data-name="booking" data-id="${booking.booking_id}">Details</button>
                ${normalizedStatus === 'pending' ? `<button class="btn" data-action="confirm" data-name="booking" data-id="${booking.booking_id}">Confirm</button>` : ''}
                ${normalizedStatus === 'pending' ? `<button class="btn warn" data-action="cancel" data-name="booking" data-id="${booking.booking_id}">Cancel</button>` : ''}
                ${normalizedStatus === 'cancelled' ? `<button class="btn danger" data-action="delete" data-name="booking" data-id="${booking.booking_id}">Delete</button>` : ''}
            </td>
        `;

        tableBody.appendChild(row);
    });
}

document.querySelector('tbody').addEventListener('click', function(e) {
    const clickedElement = e.target;


    function handleBookingAction(confirm, bookingId) {

        let action;
        const method = 'POST';

        if (confirm === 'confirm') {
            action = '/admin/booking/confirm';
        }
        if (confirm === 'cancel') {
            action = '/admin/booking/cancel';
        }
        if (confirm === 'delete') {
            action = '/admin/booking/delete';
        }
        if (confirm === 'details') {
            action = '/admin/booking/details';
        }

        const data = new FormData();
        data.append('id', bookingId);
        data.append(csrf.name, csrf.value);


        fetch(action, {
            method: method,
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
    }

    // Check if the clicked element is a button with a data-action attribute
    if (clickedElement.matches('button[data-action]')) {
        const action = clickedElement.dataset.action;
        const bookingId = clickedElement.dataset.id;

        console.log(`Action: ${action}, Booking ID: ${bookingId}`);

        // Your logic for each action
        if (action === 'confirm') {
            handleBookingAction('confirm', bookingId);
        } else if (action === 'cancel') {
            handleBookingAction('cancel', bookingId);
        } else if (action === 'delete') {
            handleBookingAction('delete', bookingId);
        } else if (action === 'details') {
            handleBookingAction('delete', bookingId);
        }
    }
});

