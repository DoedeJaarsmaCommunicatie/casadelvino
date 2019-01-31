/* eslint-disable no-undef */
const startListening = () => {
  const button = document.querySelector('[data-action="toggleMobileSearch"]');

  if (!button) { return; }

  const targetEl = button.getAttribute('aria-controls');
  const target = document.querySelector(targetEl);

  button.addEventListener('click', () => {
    target.classList.toggle('d-none');
  });
};

document.addEventListener('DOMContentLoaded', () => {
  startListening();
});
