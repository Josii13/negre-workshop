// Mobile Menu Toggle
const menuBtn = document.getElementById('menuBtn');
const navLinks = document.getElementById('navLinks');

if (menuBtn) {
    menuBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        navLinks.classList.toggle('active');
    });
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const nav = document.querySelector('nav');
    
    if (navLinks && !nav.contains(event.target) && navLinks.classList.contains('active')) {
        navLinks.classList.remove('active');
    }
});

// Close mobile menu when clicking on a link
if (navLinks) {
    const links = navLinks.querySelectorAll('a');
    links.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.classList.remove('active');
        });
    });
}

// Modal Functions
let currentProduct = '';

function openModal(productName) {
    currentProduct = productName;
    const modal = document.getElementById('modal');
    const messageField = document.getElementById('modal-message');
    
    if (modal && messageField) {
        messageField.value = `Je souhaite commander l'œuvre "${productName}".`;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const modal = document.getElementById('modal');
    
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
        
        // Reset form
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }
}

// Close modal on overlay click
const modal = document.getElementById('modal');
if (modal) {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('modal');
        if (modal && modal.classList.contains('active')) {
            closeModal();
        }
    }
});

// Handle order form submission
function handleOrderSubmit(event) {
    event.preventDefault();
    
    const name = document.getElementById('modal-name').value;
    const email = document.getElementById('modal-email').value;
    const phone = document.getElementById('modal-phone').value;
    
    // Simulate form submission
    alert(`Merci ${name}!\n\nVotre demande de commande pour "${currentProduct}" a été envoyée.\n\nNous vous contacterons très prochainement à l'adresse: ${email}`);
    
    closeModal();
}

// Handle contact form submission
function handleContactSubmit(event) {
    event.preventDefault();
    
    const name = document.getElementById('contact-name').value;
    const email = document.getElementById('contact-email').value;
    
    // Simulate form submission
    alert(`Merci ${name}!\n\nVotre message a été envoyé avec succès.\n\nNous vous répondrons à l'adresse: ${email}`);
    
    // Reset form
    event.target.reset();
}

// Smooth scroll behavior for all internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add active state to current page in navigation
const currentPage = window.location.pathname.split('/').pop() || 'index.html';
const navLinksAll = document.querySelectorAll('.nav-links a');

navLinksAll.forEach(link => {
    const linkPage = link.getAttribute('href');
    if (linkPage === currentPage) {
        link.style.opacity = '1';
        link.style.fontWeight = '500';
    }
});

// Form validation enhancement
const forms = document.querySelectorAll('form');
forms.forEach(form => {
    const inputs = form.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '' && this.hasAttribute('required')) {
                this.style.borderColor = '#E74C3C';
            } else {
                this.style.borderColor = '#E0E0E0';
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.style.borderColor = '#E0E0E0';
            }
        });
    });
});

// Lazy loading for images (performance optimization)
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Scroll to top on page load
window.addEventListener('load', function() {
    window.scrollTo(0, 0);
});

// Add animation on scroll for product cards
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Apply animation to product cards
document.querySelectorAll('.product-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
});

// Site créé pour Frederic N'DA - Artiste Peintre & Designer Ivoirien