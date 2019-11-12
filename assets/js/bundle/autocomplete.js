const fetchUrl = () => process.env.NODE_ENV === 'production'
  ? 'https://casadelvino.nl/wp-json/casa/v1/autofill'
  : '/wp-json/casa/v1/autofill';

document.addEventListener('DOMContentLoaded', () => {
  // eslint-disable-next-line no-undef,new-cap,no-new
  new autoComplete({
    data: {
      src: async () => {
        let source;
        try {
          source = await fetch(fetchUrl());
        } catch (e) {
          console.error(e);
        }
        if (!source) {
          return [];
        }

        return source.json();
      },
    },
    placeHolder: 'Zoeken naar...',
    selector: '#autoComplete',
    threshold: 0,
    searchEngine: 'strict',
    resultsList: {
      container: () => 'autocomplete_List',
      destination: document.querySelector('#autoComplete'),
      position: 'afterend',
    },
    resultItem: (data) => `${data.match}`,
    highlight: true,
    maxResults: 5,
    onSelection: (feedback) => {
      document.querySelector('#autoComplete').value = feedback.selection;
      document.querySelector('#searchForm').submit();
    },
  });
});
