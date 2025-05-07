// Document Ready Function
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize Bootstrap popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Create and manage back-to-top button
    const backToTopButton = document.createElement('button');
    backToTopButton.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTopButton.className = 'btn btn-primary btn-back-to-top animate__animated';
    backToTopButton.style.position = 'fixed';
    backToTopButton.style.bottom = '20px';
    backToTopButton.style.right = '20px';
    backToTopButton.style.display = 'none';
    backToTopButton.style.zIndex = '99';
    backToTopButton.style.borderRadius = '50%';
    backToTopButton.style.width = '50px';
    backToTopButton.style.height = '50px';
    backToTopButton.style.padding = '0';
    document.body.appendChild(backToTopButton);

    // Show/hide back-to-top button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.style.display = 'block';
            backToTopButton.classList.add('animate__fadeIn');
            backToTopButton.classList.remove('animate__fadeOut');
        } else {
            backToTopButton.classList.add('animate__fadeOut');
            backToTopButton.classList.remove('animate__fadeIn');
            setTimeout(() => {
                if (window.pageYOffset <= 300) {
                    backToTopButton.style.display = 'none';
                }
            }, 500);
        }
    });

    // Back-to-top button click handler
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Image modal functionality
    document.querySelectorAll('.post-content img, .img-thumbnail').forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function() {
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0,0,0,0.8)';
            modal.style.display = 'flex';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';
            modal.style.zIndex = '1000';
            modal.style.opacity = '0';
            modal.style.transition = 'opacity 0.3s ease';
            
            const modalImg = document.createElement('img');
            modalImg.src = this.src;
            modalImg.style.maxWidth = '90%';
            modalImg.style.maxHeight = '90%';
            modalImg.style.borderRadius = '8px';
            modalImg.style.transform = 'scale(0.8)';
            modalImg.style.transition = 'transform 0.3s ease';
            
            modal.appendChild(modalImg);
            document.body.appendChild(modal);
            
            setTimeout(() => {
                modal.style.opacity = '1';
                modalImg.style.transform = 'scale(1)';
            }, 10);
            
            modal.addEventListener('click', function() {
                modal.style.opacity = '0';
                modalImg.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    document.body.removeChild(modal);
                }, 300);
            });
        });
    });

    // Dark mode toggle functionality
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', this.checked);
        });
        
        // Check for saved user preference
        if (localStorage.getItem('darkMode') === 'true') {
            darkModeToggle.checked = true;
            document.body.classList.add('dark-mode');
        }
    }

    // Animate elements when they come into view
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;
            
            if (elementPosition < screenPosition) {
                element.classList.add('animate__animated', 'animate__fadeInUp');
            }
        });
    };

    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run once on page load

    // Password strength indicator
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(input => {
        const strengthIndicator = document.createElement('div');
        strengthIndicator.className = 'password-strength mt-2';
        strengthIndicator.innerHTML = `
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
            </div>
            <small class="text-muted">Password strength: <span class="strength-text">Weak</span></small>
        `;
        input.parentNode.insertBefore(strengthIndicator, input.nextSibling);
        
        input.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            const progressBar = strengthIndicator.querySelector('.progress-bar');
            const strengthText = strengthIndicator.querySelector('.strength-text');
            
            progressBar.style.width = strength.percentage + '%';
            progressBar.className = 'progress-bar bg-' + strength.color;
            strengthText.textContent = strength.text;
        });
    });

    // Auto-dismiss flash messages after 5 seconds
    setTimeout(function() {
        const flashMessages = document.querySelectorAll('.alert');
        flashMessages.forEach(message => {
            message.classList.add('animate__animated', 'animate__fadeOut');
            setTimeout(() => {
                message.style.display = 'none';
            }, 500);
        });
    }, 5000);

    // Confirm before deleting
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm(this.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });

    // Toggle comment form visibility
    document.querySelectorAll('.toggle-comment-form').forEach(button => {
        button.addEventListener('click', function() {
            const form = document.getElementById(this.dataset.target);
            form.classList.toggle('d-none');
        });
    });
});

// Calculate password strength
function calculatePasswordStrength(password) {
    let strength = 0;
    
    // Length check
    if (password.length > 0) strength += 1;
    if (password.length >= 8) strength += 1;
    if (password.length >= 12) strength += 1;
    
    // Character variety
    if (/[A-Z]/.test(password)) strength += 1;
    if (/[a-z]/.test(password)) strength += 1;
    if (/[0-9]/.test(password)) strength += 1;
    if (/[^A-Za-z0-9]/.test(password)) strength += 1;
    
    // Calculate percentage and return result
    const percentage = Math.min(100, strength * 12.5);
    
    if (percentage < 40) {
        return { percentage, color: 'danger', text: 'Weak' };
    } else if (percentage < 70) {
        return { percentage, color: 'warning', text: 'Moderate' };
    } else if (percentage < 90) {
        return { percentage, color: 'info', text: 'Strong' };
    } else {
        return { percentage, color: 'success', text: 'Very Strong' };
    }
}

// Initialize dark mode styles (added via JavaScript to avoid FOUC)
if (!document.querySelector('#dark-mode-styles')) {
    const darkModeStyles = document.createElement('style');
    darkModeStyles.id = 'dark-mode-styles';
    darkModeStyles.textContent = `
        .dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }
        
        .dark-mode .card,
        .dark-mode .modal-content,
        .dark-mode .dropdown-menu {
            background-color: #1e1e1e;
            color: #e0e0e0;
            border-color: #333;
        }
        
        .dark-mode .table {
            color: #e0e0e0;
        }
        
        .dark-mode .table th,
        .dark-mode .table td {
            border-color: #333;
        }
        
        .dark-mode .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .dark-mode .form-control,
        .dark-mode .form-select {
            background-color: #2d2d2d;
            border-color: #444;
            color: #e0e0e0;
        }
        
        .dark-mode .form-control:focus,
        .dark-mode .form-select:focus {
            background-color: #2d2d2d;
            border-color: #0d6efd;
            color: #e0e0e0;
        }
        
        .dark-mode .text-muted {
            color: #aaa !important;
        }
        
        .dark-mode .comment {
            background-color: #2d2d2d;
        }
        
        .dark-mode .comment:hover {
            background-color: #333;
        }
        
        .dark-mode .alert-success {
            background-color: #0f5132;
            color: #d1e7dd;
        }
        
        .dark-mode .alert-danger {
            background-color: #842029;
            color: #f8d7da;
        }
        
        .dark-mode .alert-info {
            background-color: #055160;
            color: #cff4fc;
        }
    `;
    document.head.appendChild(darkModeStyles);
}

// AJAX form submission helper
function submitFormAjax(form, callback) {
    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();
    
    xhr.open(form.method, form.action, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            callback(null, JSON.parse(xhr.responseText));
        } else {
            callback(new Error('Request failed with status ' + xhr.status), null);
        }
    };
    
    xhr.onerror = function() {
        callback(new Error('Network error'), null);
    };
    
    xhr.send(formData);
}

// Debounce function for performance optimization
function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

// Throttle function for scroll/resize events
function throttle(func, limit) {
    let lastFunc;
    let lastRan;
    return function() {
        const context = this;
        const args = arguments;
        if (!lastRan) {
            func.apply(context, args);
            lastRan = Date.now();
        } else {
            clearTimeout(lastFunc);
            lastFunc = setTimeout(function() {
                if ((Date.now() - lastRan) >= limit) {
                    func.apply(context, args);
                    lastRan = Date.now();
                }
            }, limit - (Date.now() - lastRan));
        }
    };
}