<nav class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-300 bg-slate-100 px-6 py-2 dark:border-slate-700 dark:bg-slate-800" aria-label="top navibation bar">

    <!-- sidebar toggle button for small screens  -->
    <button type="button" class="md:hidden inline-block text-slate-700 dark:text-slate-300" x-on:click="sidebarIsOpen = true">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5" aria-hidden="true">
            <path d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z"/>
        </svg>
        <span class="sr-only">sidebar toggle</span>
    </button>
    <!-- Navbars Materi on Desktop  -->
    <div class="justify-end hidden md:flex  flex-row gap-2 w-full">
        @foreach ($navbars as $navbar)
            @if ($navbar->master_materi)
                <a href="{{ route('pembelajaran.master_materi', [$code_pembelajaran, $navbar->master_materi->id]) }}" type="button" class="flex items-center rounded-lg gap-2 p-2 text-left text-slate-700 hover:bg-green-500/5 hover:text-black focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-500 dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white dark:focus-visible:outline-blue-600" x-bind:class="menuDropdownIsOpen{{$navbar->id}} ? 'bg-green-500/10 dark:bg-blue-600/10' : ''" aria-haspopup="true" x-on:click="menuDropdownIsOpen{{$navbar->id}} = ! menuDropdownIsOpen{{$navbar->id}}" x-bind:aria-expanded="menuDropdownIsOpen{{$navbar->id}}">
                    <div class="flex flex-row gap-2 items-center">
                        @if ($navbar->icon)
                        <x-icon class="size-5 text-xs" name="{{$navbar->icon}}" />
                        @else
                        <x-icon class="size-5 text-xs" name="heroicon-c-arrow-path-rounded-square" />
                        @endif   
                        <span class="text-sm font-bold text-black dark:text-white">{{$navbar->nama}}</span>
                    </div>
                </a>  
            @else
             <div x-data="{ menuDropdownIsOpen{{$navbar->id}}: false }" class="relative " x-on:keydown.esc.window="menuDropdownIsOpen = false">
                <button type="button" class="text-sm font-bold text-black dark:text-white flex items-center rounded-lg gap-2 p-2 text-left  hover:bg-green-500/5 hover:text-black focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-500  dark:hover:bg-blue-600/5 dark:hover:text-white dark:focus-visible:outline-blue-600" x-bind:class="menuDropdownIsOpen{{$navbar->id}} ? 'bg-green-500/10 dark:bg-blue-600/10' : ''" aria-haspopup="true" x-on:click="menuDropdownIsOpen{{$navbar->id}} = ! menuDropdownIsOpen{{$navbar->id}}" x-bind:aria-expanded="menuDropdownIsOpen{{$navbar->id}}">
                    <div class="flex flex-row gap-2 items-center">
                        @if ($navbar->icon)
                        <x-icon class="size-5 text-xs" name="{{$navbar->icon}}" />
                        @else
                        <x-icon class="size-5 text-xs" name="heroicon-c-arrow-path-rounded-square" />
                        @endif   
                        <span>{{$navbar->nama}}</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 transition-transform rotate-0 shrink-0" x-bind:class="isExpanded{{$navbar->id}} ? 'rotate-180' : 'rotate-0'" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>  
            <!-- menu -->
                <div x-cloak x-show="menuDropdownIsOpen{{$navbar->id}}" class="absolute top-14 right-0 z-20 h-fit w-48 border divide-y divide-slate-300 border-slate-300 bg-white dark:divide-slate-700 dark:border-slate-700 dark:bg-slate-900 rounded-lg" role="menu" x-on:click.outside="menuDropdownIsOpen{{$navbar->id}} = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition="" x-trap="menuDropdownIsOpen{{$navbar->id}}">
                    @foreach ($navbar->menu_navbars as $menu_navbar)
                        @if ($menu_navbar->master_materi)
                        <div class="flex flex-col py-1.5">
                            <a href="{{ route('pembelajaran.master_materi', [$code_pembelajaran, $menu_navbar->master_materi->id]) }}" class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-green-500/5 hover:text-black focus-visible:underline focus:outline-hidden dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white" role="menuitem">
                                @if ($menu_navbar->icon)
                                <x-icon class="size-5 text-xs" name="{{$menu_navbar->icon}}" />
                                @else
                                <x-icon class="size-5 text-xs" name="heroicon-c-arrow-path-rounded-square" />
                                @endif   
                                <span>{{$menu_navbar->nama}}</span>
                            </a>
                        </div>
                        @else   
                            <div  x-data="{ menuDropdownIsOpen1{{$menu_navbar->id}}: false }" class="relative " x-on:keydown.esc.window="menuDropdownIsOpen1{{$menu_navbar->id}} = false" class="flex flex-col py-1.5">
                                <a x-bind:class="menuDropdownIsOpen1{{$menu_navbar->id}} ? 'bg-green-500/10 dark:bg-blue-600/10' : ''" aria-haspopup="true" x-on:click="menuDropdownIsOpen1{{$menu_navbar->id}} = ! menuDropdownIsOpen1{{$menu_navbar->id}}" x-bind:aria-expanded="menuDropdownIsOpen1{{$menu_navbar->id}}" class="flex w-full items-center justify-between gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-green-500/5 hover:text-black focus-visible:underline focus:outline-hidden dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white" role="menuitem">
                                    <div class="flex flex-row gap-2 items-center">
                                        @if ($menu_navbar->icon)
                                        <x-icon class="size-5 text-xs" name="{{$menu_navbar->icon}}" />
                                        @else
                                        <x-icon class="size-5 text-xs" name="heroicon-c-arrow-path-rounded-square" />
                                        @endif   
                                        <span>{{$menu_navbar->nama}}</span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 transition-transform rotate-0 shrink-0" x-bind:class="isExpanded{{$navbar->id}} ? 'rotate-180' : 'rotate-0'" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                                <div x-cloak x-show="menuDropdownIsOpen1{{$menu_navbar->id}}" x-on:click.outside="menuDropdownIsOpen1{{$menu_navbar->id}} = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition="" x-trap="menuDropdownIsOpen1{{$menu_navbar->id}}">
                                    @foreach ( $menu_navbar->sub_menus as $submenu )
                                        @if ($submenu->master_materi)
                                            <div class="flex flex-col py-1.5">
                                                <a href="{{ route('pembelajaran.master_materi', [$code_pembelajaran, $submenu->master_materi->id]) }}" class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-green-500/5 hover:text-black focus-visible:underline focus:outline-hidden dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white" role="menuitem">
                                                    @if ($submenu->icon)
                                                    <x-icon class="size-5 text-xs" name="{{$submenu->icon}}" />
                                                    @else
                                                    <x-icon class="size-5 text-xs" name="heroicon-c-arrow-path-rounded-square" />
                                                    @endif  
                                                    <span>{{$submenu->nama}}</span>
                                                </a>
                                            </div> 
                                        @else
                                        <div class="flex flex-col py-1.5">
                                            <a  class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-slate-700 underline-offset-2 hover:bg-green-500/5 hover:text-black focus-visible:underline focus:outline-hidden dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white" role="menuitem">
                                                @if ($submenu->icon)
                                                <x-icon class="size-5 text-xs" name="{{$submenu->icon}}" />
                                                @else
                                                <x-icon class="size-5 text-xs" name="heroicon-c-arrow-path-rounded-square" />
                                                @endif   
                                                <span>{{$submenu->nama}} ( Belum ada materi )</span>
                                            </a>
                                        </div>    
                                        @endif
                                      
                                    @endforeach
                                   
                                </div>
                            </div>
                        @endif
                    @endforeach
                   
                </div>
            </div>   
            @endif
        @endforeach
      
    </div>
     <!-- Navbars Materi on Mobile  -->
    <div class="justify-end md:hidden flex-row gap-2 w-full flex ">
        <button type="button" class="md:hidden inline-block text-slate-700 dark:text-slate-300" x-on:click="sidebarMateri = true">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <span class="sr-only">navbar toggle</span>
        </button>
        <div x-cloak class="fixed top-0 right-0 z-50 flex h-svh w-60 shrink-0 gap-2 flex-col border-l border-slate-300 bg-slate-100 p-4 transition-transform duration-300  translate-x-0 md:relative dark:border-slate-700 dark:bg-slate-800" x-bind:class="sidebarMateri ? 'translate-x-0' : 'translate-x-60'" >
            @foreach ($navbars as $navbar )
                @if ($navbar->master_materi)
                    <div class="flex flex-col">
                        <a href="{{ route('pembelajaran.master_materi', [$code_pembelajaran, $navbar->master_materi->id]) }}" type="button"id="user-management-btn" aria-controls="{{$navbar->id}}" x-bind:aria-expanded="isExpanded ? 'true' : 'false'" class="flex items-center justify-between rounded-lg gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus:outline-hidden focus-visible:underline" x-bind:class="isExpanded ? 'text-black bg-blue-700/10 dark:text-white dark:bg-blue-600/10' :  'text-slate-700 hover:bg-blue-700/5 hover:text-black dark:text-slate-300 dark:hover:text-white dark:hover:bg-blue-600/5'">
                            @if ($navbar->icon)
                            <x-icon class="size-5 text-xs" name="{{$navbar->icon}}" />
                            @else
                            <x-icon class="size-5 text-xs" name="heroicon-c-arrow-path-rounded-square" />
                            @endif  
                            <span class="mr-auto text-left">{{$navbar->nama}}</span>
                        </a>
                    </div>
                @else
                <div x-data="{ isExpanded{{$navbar->id}}: false }" class="flex flex-col gap-2">
                    <button type="button" x-on:click="isExpanded{{$navbar->id}} = ! isExpanded{{$navbar->id}}" id="user-management-btn" aria-controls="user-management" x-bind:aria-expanded="isExpanded{{$navbar->id}} ? 'true' : 'false'" class="flex items-center justify-between rounded-lg gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus:outline-hidden focus-visible:underline" x-bind:class="isExpanded{{$navbar->id}} ? 'text-black bg-blue-700/10 dark:text-white dark:bg-blue-600/10' :  'text-slate-700 hover:bg-blue-700/5 hover:text-black dark:text-slate-300 dark:hover:text-white dark:hover:bg-blue-600/5'">
                        @if ($navbar->icon)
                        <x-icon class="size-5 text-xs" name="{{$navbar->icon}}" />
                        @else
                        <x-icon class="size-5 text-xs" name="heroicon-c-arrow-path-rounded-square" />
                        @endif  
                        <span class="mr-auto text-left">{{$navbar->nama}}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 transition-transform rotate-0 shrink-0" x-bind:class="isExpanded{{$navbar->id}} ? 'rotate-180' : 'rotate-0'" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <ul class="ml-2" x-cloak x-collapse x-show="isExpanded{{$navbar->id}}" aria-labelledby="{{$navbar->id}}" id="{{$navbar->id}}">
                        @foreach ($navbar->menu_navbars as $menu_navbar )
                            @if ($menu_navbar->master_materi )
                                <li class="px-1 py-0.5 first:mt-2">
                                    <a href="{{ route('pembelajaran.master_materi', [$code_pembelajaran, $menu_navbar->master_materi->id]) }}" class="flex items-center rounded-lg gap-2 px-2 py-1.5 text-sm text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus:outline-hidden focus-visible:underline dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white">{{$menu_navbar->nama}}</a>
                                </li>
                            @else
                            <div x-data="{ isExpanded1{{$menu_navbar->id}}: false }" class="flex flex-col">
                                <button type="button" x-on:click="isExpanded1{{$menu_navbar->id}} = ! isExpanded1{{$menu_navbar->id}}" id="{{$menu_navbar->id}}" aria-controls="{{$menu_navbar->id}}" x-bind:aria-expanded="isExpanded1{{$menu_navbar->id}} ? 'true' : 'false'" class="flex items-center justify-between rounded-lg gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus:outline-hidden focus-visible:underline" x-bind:class="isExpanded1{{$menu_navbar->id}} ? 'text-black bg-blue-700/10 dark:text-white dark:bg-blue-600/10' :  'text-slate-700 hover:bg-blue-700/5 hover:text-black dark:text-slate-300 dark:hover:text-white dark:hover:bg-blue-600/5'">
                                    @if ($menu_navbar->icon)
                                    <x-icon class="size-5 text-xs" name="{{$menu_navbar->icon}}" />
                                    @else
                                    <x-icon class="size-5 text-xs" name="heroicon-c-arrow-path-rounded-square" />
                                    @endif  
                                    <span class="mr-auto text-left">{{$menu_navbar->nama}}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 transition-transform rotate-0 shrink-0" x-bind:class="isExpanded1{{$menu_navbar->id}} ? 'rotate-180' : 'rotate-0'" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <ul x-cloak x-collapse x-show="isExpanded1{{$menu_navbar->id}}" aria-labelledby="{{$menu_navbar->id}}" id="{{$menu_navbar->id}}">
                                    @foreach ($menu_navbar->sub_menus as $submenu )
                                        @if ($submenu->master_materi)
                                        <li class="px-1 py-0.5 first:mt-2">
                                            <a href="{{ route('pembelajaran.master_materi', [$code_pembelajaran, $submenu->master_materi->id]) }}" class="flex items-center rounded-lg gap-2 px-2 py-1.5 text-sm text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus:outline-hidden focus-visible:underline dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white">{{$submenu->nama}}</a>
                                        </li>
                                        @else
                                        <li class="px-1 py-0.5 first:mt-2">
                                            <a class="flex items-center rounded-lg gap-2 px-2 py-1.5 text-sm text-slate-700 underline-offset-2 hover:bg-blue-700/5 hover:text-black focus:outline-hidden focus-visible:underline dark:text-slate-300 dark:hover:bg-blue-600/5 dark:hover:text-white">{{$submenu->nama}} ( Belum ada materi)</a>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif
            @endforeach
        </div>
    </div>
  
</nav>
