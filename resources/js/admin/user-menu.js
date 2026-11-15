export function initUserMenus() {
    const menus = [...document.querySelectorAll('[data-user-menu]')];

    if (menus.length === 0) {
        return;
    }

    document.addEventListener('click', (event) => {
        menus.forEach((menu) => {
            if (menu.open && !menu.contains(event.target)) {
                menu.open = false;
            }
        });
    });

    menus.forEach((menu) => {
        menu.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape' || !menu.open) {
                return;
            }

            menu.open = false;
            menu.querySelector('summary')?.focus();
        });
    });
}
