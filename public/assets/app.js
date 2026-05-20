const revealableElements = document.querySelectorAll('[data-reveal]');
const allocationBars = document.querySelectorAll('[data-allocation-bar]');
const countedElements = document.querySelectorAll('[data-count]');

const revealObserver = new IntersectionObserver((entries) => {
    for (const entry of entries) {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    }
}, {
    threshold: 0.18,
});

for (const element of revealableElements) {
    revealObserver.observe(element);
}

for (const element of countedElements) {
    const targetValue = Number(element.dataset.count ?? '0');
    const duration = 850;
    const startTime = performance.now();

    const tick = (currentTime) => {
        const progress = Math.min((currentTime - startTime) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        element.textContent = Math.round(targetValue * eased).toString();

        if (progress < 1) {
            requestAnimationFrame(tick);
        }
    };

    requestAnimationFrame(tick);
}

for (const bar of allocationBars) {
    const targetWidth = Number(bar.dataset.allocation ?? '0');
    bar.animate(
        [
            { width: '0%' },
            { width: `${targetWidth}%` },
        ],
        {
            duration: 900,
            easing: 'cubic-bezier(0.22, 1, 0.36, 1)',
            fill: 'forwards',
        },
    );
}
