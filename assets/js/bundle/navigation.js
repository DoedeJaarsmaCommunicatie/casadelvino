/* eslint-disable no-undef */
const dropdown = () => {
  document.querySelectorAll('.parent-nav-item').forEach((el) => {
    el.addEventListener('mouseover', () => {
      try {
        el.querySelector('.drop-down').classList.add('active');
      } catch (e) {
        // Should not be empty.
      }
    });

    el.addEventListener('mouseout', () => {
      try {
        el.querySelector('.drop-down').classList.remove('active');
      } catch (e) {
        // Should not be empty.
      }
    });
  });
};

const mobileMenu = () => {
  const button = document.querySelector('[data-action="toggleMobileMenu"]');

  if (!button) { return; }

  button.addEventListener('click', () => {
    const target = button.getAttribute('aria-controls');
    const menu = document.querySelector(target);
    menu.classList.toggle('d-none');
    if (menu.getAttribute('aria-expanded') === 'false') {
      menu.setAttribute('aria-expanded', true);
    } else {
      menu.setAttribute('aria-expanded', false);
    }
  });
};

document.addEventListener('DOMContentLoaded', () => {
  dropdown();
  mobileMenu();
});
