<x-app-layout title="Dashboard">

    <nav class="fixed top-0 z-50 w-full border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button aria-controls="logo-sidebar"
                        class="inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 sm:hidden"
                        data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" type="button">
                        <span class="sr-only">Open sidebar</span>
                        <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                                fill-rule="evenodd"></path>
                        </svg>
                    </button>
                    <a class="ms-2 flex md:me-24" href="https://flowbite.com">
                        <img alt="FlowBite Logo" class="me-3 h-8" src="https://flowbite.com/docs/images/logo.svg" />
                        <span
                            class="self-center whitespace-nowrap text-xl font-semibold dark:text-white sm:text-2xl">Flowbite</span>
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <aside aria-label="Sidebar"
        class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-20 transition-transform dark:border-gray-700 dark:bg-gray-800 sm:translate-x-0"
        id="logo-sidebar">
        <div class="h-full overflow-y-auto bg-white px-3 pb-4 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="#">
                        <svg aria-hidden="true"
                            class="h-5 w-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 22 21" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="#">
                        <svg aria-hidden="true"
                            class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Kanban</span>
                        <span
                            class="ms-3 inline-flex items-center justify-center rounded-full bg-gray-100 px-2 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">Pro</span>
                    </a>
                </li>
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="#">
                        <svg aria-hidden="true"
                            class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Inbox</span>
                        <span
                            class="ms-3 inline-flex h-3 w-3 items-center justify-center rounded-full bg-blue-100 p-3 text-sm font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">3</span>
                    </a>
                </li>
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="#">
                        <svg aria-hidden="true"
                            class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 18" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Users</span>
                    </a>
                </li>
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="#">
                        <svg aria-hidden="true"
                            class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 18 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Products</span>
                    </a>
                </li>
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="#">
                        <svg aria-hidden="true"
                            class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            fill="none" viewBox="0 0 18 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Sign In</span>
                    </a>
                </li>
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        href="#">
                        <svg aria-hidden="true"
                            class="h-5 w-5 flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z" />
                            <path
                                d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z" />
                            <path
                                d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Sign Up</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
        <div class="mt-14 rounded-lg border-2 border-dashed border-gray-200 p-4 dark:border-gray-700">
            <div class="mb-4 grid grid-cols-3 gap-4">
                <div class="flex h-24 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
                <div class="flex h-24 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
                <div class="flex h-24 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
            </div>
            <div class="mb-4 flex h-48 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            stroke="currentColor" />
                    </svg>
                </p>
            </div>
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div class="flex h-28 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
                <div class="flex h-28 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
                <div class="flex h-28 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
                <div class="flex h-28 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
            </div>
            <div class="mb-4 flex h-48 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            stroke="currentColor" />
                    </svg>
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex h-28 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
                <div class="flex h-28 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
                <div class="flex h-28 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
                <div class="flex h-28 items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                        <svg aria-hidden="true" class="h-3.5 w-3.5" fill="none" viewBox="0 0 18 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1v16M1 9h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                stroke="currentColor" />
                        </svg>
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
