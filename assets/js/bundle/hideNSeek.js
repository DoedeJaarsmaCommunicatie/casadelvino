document.addEventListener('DOMContentLoaded', () => seek())

const seek = () => {
    const hiders = document.querySelectorAll('[data-hides]');

    for ( let i = 0; i < hiders.length; i++ ) {
        const hider = hiders[i],
            target = document.querySelectorAll(`[data-hiddenby="${hider.dataset.hides}"]`);

        hider.addEventListener('click', () => target.forEach(t => t.classList.toggle('active')));
    }
}
