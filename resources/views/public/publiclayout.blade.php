<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') {{ env('APP_NAME') }} | A Complete Coaching Solution</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    {!! ToastMagic::styles() !!}
</head>

<body class="flex flex-col bg-gray-100 min-h-screen">
    <div class="border border-gray-200 bg-white shadow-lg py-4 px-6">
        <div class="px-6 mx-auto flex items-center justify-between">
            <!-- Logo -->
            <a href="#"
                class="text-xl font-extrabold tracking-tight text-gray-800 hover:text-red-600 transition duration-300">
                The<span class="text-red-600">Book</span><span class="text-gray-600">Show</span>
            </a>

            <div>
                <form action="">
                    <input type="search" placeholder="Search for Movie,Events..." size="50"
                        class="border border-gray-300  rounded-md px-4 py-1 outline-none">
                    <button type="submit"
                        class="bg-red-600 text-white px-4 cursor-pointer py-1 rounded-md hover:bg-red-700 transition duration-300">
                        Search
                </form>
            </div>
            <nav class="hidden md:flex items-center gap-8 text-lg font-medium">
                <a href="#" class="flex items-center gap-1 text-xs text-gray-700 hover:text-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-6a2 2 0 110-4 2 2 0 010 4z"
                            clip-rule="evenodd" />
                    </svg>
                    Your Location
                </a>


                <a href="#"
                    class="bg-red-600 text-xs text-white px-3 py-1 rounded-md font-semibold hover:bg-red-700 transition duration-300">
                    Sing in
                </a>


                <!-- drawer init and toggle -->
                <div class="text-center">
                    <button
                        class="mt-2"
                        type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
                        data-drawer-placement="right" aria-controls="drawer-right-example">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                          </svg>
                          
                    </button>
                </div>

                <!-- drawer component -->
                <div id="drawer-right-example"
                    class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800"
                    tabindex="-1" aria-labelledby="drawer-right-label">
                    <h5 id="drawer-right-label"
                        class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>Right drawer</h5>
                    <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close menu</span>
                    </button>
                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Supercharge your hiring by taking advantage
                        of our <a href="#"
                            class="text-blue-600 underline font-medium dark:text-blue-500 hover:no-underline">limited-time
                            sale</a> for Flowbite Docs + Job Board. Unlimited access to over 190K top-ranked candidates
                        and the #1 design job board.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="#"
                            class="px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Learn
                            more</a>
                        <a href="#"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Get
                            access <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg></a>
                    </div>
                </div>

            </nav>
        </div>
    </div>
    <div class="bg-white flex justify-between shadow-sm py-3 px-6">
        <div class="flex space-x-6 text-xs px-6">
            <a href="#" class="text-gray-700 font-medium hover:text-red-600 transition duration-200">Movies</a>
            <a href="#" class="text-gray-700 font-medium hover:text-red-600 transition duration-200">Streams</a>
            <a href="#" class="text-gray-700 font-medium hover:text-red-600 transition duration-200">Events</a>
            <a href="#" class="text-gray-700 font-medium hover:text-red-600 transition duration-200">Plays</a>
            <a href="#" class="text-gray-700 font-medium hover:text-red-600 transition duration-200">Sports</a>
            <a href="#"
                class="text-gray-700 font-medium hover:text-red-600 transition duration-200">Activities</a>
        </div>
        <div class="flex gap-6 text-xs">
            <a href="#" class="text-gray-700 font-medium hover:text-red-600 transition duration-200">ListYourShow</a>
            <a href="#" class="text-gray-700 font-medium hover:text-red-600 transition duration-200">Corporates</a>
            <a href="#" class="text-gray-700 font-medium hover:text-red-600 transition duration-200">Offers</a>
            <a href="#" class="text-gray-700 font-medium hover:text-red-600 transition duration-200">Gift Cards</a>


        </div>
    </div>
    <main class="flex-grow">
        @section('content')
        @show
    </main>
    <footer class="bg-white text-black border border-gray-200 text-center py-4 mt-8">
        <div class="container mx-auto px-4">
            <p>&copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.</p>
            <p class="text-sm">Made with ❤️ for students & educators.</p>
        </div>
    </footer>

    {!! ToastMagic::scripts() !!}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
