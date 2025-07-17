// composables/useDarkMode.js
import { ref, watch, onMounted } from 'vue';

export const useDarkMode = () => {
    const isDarkMode = ref(false);

    // Check for saved user preference or default to system preference
    const initializeDarkMode = () => {
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode !== null) {
            isDarkMode.value = savedMode === 'true';
        } else {
            // Check system preference
            isDarkMode.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        applyDarkMode();
    };

    const applyDarkMode = () => {
        if (isDarkMode.value) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };

    const toggleDarkMode = () => {
        isDarkMode.value = !isDarkMode.value;
        localStorage.setItem('darkMode', isDarkMode.value.toString());
        applyDarkMode();
    };

    // Watch for changes and apply them
    watch(isDarkMode, applyDarkMode);

    // Initialize on mount
    onMounted(() => {
        initializeDarkMode();
    });

    return {
        isDarkMode,
        toggleDarkMode
    };
};
