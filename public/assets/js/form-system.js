(() => {
    'use strict';

    document.addEventListener('submit', (event) => {
        const form = event.target;

        if (!(form instanceof HTMLFormElement) || form.dataset.toSubmitting === 'true') {
            if (form instanceof HTMLFormElement) {
                event.preventDefault();
            }
            return;
        }

        if (!form.checkValidity()) {
            return;
        }

        form.dataset.toSubmitting = 'true';
        form.setAttribute('aria-busy', 'true');

        form.querySelectorAll('[data-form-submit="true"]').forEach((button) => {
            if (!(button instanceof HTMLButtonElement)) {
                return;
            }

            const label = button.querySelector('.to-btn__label');
            const loadingLabel = button.dataset.loadingLabel;

            button.disabled = true;
            button.classList.add('to-btn--loading');

            if (label && loadingLabel) {
                label.textContent = loadingLabel;
            }
        });
    });

    document.addEventListener('click', (event) => {
        const link = event.target instanceof Element
            ? event.target.closest('.to-validation-summary a[href^="#"]')
            : null;

        if (!(link instanceof HTMLAnchorElement)) {
            return;
        }

        const field = document.querySelector(link.getAttribute('href'));

        if (field instanceof HTMLElement) {
            event.preventDefault();
            field.focus();
            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
