<template>
    <!-- User Dropdown -->
    <div class="ml-4 relative" v-cloak>
        <!-- User Profile Button -->
        <button
            @click.stop="toggleDropdown"
            class="max-w-xs bg-blue-800 flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-white"
        >
            <span class="sr-only">Open user menu</span>
            <img class="h-10 w-10 rounded-full border-2 border-white shadow-lg"
                src="https://via.placeholder.com/150"
                alt="User Avatar"
            />
        </button>

        <!-- Dropdown Menu -->
        <transition name="fade">
            <div
                v-if="isOpen"
                class="origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu"
            >
                <div class="px-4 py-3 text-center">
                    <p class="text-sm text-gray-700">Signed in as</p>
                    <p class="text-sm font-medium text-gray-900 truncate">{{ username }}</p>
                </div>
                <div class="py-1">
                    <Link href="#"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                    >
                        <i class="fas fa-user-circle mr-3 text-gray-500"></i>
                        Your Profile
                    </Link>
                    <Link href="#"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                    >
                        <i class="fas fa-cog mr-3 text-gray-500"></i>
                        Settings
                    </Link>
                    <Link href="/logout" method="post"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                    >
                        <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>
                        Sign out
                    </Link>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false,
        };
    },
    props: {
        username: String
    },
    mounted() {
        window.addEventListener('click', this.handleOutsideClick);
    },
    beforeUnmount() {
        window.removeEventListener('click', this.handleOutsideClick);
    },
    methods: {
        toggleDropdown() {
            this.isOpen = !this.isOpen;
        },
        handleOutsideClick(event) {
            if (!this.$el.contains(event.target)) {
                this.isOpen = false;
            }
        },
    },
};
</script>

<style scoped>
/* Transition for the dropdown */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
