<template>
    <li>
        <!-- Menu item without children -->
        <Link
            v-if="!item.children || item.children.length === 0"
            :href="getMenuItemHref(item)"
            :class="menuItemClasses"
            @click="handleClick"
            :disabled="item.disabled || !item.exists"
        >
            <component
                :is="item.icon"
                :class="iconClasses"
            />
            <span v-if="showLabel" class="menu-label">{{ item.name }}</span>
            <span v-if="item.badge && showLabel" :class="badgeClasses">{{ item.badge }}</span>
            <span v-if="!item.exists && showLabel" class="ml-auto text-xs text-gray-300">(Soon)</span>
        </Link>

        <!-- Menu item with children -->
        <div v-else>
            <button
                :class="menuItemClasses"
                @click="toggleSubmenu"
                :disabled="item.disabled"
            >
                <component
                    :is="item.icon"
                    :class="iconClasses"
                />
                <span v-if="showLabel" class="menu-label">{{ item.name }}</span>
                <span v-if="item.badge && showLabel" :class="badgeClasses">{{ item.badge }}</span>
                <ChevronDown
                    v-if="showLabel"
                    :class="chevronClasses"
                />
            </button>

            <!-- Submenu -->
            <div
                v-if="item.children && item.children.length > 0"
                :class="submenuClasses"
            >
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
    'group flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-md transition-all duration-200',
    props.item.active && props.item.exists
        ? 'bg-gray-900 text-white'
        : props.item.exists
            ? 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
            : 'text-gray-400 cursor-not-allowed',
    props.item.disabled ? 'opacity-50 cursor-not-allowed' : '',
    props.level > 0 ? 'ml-4' : '',
    !showLabel.value ? 'justify-center' : ''
]);

const iconClasses = computed(() => [
    'h-5 w-5 flex-shrink-0',
    props.item.active && props.item.exists
        ? 'text-white'
        : props.item.exists
            ? 'text-gray-400 group-hover:text-gray-600'
            : 'text-gray-300',
    showLabel.value ? 'mr-3' : ''
]);

const badgeClasses = computed(() => [
    'ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium',
    props.item.active && props.item.exists
        ? 'bg-gray-800 text-white'
        : 'bg-gray-200 text-gray-700'
]);

const chevronClasses = computed(() => [
    'ml-auto h-4 w-4 transition-transform duration-200',
    props.item.active && props.item.exists
        ? 'text-white'
        : props.item.exists
            ? 'text-gray-400'
            : 'text-gray-300',
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
