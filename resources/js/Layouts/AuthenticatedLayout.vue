<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useMenuManager } from '@/composables/useMenuManager';
import { useDarkMode } from '@/composables/useDarkMode';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import SidebarMenuItem from '@/Components/SidebarMenuItem.vue';
import { Link } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    Users,
    Settings,
    FileText,
    ShoppingCart,
    BarChart3,
    Menu,
    X,
    ChevronDown,
    LogOut,
    User,
    Package,
    CreditCard,
    ChevronLeft,
    ChevronRight,
    Bell,
    Search,
    Shield,
    Database,
    TrendingUp,
    Archive,
    Truck,
    DollarSign,
    Receipt,
    UserCheck,
    Store,
    Layers,
    Globe,
    Plus,
    HelpCircle,
    Moon,
    Sun,
    Monitor
} from 'lucide-vue-next';

const page = usePage();
const {
    openSubmenus,
    toggleSubmenu,
    isSubmenuOpen,
    closeAllSubmenus,
    setActiveMenuItem
} = useMenuManager();

const { isDarkMode, toggleDarkMode } = useDarkMode();

const sidebarOpen = ref(false);
const sidebarExpanded = ref(true);
const isMobile = ref(false);

// Get app name from environment or use default
const appName = computed(() => {
    return page.props.appName || import.meta.env.VITE_APP_NAME || 'Business Suite';
});

// Check if we're on mobile
const checkMobile = () => {
    isMobile.value = window.innerWidth < 1024;
    if (isMobile.value && sidebarExpanded.value) {
        sidebarExpanded.value = false;
    }
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
    updateActiveMenuItems();
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});

// Watch for route changes to update active menu items
watch(() => page.url, () => {
    updateActiveMenuItems();
});

// Enterprise-grade navigation structure
const navigation = ref([
    {
        id: 'dashboard',
        name: 'Dashboard',
        route: 'dashboard',
        icon: LayoutDashboard,
        exists: true,
        active: false
    },
    {
        id: 'sales',
        name: 'Sales',
        icon: ShoppingCart,
        exists: true,
        active: false,
        children: [
            {
                id: 'sales-pos',
                name: 'POS Terminal',
                route: 'sales.pos',
                icon: Store,
                exists: true,
                active: false
            },
            {
                id: 'sales-orders',
                name: 'Orders',
                route: 'sales.orders',
                icon: Receipt,
                exists: true,
                active: false,
                badge: '12'
            },
            {
                id: 'sales-invoices',
                name: 'Invoices',
                route: 'sales.invoices',
                icon: FileText,
                exists: true,
                active: false
            }
        ]
    },
    {
        id: 'inventory',
        name: 'Inventory',
        icon: Package,
        exists: true,
        active: false,
        children: [
            {
                id: 'products',
                name: 'Products',
                route: 'products.index',
                icon: Package,
                exists: true,
                active: false
            },
            {
                id: 'categories',
                name: 'Categories',
                route: 'categories.index',
                icon: Layers,
                exists: true,
                active: false
            },
            {
                id: 'suppliers',
                name: 'Suppliers',
                route: 'suppliers.index',
                icon: Truck,
                exists: true,
                active: false
            },
            {
                id: 'stock',
                name: 'Stock Management',
                route: 'stock.index',
                icon: Archive,
                exists: true,
                active: false
            }
        ]
    },
    {
        id: 'customers',
        name: 'Customers',
        icon: Users,
        exists: true,
        active: false,
        children: [
            {
                id: 'customers-all',
                name: 'All Customers',
                route: 'customers.index',
                icon: Users,
                exists: true,
                active: false
            },
            {
                id: 'customers-groups',
                name: 'Customer Groups',
                route: 'customers.groups',
                icon: UserCheck,
                exists: true,
                active: false
            }
        ]
    },
    {
        id: 'reports',
        name: 'Analytics',
        icon: BarChart3,
        exists: true,
        active: false,
        children: [
            {
                id: 'reports-sales',
                name: 'Sales Reports',
                route: 'reports.sales',
                icon: TrendingUp,
                exists: true,
                active: false
            },
            {
                id: 'reports-inventory',
                name: 'Inventory Reports',
                route: 'reports.inventory',
                icon: Database,
                exists: true,
                active: false
            },
            {
                id: 'reports-financial',
                name: 'Financial Reports',
                route: 'reports.financial',
                icon: DollarSign,
                exists: true,
                active: false
            }
        ]
    },
    {
        id: 'transactions',
        name: 'Transactions',
        route: 'transactions.index',
        icon: CreditCard,
        exists: true,
        active: false
    },
    {
        id: 'settings',
        name: 'Settings',
        icon: Settings,
        exists: true,
        active: false,
        children: [
            {
                id: 'settings-general',
                name: 'General',
                route: 'settings.general',
                icon: Settings,
                exists: true,
                active: false
            },
            {
                id: 'settings-users',
                name: 'User Management',
                route: 'settings.users',
                icon: Shield,
                exists: true,
                active: false
            },
            {
                id: 'settings-system',
                name: 'System',
                route: 'settings.system',
                icon: Globe,
                exists: true,
                active: false
            }
        ]
    }
]);

const updateActiveMenuItems = () => {
    const currentRoute = page.props.route || { name: '', path: '' };
    setActiveMenuItem(navigation.value, currentRoute);

    // Update isOpen state for submenus
    navigation.value.forEach(item => {
        if (item.children) {
            item.isOpen = isSubmenuOpen(item.id);
        }
    });
};

const handleToggleSubmenu = (menuId) => {
    toggleSubmenu(menuId);

    // Update isOpen state
    navigation.value.forEach(item => {
        if (item.id === menuId) {
            item.isOpen = isSubmenuOpen(menuId);
        }
    });
};

const toggleSidebar = () => {
    if (isMobile.value) {
        sidebarOpen.value = !sidebarOpen.value;
    } else {
        sidebarExpanded.value = !sidebarExpanded.value;
        if (!sidebarExpanded.value) {
            closeAllSubmenus();
            updateActiveMenuItems();
        }
    }
};

const closeSidebar = () => {
    if (isMobile.value) {
        sidebarOpen.value = false;
    }
};

// Filter navigation to show existing or placeholder items
const filteredNavigation = computed(() => {
    return navigation.value.filter(item => item.exists || item.children);
});

// Theme icon computed property
const themeIcon = computed(() => {
    return isDarkMode.value ? Sun : Moon;
});

const themeText = computed(() => {
    return isDarkMode.value ? 'Light Mode' : 'Dark Mode';
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <!-- Mobile sidebar overlay -->
        <div
            v-if="isMobile && sidebarOpen"
            class="fixed inset-0 z-40 bg-black bg-opacity-50 transition-opacity"
            @click="closeSidebar"
        ></div>

        <!-- Sidebar -->
        <div
            class="fixed inset-y-0 left-0 z-50 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out shadow-sm"
            :class="[
                isMobile
                    ? (sidebarOpen ? 'translate-x-0' : '-translate-x-full') + ' w-64'
                    : 'translate-x-0 ' + (sidebarExpanded ? 'w-64' : 'w-16')
            ]"
        >
            <div class="flex flex-col h-full">
                <!-- Logo Header -->
                <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <Link :href="route('dashboard')" class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 dark:bg-blue-500 rounded-lg flex items-center justify-center">
                            <ApplicationLogo class="h-5 w-5 text-white" />
                        </div>
                        <div
                            v-if="sidebarExpanded || isMobile"
                            class="flex flex-col"
                        >
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ appName }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                Enterprise Edition
                            </span>
                        </div>
                    </Link>

                    <!-- Collapse toggle for desktop -->
                    <button
                        v-if="!isMobile"
                        @click="toggleSidebar"
                        class="p-1.5 rounded-lg text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    >
                        <ChevronLeft v-if="sidebarExpanded" class="h-4 w-4" />
                        <ChevronRight v-else class="h-4 w-4" />
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-4 overflow-y-auto">
                    <ul class="space-y-1">
                        <SidebarMenuItem
                            v-for="item in filteredNavigation"
                            :key="item.id"
                            :item="item"
                            :is-collapsed="!sidebarExpanded"
                            :is-mobile="isMobile"
                            @toggle-submenu="handleToggleSubmenu"
                            @close-sidebar="closeSidebar"
                        />
                    </ul>
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                    <div class="flex items-center justify-between">
                        <button
                            v-if="sidebarExpanded || isMobile"
                            @click="toggleDarkMode"
                            class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors w-full"
                        >
                            <component :is="themeIcon" class="h-4 w-4" />
                            <span>{{ themeText }}</span>
                        </button>
                        <button
                            v-else
                            @click="toggleDarkMode"
                            class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors mx-auto"
                            :title="themeText"
                        >
                            <component :is="themeIcon" class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div
            class="transition-all duration-300 ease-in-out"
            :class="[
                isMobile
                    ? 'ml-0'
                    : (sidebarExpanded ? 'ml-64' : 'ml-16')
            ]"
        >
            <!-- Top Navigation Bar -->
            <header class="sticky top-0 z-30 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm transition-colors duration-300">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Left side -->
                    <div class="flex items-center space-x-4">
                        <!-- Mobile menu button -->
                        <button
                            v-if="isMobile"
                            @click="toggleSidebar"
                            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                        >
                            <Menu class="h-5 w-5" />
                        </button>

                        <!-- Page header slot -->
                        <div class="flex-1">
                            <slot name="header" />
                        </div>
                    </div>

                    <!-- Right side - User controls -->
                    <div class="flex items-center space-x-3">
                        <!-- Search -->
                        <button class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <Search class="h-5 w-5" />
                        </button>

                        <!-- Notifications -->
                        <button class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <Bell class="h-5 w-5" />
                            <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Quick Actions -->
                        <button class="hidden sm:inline-flex items-center space-x-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">
                            <Plus class="h-4 w-4" />
                            <span>New Sale</span>
                        </button>

                        <!-- Theme Toggle (Desktop) -->
                        <button
                            @click="toggleDarkMode"
                            class="hidden lg:flex p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            :title="themeText"
                        >
                            <component :is="themeIcon" class="h-5 w-5" />
                        </button>

                        <!-- User Menu -->
                        <div class="relative">
                            <Dropdown align="right" width="56">
                                <template #trigger>
                                    <button class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <img
                                                class="h-8 w-8 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600"
                                                :src="`https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth.user.name)}&background=6366f1&color=fff`"
                                                :alt="$page.props.auth.user.name"
                                            />
                                            <div class="hidden lg:block text-left">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $page.props.auth.user.name }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $page.props.auth.user.email }}
                                                </p>
                                            </div>
                                        </div>
                                        <ChevronDown class="hidden lg:block h-4 w-4 text-gray-400 dark:text-gray-500" />
                                    </button>
                                </template>

                                <template #content>
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $page.props.auth.user.name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $page.props.auth.user.email }}
                                        </p>
                                    </div>

                                    <DropdownLink :href="route('profile.edit')">
                                        <div class="flex items-center">
                                            <User class="mr-3 h-4 w-4 text-gray-400" />
                                            Profile Settings
                                        </div>
                                    </DropdownLink>

                                    <DropdownLink href="#" class="flex items-center">
                                        <HelpCircle class="mr-3 h-4 w-4 text-gray-400" />
                                        Help & Support
                                    </DropdownLink>

                                    <!-- Theme Toggle (Mobile) -->
                                    <button
                                        @click="toggleDarkMode"
                                        class="lg:hidden w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center"
                                    >
                                        <component :is="themeIcon" class="mr-3 h-4 w-4 text-gray-400" />
                                        {{ themeText }}
                                    </button>

                                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        <div class="flex items-center">
                                            <LogOut class="mr-3 h-4 w-4 text-gray-400" />
                                            Sign Out
                                        </div>
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
