import { initDetailModals } from './admin/detail-modal';
import { initTourWizard } from './admin/tour-wizard';
import { initUserMenus } from './admin/user-menu';

document.addEventListener('DOMContentLoaded', () => {
    initDetailModals();
    initTourWizard();
    initUserMenus();

    if (document.getElementById('tours-by-year-chart')) {
        import('./admin/dashboard').then(({ initDashboardCharts }) => initDashboardCharts());
    }
});
