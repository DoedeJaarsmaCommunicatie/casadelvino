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
  try {
    const button = document.querySelector('[data-action="toggleMobileMenu"]');
  } catch (e) {
    // Do nothing
  }

  if (!button) {
    return;
  }

  button.addEventListener('click', () => {
    console.log(this);
  });
};

document.addEventListener('DOMContentLoaded', () => {
  dropdown();
  mobileMenu();
});
