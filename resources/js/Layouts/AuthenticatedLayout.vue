<script setup>
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';
import {
    LayoutDashboard, Users, Settings, FileText, ShoppingCart, BarChart3,
    Menu, X, ChevronDown, LogOut, User, Package, CreditCard, Bell, Search,
    Shield, Database, TrendingUp, Archive, Truck, DollarSign, Receipt,
    UserCheck, Store, Layers, Globe, Plus, HelpCircle, Moon, Sun, Home,
    Activity, ChevronRight, Calendar, PieChart, Zap, ChevronLeft
} from 'lucide-vue-next';

const page = usePage();
const { isDarkMode, toggleDarkMode } = useDarkMode();

// Enhanced responsive state management
const sidebarOpen = ref(false);
const sidebarExpanded = ref(true);
const activeSubmenu = ref(null);
const submenuVisible = ref(false);
const windowWidth = ref(0);

// Improved device detection
const isMobile = computed(() => windowWidth.value < 768);
const isTablet = computed(() => windowWidth.value >= 768 && windowWidth.value < 1024);
const isDesktop = computed(() => windowWidth.value >= 1024);

// Touch-friendly breakpoints
const touchDevice = computed(() => isMobile.value || isTablet.value);

// Get app name from environment or use default
const appName = computed(() => {
    return page.props.appName || import.meta.env.VITE_APP_NAME || 'NexaFlow';
});

// Helper function to safely check if route exists
const routeExists = (routeName) => {
    try {
        route(routeName);
        return true;
    } catch (error) {
        return false;
    }
};

// Helper function to safely get route href
const safeRoute = (routeName, fallback = '#') => {
    try {
        return route(routeName);
    } catch (error) {
        console.warn(`Route '${routeName}' not found`);
        return fallback;
    }
};

// Enhanced responsive behavior
const updateResponsiveState = () => {
    windowWidth.value = window.innerWidth;

    // Auto-close sidebar and submenu on mobile
    if (isMobile.value) {
        sidebarExpanded.value = false;
        submenuVisible.value = false;
        activeSubmenu.value = null;
    } else if (isDesktop.value && !sidebarExpanded.value) {
        // Auto-expand on desktop if collapsed
        sidebarExpanded.value = true;
    }
};

onMounted(() => {
    updateResponsiveState();
    window.addEventListener('resize', updateResponsiveState);
});

onUnmounted(() => {
    window.removeEventListener('resize', updateResponsiveState);
});

// Optimized navigation structure
const navigation = ref([
    {
        id: 'dashboard',
        name: 'Dashboard',
        route: 'dashboard',
        icon: Home,
        color: 'blue',
        active: true,
        exists: true
    },
    {
        id: 'sales',
        name: 'Sales',
        icon: ShoppingCart,
        color: 'emerald',
        active: false,
        exists: true,
        children: [
            {
                id: 'pos',
                name: 'POS Terminal',
                route: 'sales.pos',
                icon: Store,
                description: 'Point of sale',
                exists: routeExists('sales.pos')
            },
            {
                id: 'orders',
                name: 'Orders',
                route: 'sales.orders',
                icon: Receipt,
                description: 'Order management',
                badge: '23',
                exists: routeExists('sales.orders')
            },
            {
                id: 'invoices',
                name: 'Invoices',
                route: 'sales.invoices',
                icon: FileText,
                description: 'Invoice management',
                exists: routeExists('sales.invoices')
            }
        ]
    },
    {
        id: 'inventory',
        name: 'Inventory',
        icon: Package,
        color: 'orange',
        active: false,
        exists: true,
        children: [
            {
                id: 'products',
                name: 'Products',
                route: 'products.index',
                icon: Package,
                description: 'Product catalog',
                exists: routeExists('products.index')
            },
            {
                id: 'categories',
                name: 'Categories',
                route: 'categories.index',
                icon: Layers,
                description: 'Product categories',
                exists: routeExists('categories.index')
            },
            {
                id: 'suppliers',
                name: 'Suppliers',
                route: 'suppliers.index',
                icon: Truck,
                description: 'Supplier management',
                exists: routeExists('suppliers.index')
            }
        ]
    },
    {
        id: 'customers',
        name: 'Customers',
        icon: Users,
        color: 'purple',
        active: false,
        exists: true,
        children: [
            {
                id: 'all-customers',
                name: 'All Customers',
                route: 'customers.index',
                icon: Users,
                description: 'Customer database',
                exists: routeExists('customers.index')
            },
            {
                id: 'customer-groups',
                name: 'Groups',
                route: 'customers.groups',
                icon: UserCheck,
                description: 'Customer segments',
                exists: routeExists('customers.groups')
            }
        ]
    },
    {
        id: 'reports',
        name: 'Reports',
        icon: BarChart3,
        color: 'indigo',
        active: false,
        exists: true,
        children: [
            {
                id: 'sales-reports',
                name: 'Sales',
                route: 'reports.sales',
                icon: TrendingUp,
                description: 'Sales analytics',
                exists: routeExists('reports.sales')
            },
            {
                id: 'financial-reports',
                name: 'Financial',
                route: 'reports.financial',
                icon: DollarSign,
                description: 'Financial insights',
                exists: routeExists('reports.financial')
            }
        ]
    },
    {
        id: 'settings',
        name: 'Settings',
        icon: Settings,
        color: 'gray',
        active: false,
        exists: true,
        children: [
            {
                id: 'general-settings',
                name: 'General',
                route: 'settings.general',
                icon: Settings,
                description: 'App preferences',
                exists: routeExists('settings.general')
            },
            {
                id: 'user-management',
                name: 'Users',
                route: 'settings.users',
                icon: Shield,
                description: 'User management',
                exists: routeExists('settings.users')
            }
        ]
    }
]);

// Enhanced touch event handling
const handleMenuClick = (item) => {
    if (item.children && item.children.length > 0) {
        if (activeSubmenu.value === item.id) {
            activeSubmenu.value = null;
            submenuVisible.value = false;
        } else {
            activeSubmenu.value = item.id;
            submenuVisible.value = true;
        }
    } else {
        activeSubmenu.value = null;
        submenuVisible.value = false;
        if (touchDevice.value) {
            sidebarOpen.value = false;
        }
    }
};

const handleSubmenuItemClick = () => {
    if (touchDevice.value) {
        sidebarOpen.value = false;
        submenuVisible.value = false;
        activeSubmenu.value = null;
    }
};

const toggleSidebar = () => {
    if (touchDevice.value) {
        sidebarOpen.value = !sidebarOpen.value;
    } else {
        sidebarExpanded.value = !sidebarExpanded.value;
        if (!sidebarExpanded.value) {
            submenuVisible.value = false;
            activeSubmenu.value = null;
        }
    }
};

// Close sidebar when clicking outside on mobile
const handleOutsideClick = () => {
    if (touchDevice.value && sidebarOpen.value) {
        sidebarOpen.value = false;
        submenuVisible.value = false;
        activeSubmenu.value = null;
    }
};

const activeSubmenuData = computed(() => {
    if (!activeSubmenu.value) return null;
    return navigation.value.find(item => item.id === activeSubmenu.value);
});

const availableChildren = computed(() => {
    if (!activeSubmenuData.value || !activeSubmenuData.value.children) return [];
    return activeSubmenuData.value.children.filter(child => child.exists);
});

// Simplified color system
const getColorClasses = (color, active = false) => {
    const colors = {
        blue: active ? 'bg-blue-50 text-blue-700 border-blue-100' : 'hover:bg-blue-50/50 hover:text-blue-600',
        emerald: active ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'hover:bg-emerald-50/50 hover:text-emerald-600',
        orange: active ? 'bg-orange-50 text-orange-700 border-orange-100' : 'hover:bg-orange-50/50 hover:text-orange-600',
        purple: active ? 'bg-purple-50 text-purple-700 border-purple-100' : 'hover:bg-purple-50/50 hover:text-purple-600',
        indigo: active ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 'hover:bg-indigo-50/50 hover:text-indigo-600',
        gray: active ? 'bg-gray-100 text-gray-700 border-gray-200' : 'hover:bg-gray-50/50 hover:text-gray-600'
    };
    return colors[color] || colors.gray;
};
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Mobile Overlay -->
        <div
            v-if="touchDevice && sidebarOpen"
            class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm"
            @click="handleOutsideClick"
        />

        <!-- Main Sidebar -->
        <div
            class="fixed inset-y-0 left-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-r border-gray-200/60 dark:border-gray-700/60 transition-all duration-300"
            :class="[
                touchDevice
                    ? (sidebarOpen ? 'translate-x-0' : '-translate-x-full') + ' w-72'
                    : 'translate-x-0 ' + (sidebarExpanded ? 'w-72' : 'w-16')
            ]"
        >
            <!-- Logo Header -->
            <div class="h-16 px-4 border-b border-gray-200/60 dark:border-gray-700/60 flex items-center justify-between">
                <Link :href="route('dashboard')" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                        <ApplicationLogo class="h-6 w-6 text-white" />
                    </div>
                    <div v-if="sidebarExpanded || touchDevice" class="flex flex-col">
                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ appName }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Business Suite
                        </span>
                    </div>
                </Link>

                <button
                    v-if="!touchDevice"
                    @click="toggleSidebar"
                    class="p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                >
                    <ChevronLeft v-if="sidebarExpanded" class="h-4 w-4" />
                    <ChevronRight v-else class="h-4 w-4" />
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-3 overflow-y-auto">
                <div class="space-y-1">
                    <div v-for="item in navigation" :key="item.id">
                        <!-- Main Menu Item (No Children) -->
                        <Link
                            v-if="!item.children && item.exists"
                            :href="safeRoute(item.route)"
                            :class="[
                                'flex items-center w-full p-3 rounded-lg transition-all duration-200 border text-sm font-medium',
                                'min-h-[48px]', // Touch-friendly minimum height
                                item.active
                                    ? getColorClasses(item.color, true) + ' shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 border-transparent ' + getColorClasses(item.color)
                            ]"
                            @click="handleMenuClick(item)"
                        >
                            <component
                                :is="item.icon"
                                class="h-5 w-5 flex-shrink-0"
                            />
                            <span v-if="sidebarExpanded || touchDevice" class="ml-3">
                                {{ item.name }}
                            </span>
                        </Link>

                        <!-- Menu Item with Children -->
                        <button
                            v-else-if="item.children && item.exists"
                            :class="[
                                'flex items-center w-full p-3 rounded-lg transition-all duration-200 border text-sm font-medium',
                                'min-h-[48px]', // Touch-friendly minimum height
                                activeSubmenu === item.id
                                    ? getColorClasses(item.color, true) + ' shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 border-transparent ' + getColorClasses(item.color)
                            ]"
                            @click="handleMenuClick(item)"
                        >
                            <component :is="item.icon" class="h-5 w-5 flex-shrink-0" />
                            <div v-if="sidebarExpanded || touchDevice" class="ml-3 flex-1 flex items-center justify-between">
                                <span>{{ item.name }}</span>
                                <ChevronRight
                                    :class="[
                                        'h-4 w-4 transition-transform duration-200',
                                        activeSubmenu === item.id ? 'rotate-90' : 'rotate-0'
                                    ]"
                                />
                            </div>
                        </button>

                        <!-- Submenu Items (Mobile Inline) -->
                        <div
                            v-if="touchDevice && activeSubmenu === item.id && availableChildren.length > 0"
                            class="ml-8 mt-1 space-y-1"
                        >
                            <Link
                                v-for="child in availableChildren"
                                :key="child.id"
                                :href="safeRoute(child.route)"
                                class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-sm min-h-[44px]"
                                @click="handleSubmenuItemClick"
                            >
                                <component :is="child.icon" class="h-4 w-4 text-gray-500 mr-3" />
                                <span class="text-gray-600 dark:text-gray-300">{{ child.name }}</span>
                                <span
                                    v-if="child.badge"
                                    class="ml-auto text-xs px-1.5 py-0.5 bg-red-100 text-red-600 rounded-full"
                                >
                                    {{ child.badge }}
                                </span>
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-3 border-t border-gray-200/60 dark:border-gray-700/60">
                <button
                    @click="toggleDarkMode"
                    :class="[
                        'flex items-center w-full p-3 rounded-lg transition-colors text-sm font-medium min-h-[48px]',
                        'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700',
                        !sidebarExpanded && !touchDevice ? 'justify-center' : ''
                    ]"
                >
                    <component :is="isDarkMode ? Sun : Moon" class="h-5 w-5" />
                    <span v-if="sidebarExpanded || touchDevice" class="ml-3">
                        {{ isDarkMode ? 'Light Mode' : 'Dark Mode' }}
                    </span>
                </button>
            </div>
        </div>

        <!-- Desktop Submenu Panel -->
        <div
            v-if="!touchDevice && submenuVisible && activeSubmenuData && sidebarExpanded && availableChildren.length > 0"
            class="fixed inset-y-0 left-72 z-40 w-64 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-r border-gray-200/60 dark:border-gray-700/60 transition-all duration-300"
        >
            <!-- Submenu Header -->
            <div class="h-16 px-4 border-b border-gray-200/60 dark:border-gray-700/60 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div :class="[
                        'w-8 h-8 rounded-lg flex items-center justify-center',
                        getColorClasses(activeSubmenuData.color, true)
                    ]">
                        <component :is="activeSubmenuData.icon" class="h-4 w-4" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">
                            {{ activeSubmenuData.name }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ availableChildren.length }} items
                        </p>
                    </div>
                </div>
                <button
                    @click="submenuVisible = false; activeSubmenu = null"
                    class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                >
                    <X class="h-4 w-4" />
                </button>
            </div>

            <!-- Submenu Content -->
            <nav class="flex-1 p-3 overflow-y-auto">
                <div class="space-y-1">
                    <Link
                        v-for="child in availableChildren"
                        :key="child.id"
                        :href="safeRoute(child.route)"
                        class="group flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors border border-transparent hover:border-gray-200 dark:hover:border-gray-600 min-h-[48px]"
                        @click="handleSubmenuItemClick"
                    >
                        <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center group-hover:bg-white dark:group-hover:bg-gray-600 transition-colors">
                            <component :is="child.icon" class="h-4 w-4 text-gray-600 dark:text-gray-300" />
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-sm text-gray-900 dark:text-white">
                                    {{ child.name }}
                                </h4>
                                <span
                                    v-if="child.badge"
                                    :class="[
                                        'text-xs px-1.5 py-0.5 rounded-full font-medium',
                                        child.badge === 'Low' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600'
                                    ]"
                                >
                                    {{ child.badge }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ child.description }}
                            </p>
                        </div>
                    </Link>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div
            class="transition-all duration-300"
            :class="[
                touchDevice ? 'ml-0' : (
                    sidebarExpanded
                        ? (submenuVisible && availableChildren.length > 0 ? 'ml-[36rem]' : 'ml-72')
                        : 'ml-16'
                )
            ]"
        >
            <!-- Top Header -->
            <header class="sticky top-0 z-30 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-200/60 dark:border-gray-700/60">
                <div class="flex items-center justify-between h-16 px-4">
                    <!-- Left Side -->
                    <div class="flex items-center gap-4">
                        <button
                            v-if="touchDevice"
                            @click="toggleSidebar"
                            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center"
                        >
                            <Menu class="h-5 w-5" />
                        </button>

                        <div class="flex-1">
                            <slot name="header" />
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-2">
                        <!-- Search -->
                        <button class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center">
                            <Search class="h-5 w-5" />
                        </button>

                        <!-- Notifications -->
                        <button class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center">
                            <Bell class="h-5 w-5" />
                            <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Quick Action -->
                        <button class="hidden sm:flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors min-h-[44px]">
                            <Plus class="h-4 w-4" />
                            <span>New</span>
                        </button>

                        <!-- User Menu -->
                        <Dropdown align="right" width="56">
                            <template #trigger>
                                <button class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors min-h-[44px]">
                                    <img
                                        class="h-8 w-8 rounded-lg object-cover ring-2 ring-gray-200 dark:ring-gray-600"
                                        :src="`https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth.user.name)}&background=3b82f6&color=fff&rounded=true`"
                                        :alt="$page.props.auth.user.name"
                                    />
                                    <div class="hidden lg:block text-left">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                            {{ $page.props.auth.user.name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $page.props.auth.user.email }}
                                        </p>
                                    </div>
                                    <ChevronDown class="hidden lg:block h-4 w-4 text-gray-400" />
                                </button>
                            </template>

                            <template #content>
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                        {{ $page.props.auth.user.name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $page.props.auth.user.email }}
                                    </p>
                                </div>

                                <DropdownLink :href="route('profile.edit')" class="min-h-[44px] flex items-center">
                                    <User class="mr-3 h-4 w-4 text-gray-400" />
                                    Profile Settings
                                </DropdownLink>

                                <DropdownLink href="#" class="min-h-[44px] flex items-center">
                                    <HelpCircle class="mr-3 h-4 w-4 text-gray-400" />
                                    Help & Support
                                </DropdownLink>

                                <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

                                <DropdownLink :href="route('logout')" method="post" as="button" class="min-h-[44px] flex items-center">
                                    <LogOut class="mr-3 h-4 w-4 text-red-500" />
                                    <span class="text-red-600">Sign Out</span>
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
