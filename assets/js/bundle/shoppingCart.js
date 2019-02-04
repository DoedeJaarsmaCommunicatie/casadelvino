/* eslint-disable no-undef */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.wac-qty-button').forEach((el) => {
    el.addEventListener('click', () => {
      document.querySelector('button.update-cart').click();
    });
  });
  document.querySelectorAll('.qty').forEach((el) => {
    el.addEventListener('change', () => {
      document.querySelector('button.update-cart').click();
    });
  });
});
