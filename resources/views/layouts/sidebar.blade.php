<!-- Mobile Sidebar Toggle Button -->
<button id="sidebarToggle" class="fixed p-2 bg-white rounded-lg shadow-lg md:hidden top-4 left-4">
    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<nav id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-sm transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0">
    <div class="flex flex-col h-screen">
        <!-- App Logo and Name -->
        <div class="p-4 border-b">
            <div class="flex items-center space-x-3">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span class="text-xl font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('products.index') }}" class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('products.*') ? 'bg-gray-100' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span class="ml-3">Products</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('categories.index') }}" class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('categories.*') ? 'bg-gray-100' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="ml-3">Categories</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('suppliers.index') }}" class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('suppliers.*') ? 'bg-gray-100' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="ml-3">Suppliers</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('stock-receipts.index') }}" class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('stock-receipts.*') ? 'bg-gray-100' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <span class="ml-3">Stock Receipts</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('orders.index') }}" class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('orders.*') ? 'bg-gray-100' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span class="ml-3">Orders</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity duration-300 ease-in-out opacity-0 pointer-events-none md:hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('opacity-0');
            sidebarOverlay.classList.toggle('pointer-events-none');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
    });
</script>