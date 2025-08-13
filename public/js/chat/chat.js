const chatMessages = document.getElementById('chat-messages');
const userInput = document.getElementById('user-input');
const sendBtn = document.getElementById('send-btn');
const typingIndicator = document.getElementById('typing-indicator');
const serviceButtonsContainer = document.getElementById('service-buttons');
const chatInputArea = document.getElementById('chat-input-area');

// Updated from designers to services
const services = ['Wedding Photography', 'Logo Design', 'Branding Package', 'Portrait Session', 'General Inquiry'];

let conversationState = {};
let currentStep = 'start';

const conversationFlow = {
    'start': {
        message: "Hello! Welcome to Pixel Perfect Studios. To get started, what's your name?",
        nextStep: 'getName'
    },
    'getName': {
        action: (input) => { conversationState.name = input; },
        message: (name) => `Great to meet you, ${name}! What's your email address?`,
        nextStep: 'getEmail'
    },
    'getEmail': {
        action: (input) => { conversationState.email = input; },
        // Updated question
        message: "Thanks! Which of our services are you interested in?",
        nextStep: 'getService'
    },
    'getService': {
        // Updated property from 'designer' to 'service'
        action: (input) => { conversationState.service = input; },
        message: (service) => `Great! You're interested in ${service}. What specific questions do you have?`,
        nextStep: 'getMessage'
    },
    'getMessage': {
        action: (input) => { conversationState.message = input; },
        message: "Thank you for the details! We've received your message and one of our team members will get back to you shortly.",
        nextStep: 'end'
    }
};

function addMessage(text, sender) {
    const bubble = document.createElement('div');
    bubble.className = `chat-bubble-${sender} max-w-xs sm:max-w-md p-3 rounded-lg shadow`;
    bubble.textContent = text;
    chatMessages.appendChild(bubble);
    chatMessages.scrollTop = chatMessages.scrollHeight; // Auto-scroll
}

function showTyping() {
    typingIndicator.classList.remove('hidden');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function hideTyping() {
    typingIndicator.classList.add('hidden');
}

function handleUserInput() {
    const input = userInput.value.trim();
    if (!input) return;

    addMessage(input, 'user');
    userInput.value = '';

    const step = conversationFlow[currentStep];
    if (step.action) {
        step.action(input);
    }

    currentStep = step.nextStep;
    triggerBotResponse();
}

// Renamed from handleDesignerSelection to handleServiceSelection
function handleServiceSelection(serviceName) {
    addMessage(`I'm interested in ${serviceName}.`, 'user');
    serviceButtonsContainer.classList.add('hidden');
    chatInputArea.classList.remove('hidden');

    const step = conversationFlow[currentStep];
    if (step.action) {
        step.action(serviceName);
    }

    currentStep = step.nextStep;
    triggerBotResponse();
}

function triggerBotResponse() {
    const step = conversationFlow[currentStep];
    if (!step) return;

    showTyping();
    userInput.disabled = true;

    setTimeout(() => {
        hideTyping();
        userInput.disabled = false;

        if (currentStep === 'getService') {
            addMessage(step.message, 'bot');
            showServiceButtons();
        } else if (currentStep === 'end') {
            addMessage(step.message, 'bot');
            chatInputArea.classList.add('hidden');
            console.log("Final Data:", conversationState);
            // Here you would send `conversationState` to your PHP backend
        } else {
            let message;
            if (currentStep === 'getMessage') {
                message = step.message(conversationState.service);
            } else if (currentStep === 'getEmail') {
                message = step.message(conversationState.name);
            } else {
                message = step.message;
            }
            addMessage(message, 'bot');
            userInput.focus();
        }

    }, 1200);
}

// Renamed from showDesignerButtons to showServiceButtons
function showServiceButtons() {
    serviceButtonsContainer.innerHTML = '';
    services.forEach(name => {
        const button = document.createElement('button');
        button.className = 'bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors text-sm';
        button.textContent = name;
        button.onclick = () => handleServiceSelection(name);
        serviceButtonsContainer.appendChild(button);
    });
    serviceButtonsContainer.classList.remove('hidden');
    chatInputArea.classList.add('hidden');
}

// Start conversation
window.onload = () => {
    triggerBotResponse();
};

sendBtn.addEventListener('click', handleUserInput);
userInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        handleUserInput();
    }
});