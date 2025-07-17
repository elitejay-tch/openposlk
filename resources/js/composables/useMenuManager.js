// composables/useMenuManager.js
import { ref, computed } from 'vue';

export const useMenuManager = () => {
    const openSubmenus = ref(new Set());

    const toggleSubmenu = (menuId) => {
        if (openSubmenus.value.has(menuId)) {
            openSubmenus.value.delete(menuId);
        } else {
            openSubmenus.value.add(menuId);
        }
    };

    const isSubmenuOpen = (menuId) => {
        return openSubmenus.value.has(menuId);
    };

    const closeAllSubmenus = () => {
        openSubmenus.value.clear();
    };

    const setActiveMenuItem = (items, currentRoute) => {
        items.forEach(item => {
            if (item.children) {
                item.active = item.children.some(child => isMenuItemActive(child, currentRoute));
                if (item.active) {
                    openSubmenus.value.add(item.id);
                }
                setActiveMenuItem(item.children, currentRoute);
            } else {
                item.active = isMenuItemActive(item, currentRoute);
            }
        });
    };

    const isMenuItemActive = (item, currentRoute) => {
        if (item.route) {
            return currentRoute.name === item.route || currentRoute.path.startsWith(item.path || '');
        }
        return false;
    };

    return {
        openSubmenus,
        toggleSubmenu,
        isSubmenuOpen,
        closeAllSubmenus,
        setActiveMenuItem
    };
};
