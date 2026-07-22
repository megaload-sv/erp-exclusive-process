(() => {
    'use strict';

    const resetFormState = (form) => {
        delete form.dataset.toSubmitting;
        form.removeAttribute('aria-busy');

        form.querySelectorAll('[data-form-submit="true"]').forEach((button) => {
            if (!(button instanceof HTMLButtonElement)) {
                return;
            }

            const label = button.querySelector('.to-btn__label');
            const originalLabel = button.dataset.originalLabel;

            button.disabled = false;
            button.classList.remove('to-btn--loading');

            if (label && originalLabel) {
                label.textContent = originalLabel;
            }
        });
    };

    document.addEventListener('submit', (event) => {
        const form = event.target;

        if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-protect-submit')) {
            return;
        }

        if (form.dataset.toSubmitting === 'true') {
            event.preventDefault();
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

            if (label && !button.dataset.originalLabel) {
                button.dataset.originalLabel = label.textContent ?? '';
            }

            button.disabled = true;
            button.classList.add('to-btn--loading');

            if (label && loadingLabel) {
                label.textContent = loadingLabel;
            }
        });
    });

    window.addEventListener('pageshow', (event) => {
        if (!event.persisted) {
            return;
        }

        document.querySelectorAll('form[data-protect-submit]').forEach((form) => {
            if (form instanceof HTMLFormElement) {
                resetFormState(form);
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

        const selector = link.getAttribute('href');
        const field = selector ? document.querySelector(selector) : null;

        if (field instanceof HTMLElement) {
            event.preventDefault();
            field.focus();
            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
