

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('appShell', () => ({
    loading: true,

    init() {
        const finishLoading = () => {
            this.loading = false;
        };

        if (document.readyState === 'complete') {
            finishLoading();
        } else {
            window.addEventListener('load', finishLoading, { once: true });
        }

        document.addEventListener('submit', () => {
            this.loading = true;
        });

        document.addEventListener('click', (event) => {
            const target = event.target instanceof Element ? event.target : null;
            const link = target?.closest('a[href]');

            if (!link || link.target === '_blank' || link.hasAttribute('download')) {
                return;
            }

            const href = link.getAttribute('href');

            if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) {
                return;
            }

            this.loading = true;
        });
    },
}));

Alpine.start();
