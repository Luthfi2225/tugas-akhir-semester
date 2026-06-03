<aside id="sidebar" class="static flex flex-col w-64 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 border-r text-gray-800 dark:text-white min-h-screen px-2 pt-4 transition-all duration-300">
    <div class="flex items-center mb-6 gap-3 px-2">
        <button id="toggleSidebar" class="shrink-0 group flex flex-col items-center justify-center w-8 h-8 border border-gray-600 dark:border-white rounded-md hover:bg-gray-400 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-700 transition-all duration-200 cursor-pointer">
            <span class="w-4 h-0.5 bg-gray-800 dark:bg-white transition-all duration-200 mb-1"></span>
            <span class="w-4 h-0.5 bg-gray-800 dark:bg-white transition-all duration-200 mb-1"></span>
            <span class="w-4 h-0.5 bg-gray-800 dark:bg-white transition-all duration-200"></span>
        </button>
        <div id="sidebarTitle" class="text-2xl font-bold whitespace-nowrap overflow-hidden transition-opacity duration-300">
            Admin Panel
        </div>
    </div>

    <div id="sidebarContainer" class="flex h-210 overflow-y-auto overflow-x-hidden scrollbar-none">
        <nav class="w-59.5">
            <div x-data="{ openMain: Alpine.$persist(true) }" class="mb-2" class="mb-2">

                <div @click="openMain = !openMain" class="flex items-center pl-2.75 h-7 border-y-2 border-slate-400 text-slate-400 cursor-pointer">
                    <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        :class="openMain ? 'rotate-0' : '-rotate-90'"
                        class="svg w-6 h-6 transition-transform duration-300">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                    <p class="sidebarCategory text-1xl uppercase font-semibold pl-2 transition-all duration-300">MAIN</p>
                </div>

                <div x-show="openMain" x-collapse x-cloak>
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center rounded h-10 mt-2 py-2 px-3 transition-color {{ Route::is('dashboard') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M12 2a10 10 0 0 1 7.54 16.59"></path>
                            <path d="M4.46 18.59A10 10 0 0 1 12 2"></path>
                            <path d="m12 12 4-4"></path>
                            <circle cx="12" cy="12" r="1"></circle>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">Dashboard</div>
                    </a>
                </div>
            </div>

            <div x-data="{ openManagement: Alpine.$persist(true) }" class="mb-2">

                <div @click="openManagement = !openManagement" class="flex items-center pl-2.75 h-7 border-y-2 border-slate-400 text-slate-400 cursor-pointer">
                    <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        :class="openManagement ? 'rotate-0' : '-rotate-90'"
                        class="svg w-6 h-6 transition-transform duration-300">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                    <p class="sidebarCategory text-1xl uppercase font-semibold pl-2 transition-all duration-300">MANAGEMENT</p>
                </div>

                <div x-show="openManagement" x-collapse x-cloak>
                    <a href="{{ route('branches.index') }}" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 h-10 mt-2 py-2 px-3 transition-color {{ Route::is('branches.index') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3zM6 21a3 3 0 0 0 3-3v-5a3 3 0 0 0-3-3 3 3 0 0 0-3 3v5a3 3 0 0 0 3 3z"></path>
                            <path d="M21 12H9"></path>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">Branches</div>
                    </a>
                    <a href="{{ route('users.index') }}" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color {{ Route::is('users.index') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">Users</div>
                    </a>
                    <a href="{{ route('categories.index', ['main-category']) }}" wire:navigate class="flex items-center rounded h-10 mt-2 py-2 px-3 transition-color {{ Route::is('categories.index') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">Categories</div>
                    </a>
                </div>
            </div>

            <div x-data="{ openTransactions: Alpine.$persist(true) }" class="mb-2">

                <div @click="openTransactions = !openTransactions" class="flex items-center pl-2.75 h-7 border-y-2 border-slate-400 text-slate-400 cursor-pointer">
                    <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        :class="openTransactions ? 'rotate-0' : '-rotate-90'"
                        class="svg w-6 h-6 transition-transform duration-300">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                    <p class="sidebarCategory text-1xl uppercase font-semibold pl-2 transition-all duration-300">TRANSACTIONS</p>
                </div>

                <div x-show="openTransactions" x-collapse x-cloak>
                    <a href="{{ route('pos.index') }}" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color {{ Route::is('pos.index') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <rect x="2" y="3" width="20" height="12" rx="2" ry="2"></rect>
                            <line x1="12" y1="15" x2="12" y2="21"></line>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="6" y1="8" x2="10" y2="8"></line>
                            <circle cx="17" cy="8" r="1"></circle>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">POS</div>
                    </a>
                    <a href="" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <polyline points="17 1 21 5 17 9"></polyline>
                            <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                            <polyline points="7 23 3 19 7 15"></polyline>
                            <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">Transactions</div>
                    </a>
                    <a href="" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                            <polyline points="3 3 3 8 8 8"></polyline>
                            <line x1="12" y1="7" x2="12" y2="12"></line>
                            <line x1="12" y1="12" x2="16" y2="14"></line>
                        </svg>
                        <div class="sidebarText pl-3 truncate transition-opacity duration-300">Transactions History</div>
                    </a>
                </div>
            </div>

            <div x-data="{ openInventory: Alpine.$persist(true) }" class="mb-2">

                <div @click="openInventory = !openInventory" class="flex items-center pl-2.75 h-7 border-y-2 border-slate-400 text-slate-400 cursor-pointer">
                    <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        :class="openInventory ? 'rotate-0' : '-rotate-90'"
                        class="svg w-6 h-6 transition-transform duration-300">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                    <p class="sidebarCategory text-1xl uppercase font-semibold pl-2 transition-all duration-300">INVENTORY</p>
                </div>

                <div x-show="openInventory" x-collapse x-cloak>
                    <a href="{{ route('products.index') }}" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 h-10 mt-2 py-2 px-3 transition-color {{ Route::is('products.index') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">Products</div>
                    </a>
                    <a href="{{ route('stock-in.index') }}" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 h-10 mt-2 py-2 px-3 transition-color {{ Route::is('stock-in.index') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M22 11V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8"></path>
                            <polyline points="14 16 18 20 22 16"></polyline>
                            <line x1="18" y1="10" x2="18" y2="20"></line>
                        </svg>
                        <div class="sidebarText pl-3 truncate transition-opacity duration-300">Stock In</div>
                    </a>
                    <a href="{{ route('stock-out.index') }}" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color {{ Route::is('stock-out.index') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8"></path>
                            <polyline points="22 14 18 10 14 14"></polyline>
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                        </svg>
                        <div class="sidebarText pl-3 truncate transition-opacity duration-300">Stock Out</div>
                    </a>
                    <a href="{{ route('stock-monitoring.index') }}" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color {{ Route::is('stock-monitoring.index') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5"></path>
                            <circle cx="18" cy="6" r="3"></circle>
                        </svg>
                        <div class="sidebarText pl-3 truncate transition-opacity duration-300">Stock Monitoring</div>
                    </a>
                    <a href="" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <polyline points="16 3 21 8 16 13"></polyline>
                            <line x1="21" y1="8" x2="9" y2="8"></line>
                            <path d="M9 21H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h4"></path>
                        </svg>
                        <div class="sidebarText pl-3 truncate transition-opacity duration-300">Stock Movements</div>
                    </a>
                </div>
            </div>

            <div x-data="{ openReports: Alpine.$persist(true) }" class="mb-2">

                <div @click="openReports = !openReports" class="sidebarBorderTitle flex items-center pl-2.75 h-7 border-y-2 border-slate-400 text-slate-400 cursor-pointer">
                    <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        :class="openReports ? 'rotate-0' : '-rotate-90'"
                        class="svg w-6 h-6 transition-transform duration-300">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                    <p class="sidebarCategory text-1xl text-slate-400 uppercase font-semibold pl-2 transition-all duration-300">REPORTS</p>
                </div>

                <div x-show="openReports" x-collapse x-cloak>
                    <a href="" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <polyline points="8 16 11 13 13 15 16 12"></polyline>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">Sales Reports</div>
                    </a>
                    <a href="" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <rect x="8" y="13" width="8" height="5" rx="1"></rect>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">Stock Reports</div>
                    </a>
                    <a href="" wire:navigate class="flex items-center rounded hover:bg-gray-400 dark:hover:bg-gray-700 mt-2 h-10 py-2 px-3 transition-color">
                        <svg xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg w-6 h-6">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                        <div class="sidebarText pl-3 transition-opacity duration-300">Analytics</div>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <div id="sidebarFooter" class="flex w-59.5 absolute bottom-10 left-2 border-t-2 border-slate-400 p-2 transition-all duration-300">

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="absolute top-2 left-0.75 p-1 w-10 h-10 rounded text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 cursor-pointer">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                </svg>
            </button>
        </form>

        <a href="{{ route('profile.edit') }}" wire:navigate id="profileButton" class="absolute top-2 left-24.5 p-1 w-10 h-10 rounded text-gray-700 dark:text-white dark:hover:text-white transition-all duration-300 {{ Route::is('profile.*') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z">
            </svg>
        </a>

        <a href="" wire:navigate id="settingButton" class="absolute top-2 left-48.25 p-1 w-10 h-10 rounded text-gray-700 dark:text-white dark:hover:text-white transition-all duration-300 {{ Route::is('settings.*') ? 'bg-gray-400 dark:bg-gray-700' : 'hover:bg-gray-400 dark:hover:bg-gray-700' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z">
            </svg>
        </a>

    </div>
</aside>
