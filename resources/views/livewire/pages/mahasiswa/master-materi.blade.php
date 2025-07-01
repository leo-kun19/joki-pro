<div x-data="{ sidebarIsOpen: false , sidebarMateri: false}" class="fixed flex w-full flex-col md:flex-row">
    <!-- This allows screen readers to skip the sidebar and go directly to the main content. -->
    <a class="sr-only" href="#main-content">skip to the main content</a>
    
    <!-- dark overlay for when the sidebar is open on smaller screens  -->
    <div x-cloak x-show="sidebarIsOpen" class="fixed inset-0 z-20 bg-slate-900/10 backdrop-blur-xs md:hidden" aria-hidden="true" x-on:click="sidebarIsOpen = false" x-transition.opacity ></div>
    <div x-cloak x-show="sidebarMateri" class="fixed inset-0 z-10 bg-slate-900/10 backdrop-blur-xs md:hidden" aria-hidden="true" x-on:click="sidebarMateri = false" x-transition.opacity ></div>
   

    <livewire:pages.mahasiswa.components.sidebar-pertemuan :code_pembelajaran="$code_pembelajaran" />

    <!-- top navbar & main content  -->
    <div class="h-svh w-full overflow-y-auto bg-white dark:bg-slate-900">
        <!-- top navbar  -->
        <livewire:pages.mahasiswa.components.navbar-materi :code_pembelajaran="$code_pembelajaran" />
        <!-- main content  -->
        <div id="main-content" class="p-4">
            <div class="overflow-y-auto">
                <div class="flex w-full flex-col gap-4 rounded-md border border-gray-200 p-4 dark:border-gray-700 ">
                   <h1>{{$materi->judul}}</h1>
                   <p class="text-sm prose">{!!$materi->konten!!}</p>
                </div>
            </div>
        </div>
    </div>
</div>




          
                    
                  