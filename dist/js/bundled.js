// eslint-disable-next-line no-undef
document.addEventListener('DOMContentLoaded', () => {
  // eslint-disable-next-line no-undef,new-cap,no-new
  new autoComplete({
    data: {
      src: async () => {
        const source = await fetch('https://casadelvino.nl/wp-admin/admin-ajax.php?action=get_autofill');
        const data = await source.json();
        return data.data;
      },
    },
    placeHolder: 'Zoeken naar...',
    selector: '#autoComplete',
    threshold: 0,
    searchEngine: 'strict',
    resultsList: {
      container: (source) => {
        resultsListID = 'autocomplete_List';
        return resultsListID;
      },
      // eslint-disable-next-line no-undef
      destination: document.querySelector('#autoComplete'),
      position: 'afterend',
    },
    resultItem: (data, source) => `${data.match}`,
    highlight: true,
    maxResults: 5,
    onSelection: (feedback) => {
      // eslint-disable-next-line no-undef
      document.querySelector('#autoComplete').value = feedback.selection;
      // eslint-disable-next-line no-undef
      document.querySelector('#searchForm').submit();
    },
  });
});

/* eslint-disable no-undef */
const toggleMode = (target) => {
  target.classList.toggle('d-none');
};

const addListener = () => {
  const button = document.querySelector('[data-action="toggle-mobile-search"]');
  const targetEl = button.getAttribute('aria-controls');
  const target = document.querySelector(targetEl);

  button.addEventListener('click', toggleMode(target));
};

document.addEventListener('DOMContentLoaded', () => {
  addListener();
});

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

const toggleMobileMenu = (button) => {
  const target = button.getAttribute('aria-controls');
  const menu = document.querySelector(target);
  menu.classList.toggle('d-none');
  if (menu.getAttribute('aria-expanded') === 'false') {
    menu.setAttribute('aria-expanded', true);
  } else {
    menu.setAttribute('aria-expanded', false);
  }
};

const mobileMenu = () => {
  const button = document.querySelector('[data-action="toggleMobileMenu"]');

  if (!button) { return; }

  button.addEventListener('click', toggleMobileMenu(button));
};

document.addEventListener('DOMContentLoaded', () => {
  dropdown();
  mobileMenu();
});
