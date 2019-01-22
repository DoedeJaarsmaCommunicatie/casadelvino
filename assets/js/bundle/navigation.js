document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('.parent-nav-item').forEach( el => {
		el.addEventListener('mouseover', () => {
			try {
				el.querySelector('.drop-down').classList.add('active')
			} catch (e) {}
		});

		el.addEventListener('mouseout', () => {
			try {
				el.querySelector('.drop-down').classList.remove('active')
			} catch (e) {}
		})
	})
});