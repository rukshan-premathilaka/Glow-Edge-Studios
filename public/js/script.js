
window.addEventListener('load', () => {
    const introContainer = document.getElementById('intro-video-container');
    const pageContent = document.getElementById('page-content');

    const video = document.getElementById('intro-video');
    video.addEventListener('ended', () => {
        introContainer.style.opacity = '0';
        setTimeout(() => {
            introContainer.style.display = 'none';
            pageContent.classList.remove('hidden');
        }, 1500);
    });
});

/*document.addEventListener('DOMContentLoaded', () => {

    const navLinks = document.querySelectorAll('header nav ul li a');
    const sections = {
        home: document.getElementById('home-section'),
        services: document.getElementById('services-section'),
        about: document.getElementById('about-section'),
        contact: document.getElementById('contact-section'),
    };


    function showSection(sectionKey) {
        Object.keys(sections).forEach(key => {
            if (sections[key]) {
                sections[key].style.display = (key === sectionKey) ? 'block' : 'none';
            }
        });
    }

    navLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();


            navLinks.forEach(l => l.classList.remove('active'));


            link.classList.add('active');


            const key = link.textContent.trim().toLowerCase().replace(/\s/g, '');

            if (sections[key]) {
                showSection(key);
            } else {
                showSection('home');
            }
        });
    });

    showSection('home');
    navLinks.forEach(link => {
        if (link.textContent.trim().toLowerCase().replace(/\s/g, '') === 'home') {
            link.classList.add('active');
        }
    });

});*/
