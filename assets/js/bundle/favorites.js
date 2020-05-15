(function ($) {
	$(document).on('favorites-updated-single', function (event, favorites, post_id, site_id, status) {
		const button = document.querySelector('.simplefavorites-total-button ');
		const current = favorites.filter(favorite => favorite.site_id === window['global_site_id'])[0];

		button.dataset.favorites = Object.keys(current.posts).length;
		button.querySelector('.js-update-me').innerHTML = Object.keys(current.posts).length;
	});
})(jQuery);
