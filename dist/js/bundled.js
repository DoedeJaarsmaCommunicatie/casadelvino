// eslint-disable-next-line no-undef
document.addEventListener('DOMContentLoaded', () => {
  // eslint-disable-next-line no-undef,new-cap,no-new
  new autoComplete({
    data: {
      src: async () => {
        const source = await fetch('https://casadelvino.nl/wp-admin/admin-ajax.php?action=get_autofill');
        const data = await source.json();
        console.log(data)
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
    // resultItem: (data, source) => `${data.match}`,
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
document.addEventListener('DOMContentLoaded', () => {
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
});
