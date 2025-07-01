<nav class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-300 bg-slate-100 px-4 py-2 dark:border-slate-700 dark:bg-slate-800" aria-label="top navibation bar">

    <!-- sidebar toggle button for small screens  -->
    <button type="button" class="md:hidden inline-block text-slate-700 dark:text-slate-300" x-on:click="sidebarIsOpen = true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5" aria-hidden="true">
            <path d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z"/>
        </svg>
        <span class="sr-only">sidebar toggle</span>
    </button>

    <!-- breadcrumbs  -->
    <nav class="hidden md:inline-block text-sm font-medium text-slate-700 dark:text-slate-300" aria-label="breadcrumb">
        <ol class="flex flex-wrap items-center gap-1">
        <li class="flex items-center gap-1">
            <a href="{{ route('pembelajaran.dashboard', $code_pembelajaran) }}" class="hover:text-black dark:hover:text-white">Dashboard</a>
        </li>
    </nav>

   
    <!-- Profile Menu  -->
    <div x-data="{ userDropdownIsOpen: false }" class="relative" x-on:keydown.esc.window="userDropdownIsOpen = false">
        <button type="button" class="flex w-full items-center rounded-lg gap-2 p-2 text-left text-slate-700 hover:bg-green-500/5 hover:text-black focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-500 dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white dark:focus-visible:outline-blue-600" x-bind:class="userDropdownIsOpen ? 'bg-green-500/10 dark:bg-blue-600/10' : ''" aria-haspopup="true" x-on:click="userDropdownIsOpen = ! userDropdownIsOpen" x-bind:aria-expanded="userDropdownIsOpen">
            <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-7.webp" class="size-8 object-cover rounded-lg" alt="avatar" aria-hidden="true"/>
            <div class="hidden md:flex flex-col">
                <span class="text-sm font-bold text-black dark:text-white">{{Auth::user()->name}}</span>
                <span class="text-xs" aria-hidden="true">{{Auth::user()->email}}</span>
                <span class="sr-only">profile settings</span>
            </div>
        </button>  
        
        <!-- menu -->
        <div x-cloak x-show="userDropdownIsOpen" class="absolute top-14 right-0 z-20 h-fit w-48 border divide-y divide-slate-300 border-slate-300 bg-white dark:divide-slate-700 dark:border-slate-700 dark:bg-slate-900 rounded-lg" role="menu" x-on:click.outside="userDropdownIsOpen = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition="" x-trap="userDropdownIsOpen">
        
            <div class="flex flex-col py-1.5">
                <a href="#" class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-green-500/5 hover:text-black focus-visible:underline focus:outline-hidden dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white" role="menuitem">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 shrink-0" aria-hidden="true">
                        <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z"/>
                    </svg>
                    <span>Profile</span>
                </a>
            </div>

            <div class="flex flex-col py-1.5">
                <button wire:confirm="Apakah anda ingin logout?" wire:click="logout" class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-green-500/5 hover:text-black focus-visible:underline focus:outline-hidden dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white" role="menuitem">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 shrink-0" aria-hidden="true">
                        <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M6 10a.75.75 0 0 1 .75-.75h9.546l-1.048-.943a.75.75 0 1 1 1.004-1.114l2.5 2.25a.75.75 0 0 1 0 1.114l-2.5 2.25a.75.75 0 1 1-1.004-1.114l1.048-.943H6.75A.75.75 0 0 1 6 10Z" clip-rule="evenodd"/>
                    </svg>
                    <span>Sign Out</span>
                </button>
            </div>
        </div>
    </div>
</nav>
