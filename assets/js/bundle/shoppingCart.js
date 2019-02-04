/* eslint-disable no-undef */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.wac-qty-button').forEach((el) => {
    el.addEventListener('click', () => {
      document.querySelector('form.shopping_cart').submit();
    });
  });
});
