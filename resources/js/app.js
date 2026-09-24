import './bootstrap';
import { createApp } from 'vue';
import HomePage from './pages/HomePage.vue';
import TentangPage from './pages/TentangPage.vue';
import AlumniPage from './pages/AlumniPage.vue';
import AkademikPage from './pages/AkademikPage.vue';
import ProgramStudiDetailPage from './pages/ProgramStudiDetailPage.vue';
import BeritaDetailPage from './pages/BeritaDetailPage.vue';
import AppNavbar from './components/layout/AppNavbar.vue';
import Alpine from 'alpinejs';

// Preserve Alpine for legacy or breeze components if needed
window.Alpine = Alpine;
Alpine.start();

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

    let rootComponent = null;

    if (pageName === 'home') {
        rootComponent = HomePage;
    } else if (pageName === 'tentang') {
        rootComponent = TentangPage;
    } else if (pageName === 'alumni') {
        rootComponent = AlumniPage;
    } else if (pageName === 'akademik') {
        rootComponent = AkademikPage;
    } else if (pageName === 'akademik-detail') {
        rootComponent = ProgramStudiDetailPage;
    } else if (pageName === 'berita-detail') {
        rootComponent = BeritaDetailPage;
    }

    if (rootComponent) {
        const app = createApp(rootComponent, props);
        app.mount('#app');
    }
}

// 2. Mount standalone AppNavbar if #navbar-app exists (on all internal pages)
const navbarElement = document.getElementById('navbar-app');

if (navbarElement) {
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
}
