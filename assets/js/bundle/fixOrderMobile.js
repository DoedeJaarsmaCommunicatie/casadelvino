/* eslint-disable no-undef */
window.onscroll = () => {
  const orderBar = document.querySelector('.mobile__prod__grid-order');

  const sticky = orderBar.offsetTop + 100;

  if (window.pageYOffset > sticky) {
    setTimeout(() => {
      orderBar.classList.add('floating');
    }, 1000);
  } else {
    setTimeout(() => {
      orderBar.classList.remove('floating');
    });
  }
};
