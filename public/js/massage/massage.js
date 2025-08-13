export function Massage(response) {
    const body = document.querySelector('body');

    // Create a container for all messages if it doesn't exist
    let container = document.getElementById('messageContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'messageContainer';
        container.style.position = 'fixed';
        container.style.top = '10px';
        container.style.right = '10px';
        container.style.zIndex = '9999';
        container.style.display = 'flex';
        container.style.flexDirection = 'column-reverse'; // newest on top
        container.style.gap = '10px';
        body.appendChild(container);
    }

    // Background color based on status
    const bgColor = response.status === 'success' ? '#4CAF50' : '#F44336';

    // Current time
    const now = new Date();
    const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

    // Create message box
    const msgBox = document.createElement('div');
    msgBox.style.backgroundColor = bgColor;
    msgBox.style.color = 'white';
    msgBox.style.padding = '15px 40px 15px 25px';
    msgBox.style.borderRadius = '10px';
    msgBox.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.3)';
    msgBox.style.fontWeight = 'bold';
    msgBox.style.position = 'relative';
    msgBox.style.minWidth = '250px';

    // Close button
    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '&times;';
    closeBtn.style.position = 'absolute';
    closeBtn.style.top = '5px';
    closeBtn.style.right = '8px';
    closeBtn.style.background = 'transparent';
    closeBtn.style.border = 'none';
    closeBtn.style.color = 'white';
    closeBtn.style.fontSize = '18px';
    closeBtn.style.fontWeight = 'bold';
    closeBtn.style.cursor = 'pointer';
    closeBtn.addEventListener('click', () => msgBox.remove());

    // Message text
    const msgText = document.createElement('p');
    msgText.style.margin = '0';
    msgText.textContent = response.message;

    // Time / Now tag
    const msgTime = document.createElement('small');
    msgTime.style.display = 'block';
    msgTime.style.marginTop = '5px';
    msgTime.style.fontWeight = 'normal';
    msgTime.style.opacity = '0.8';
    msgTime.textContent = 'Now'; // newest message always says Now

    // Update older messages to show timestamp
    container.childNodes.forEach(child => {
        const timeElem = child.querySelector('small');
        if (timeElem) {
            // Only update if it says 'Now'
            if (timeElem.textContent === 'Now') {
                timeElem.textContent = child.dataset.time || timeElem.textContent;
            }
        }
    });

    // Store timestamp in data attribute
    msgBox.dataset.time = timeStr;

    // Append elements
    msgBox.appendChild(closeBtn);
    msgBox.appendChild(msgText);
    msgBox.appendChild(msgTime);

    // Add message to container (flex-direction: column-reverse ensures top is newest)
    container.appendChild(msgBox);

    // Auto remove after 10 seconds
    setTimeout(() => {
        if (container.contains(msgBox)) {
            msgBox.remove();
        }
    }, 10000);
}
