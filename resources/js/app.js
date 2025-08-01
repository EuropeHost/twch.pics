import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    // Handle modal dialogs
    const modalButtons = document.querySelectorAll('[command="show-modal"]');
    modalButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('commandfor');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.showModal();
            }
        });
    });

    const closeButtons = document.querySelectorAll('[command="close"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('commandfor');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.close();
            }
        });
    });

    // Handle mobile dropdowns
    const toggleButtons = document.querySelectorAll('[command="--toggle"]');
    toggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            const disclosureId = button.getAttribute('commandfor');
            const disclosure = document.getElementById(disclosureId);
            if (disclosure) {
                disclosure.hidden = !disclosure.hidden;
                button.setAttribute('aria-expanded', !disclosure.hidden);
            }
        });
    });
});