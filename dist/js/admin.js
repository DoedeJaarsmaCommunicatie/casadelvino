(function ($) {
  $('span.description').each(function(index, el) {
    if ($(el).text() === 'via Afhalen') {
      $(el).css('color', '#ef8716');
      $(el).css('text-transform', 'uppercase');
      $(el).css('font-weight', 'bold');
      $(el).text('Deze wordt afgehaald, Doede');
    }
  });
})(jQuery);
