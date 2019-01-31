/* eslint-disable no-undef */
const toggleMode = (target) => {
  target.classList.toggle('d-none');
}

const addListener = () => {
  const button = document.querySelector('[data-action="toggle-search"]');
  const targetEl = button.getAttribute('aria-controls');
  const target = document.querySelector(targetEl);

  button.addEventListener('click', toggleMode(target));
};

document.addEventListener('DOMContentLoaded', () => {
  addListener();
});
