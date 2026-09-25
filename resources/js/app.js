import './bootstrap';
import { createApp } from 'vue';

// 1. Mount full page if #app exists (e.g. on homepage, tentang, alumni, or akademik)
const appElement = document.getElementById('app');

if (appElement) {
    const pageName = appElement.dataset.page;
    let props = {};
    
    try {
        if (appElement.dataset.props) {
            props = JSON.parse(appElement.dataset.props);
        }
    } catch (e) {
        console.error('Gagal memproses data props awal ke Vue:', e);
    }

    const pageLoaders = {
        'home': () => import('./pages/HomePage.vue'),
        'tentang': () => import('./pages/TentangPage.vue'),
        'alumni': () => import('./pages/AlumniPage.vue'),
        'akademik': () => import('./pages/AkademikPage.vue'),
        'akademik-detail': () => import('./pages/ProgramStudiDetailPage.vue'),
        'berita-detail': () => import('./pages/BeritaDetailPage.vue'),
    };

    const loader = pageLoaders[pageName];

    if (loader) {
        loader().then((module) => {
            const app = createApp(module.default, props);
            app.mount('#app');
        });
    }
}

// 2. Mount standalone AppNavbar if #navbar-app exists (on all internal pages)
const navbarElement = document.getElementById('navbar-app');

if (navbarElement) {
    import('./components/layout/AppNavbar.vue').then(({ default: AppNavbar }) => {
        let setting = {};
        try {
            if (navbarElement.dataset.setting) {
                setting = JSON.parse(navbarElement.dataset.setting);
            }
        } catch (e) {
            console.error('Gagal memproses setting navbar:', e);
        }

        const currentPath = navbarElement.dataset.path || window.location.pathname;

        const navApp = createApp(AppNavbar, {
            setting: setting,
            currentPath: currentPath === '' ? '/' : (currentPath.startsWith('/') ? currentPath : '/' + currentPath)
        });
        navApp.mount('#navbar-app');
    });
}

// 3. Mount standalone AppFooter if #footer-app exists (on all internal pages)
const footerElement = document.getElementById('footer-app');

if (footerElement) {
    import('./components/layout/AppFooter.vue').then(({ default: AppFooter }) => {
        let setting = {};
        try {
            if (footerElement.dataset.setting) {
                setting = JSON.parse(footerElement.dataset.setting);
            }
        } catch (e) {
            console.error('Gagal memproses setting footer:', e);
        }

        const footerApp = createApp(AppFooter, {
            setting: setting
        });
        footerApp.mount('#footer-app');
    });
}

// 4. Conditional Alpine.js only if [x-data] elements exist on the page
if (document.querySelector('[x-data]')) {
    import('alpinejs').then(({ default: Alpine }) => {
        window.Alpine = Alpine;
        Alpine.start();
    });
}

