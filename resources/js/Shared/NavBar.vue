<template>
    <nav class="bg-blue-900 text-white shadow-md fixed top-0 w-full z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side - Branding and Links -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <img src="../../assets/images/msu.png" class="w-8 mr-2" alt="">
                    <a href="#" class="text-2xl font-bold tracking-wide">ePOS ADMIN</a>
                </div>
                <div class="hidden sm:flex sm:space-x-8 sm:ml-6">
                    <!-- Dashboard Link -->
                    <Link href="/dashboard" class="text-blue-300 hover:text-white px-3 py-2 text-sm font-medium">Dashboard</Link>

                    <!-- Items Link -->
                    <Link href="/items" class="text-blue-300 hover:text-white px-3 py-2 text-sm font-medium">Items</Link>

                    <!-- Reports Dropdown -->
                    <div class="relative group py-1.5">
                        <a href="#" class="text-blue-300 hover:text-white px-3 py-2 text-sm font-medium">Reports</a>
                        <div class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded-md mt-1 w-48">
                            <Link href="/sales" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Sales Report</Link>
                            <Link href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Items Report</Link>
                            <Link href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Cashiers Report</Link>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="relative group py-1.5">
                        <a href="#" class="text-blue-300 hover:text-white px-3 py-2 text-sm font-medium">Settings</a>
                        <div class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded-md mt-1 w-48">
                            <Link href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Rates & Currencies</Link>
                            <Link href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">POS Terminals</Link>
                            <Link href="/pos-users" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">POS Users</Link>
                            <Link href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">EFT Currencies</Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - User Menu -->
            <div class="flex items-center">
                <!-- Search Box -->
                <div class="relative">
                    <input type="text" class="rounded-full bg-blue-800 border border-transparent text-white placeholder-blue-300 focus:border-blue-500 focus:ring-blue-500 pl-10 pr-3 py-2 text-sm focus:outline-none" placeholder="Search...">
                    <div class="absolute left-3 top-2 text-blue-300">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M9 13a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                    </div>
                </div>

                <!-- User Dropdown -->
                <ProfileLink :username="username" />
            </div>
        </div>
        </div>
    </nav>
</template>

<script>
import ProfileLink from './Components/ProfileLink.vue';

    export default {
        components: {
            ProfileLink
        },
        props: {
            username: String
        }
    }
</script>
