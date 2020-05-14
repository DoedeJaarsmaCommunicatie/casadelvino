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

    if (!button) {
        return; }

    button.addEventListener('click', () => {
        const target = button.getAttribute('aria-controls'),
            menu = document.querySelector(target),
            icon = button.querySelector('svg');

            setMobileMenuTop(menu);

        if (menu.getAttribute('aria-expanded') === 'false') {
            menu.setAttribute('aria-expanded', 'true');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
            document.body.classList.toggle('overflow-hidden');
        } else {
            menu.setAttribute('aria-expanded', 'false');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
            document.body.classList.toggle('overflow-hidden');
        }
    });
};

function setMobileMenuTop(menu)
{
    const header = document.querySelector('.header'),
        topper = document.querySelector('.header_topper'),
        offset = header.getBoundingClientRect().bottom - document.body.getBoundingClientRect().top;

    if (!isOutOfViewport(header).any) {
        menu.style.top = (offset - 2) + 'px';
    } else {
        menu.style.top = (topper.clientHeight) + 'px';
    }
    menu.classList.toggle('active');
}
const isOutOfViewport = (elem) => {
    const bounding = elem.getBoundingClientRect(), out = {}

    out.top = bounding.top < 0;
    out.left = bounding.left < 0;
    out.bottom = bounding.bottom > (window.innerHeight || document.documentElement.clientHeight);
    out.right = bounding.right > (window.innerWidth || document.documentElement.clientWidth);
    out.any = out.top || out.left || out.bottom || out.right;
    out.all = out.top && out.left && out.bottom && out.right;

    return out;

};

document.addEventListener('DOMContentLoaded', () => {
    dropdown();
    mobileMenu();
});
