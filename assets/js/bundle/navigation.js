document.addEventListener('DOMContentloaded', () => {
	document.querySelectorAll('.parent-nav-item').forEach( el => {
		el.addEventListener('mouseover', () => {
			el.querySelector('.drop-down').classList.add('active')
		});

		el.addEventListener('mouseout', () => {
			el.querySelector('.drop-down').classList.remove('active')
		})
	})
});