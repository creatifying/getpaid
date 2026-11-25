const checkout = document.querySelector('.checkout-page');
if (checkout) {
    const desktop = window.matchMedia('(min-width: 768px)');
    const orderDetails = checkout.querySelector('.checkout-order-details');
    const utrDetails = checkout.querySelector('[data-checkout-utr]');
    const hasUtrError = utrDetails?.dataset.hasUtrError === 'true';
    function syncLayout() {
        if (orderDetails) orderDetails.open = desktop.matches;
        if (utrDetails) utrDetails.open = desktop.matches || hasUtrError;
    }
    syncLayout();
    desktop.addEventListener('change', syncLayout);
    checkout.querySelectorAll('form[data-checkout-submit]').forEach((form) => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');
            if (!button) return;
            button.dataset.originalLabel = button.textContent;
            button.disabled = true;
            button.setAttribute('aria-busy', 'true');
            button.textContent = form.dataset.submittingLabel || 'Submitting…';
        });
    });
    // Back/forward cache can restore a form after an external payment app opens.
    window.addEventListener('pageshow', () => {
        checkout.querySelectorAll('button[aria-busy="true"]').forEach((button) => {
            button.disabled = false;
            button.removeAttribute('aria-busy');
            button.textContent = button.dataset.originalLabel || 'Submit';
        });
    });
}
