<template>
    <li class="relative">
        <!-- Menu item without children -->
        <Link
            v-if="!item.children || item.children.length === 0"
            :href="getMenuItemHref(item)"
            :class="menuItemClasses"
            @click="handleClick"
            :disabled="item.disabled || !item.exists"
        >
            <div class="flex items-center min-w-0 flex-1">
                <component
                    :is="item.icon"
                    :class="iconClasses"
                />
                <span v-if="showLabel" class="ml-3 font-medium truncate">
                    {{ item.name }}
                </span>
            </div>
            <div v-if="showLabel" class="flex items-center space-x-2">
                <span v-if="item.badge" :class="badgeClasses">{{ item.badge }}</span>
                <span v-if="!item.exists" class="text-xs text-gray-400 dark:text-gray-500">(Soon)</span>
            </div>
        </Link>

        <!-- Menu item with children -->
        <div v-else>
            <button
                :class="menuItemClasses"
                @click="toggleSubmenu"
                :disabled="item.disabled"
            >
                <div class="flex items-center min-w-0 flex-1">
                    <component
                        :is="item.icon"
                        :class="iconClasses"
                    />
                    <span v-if="showLabel" class="ml-3 font-medium truncate">
                        {{ item.name }}
                    </span>
                </div>
                <div v-if="showLabel" class="flex items-center space-x-2">
                    <span v-if="item.badge" :class="badgeClasses">{{ item.badge }}</span>
                    <ChevronDown :class="chevronClasses" />
                </div>
            </button>

            <!-- Submenu with animation -->
            <div
                v-if="item.children && item.children.length > 0"
                :class="submenuClasses"
            >
                <div class="py-1">
                    <ul class="space-y-1">
                        <SidebarMenuItem
                            v-for="child in item.children"
                            :key="child.id"
                            :item="child"
                            :level="level + 1"
                            :is-collapsed="isCollapsed"
                            :is-mobile="isMobile"
                            @toggle-submenu="$emit('toggle-submenu', $event)"
                            @close-sidebar="$emit('close-sidebar')"
                        />
                    </ul>
                </div>
            </div>
        </div>
    </li>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ChevronDown } from 'lucide-vue-next';

const props = defineProps({
    item: {
        type: Object,
        required: true
    },
    level: {
        type: Number,
        default: 0
    },
    isCollapsed: {
        type: Boolean,
        default: false
    },
    isMobile: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['toggle-submenu', 'close-sidebar']);

const showLabel = computed(() => !props.isCollapsed || props.isMobile);

// Helper function to safely get route href
const getMenuItemHref = (item) => {
    if (!item.exists || !item.route) {
        return '#';
    }

    try {
        return route(item.route);
    } catch (error) {
        console.warn(`Route '${item.route}' not found`);
        return '#';
    }
};

const menuItemClasses = computed(() => [
    'group relative flex items-center w-full px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200',
    props.item.active && props.item.exists
        ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-r-2 border-blue-500 dark:border-blue-400'
        : props.item.exists
            ? 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white'
            : 'text-gray-400 dark:text-gray-500 cursor-not-allowed',
    props.item.disabled ? 'opacity-50 cursor-not-allowed' : '',
    props.level > 0 ? 'ml-4 pl-6' : '',
    !showLabel.value ? 'justify-center' : ''
]);

const iconClasses = computed(() => [
    'h-5 w-5 flex-shrink-0',
    props.item.active && props.item.exists
        ? 'text-blue-600 dark:text-blue-400'
        : props.item.exists
            ? 'text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300'
            : 'text-gray-300 dark:text-gray-600'
]);

const badgeClasses = computed(() => [
    'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium',
    props.item.active && props.item.exists
        ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300'
        : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'
]);

const chevronClasses = computed(() => [
    'h-4 w-4 transition-transform duration-200',
    props.item.active && props.item.exists
        ? 'text-blue-600 dark:text-blue-400'
        : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300',
    props.item.isOpen ? 'rotate-180' : ''
]);

const submenuClasses = computed(() => [
    'overflow-hidden transition-all duration-200',
    props.item.isOpen ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'
]);

const handleClick = (event) => {
    if (props.item.disabled || !props.item.exists) {
        event.preventDefault();
        return;
    }

    if (props.isMobile) {
        emit('close-sidebar');
    }
};

const toggleSubmenu = () => {
    if (props.item.disabled) return;

    emit('toggle-submenu', props.item.id);
};
</script>
