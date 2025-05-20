<div class=" flex gap-2 p-10 flex-col">
    <h2 class="text-2xl font-bold">Recommeded Movies</h2>
    <div class="relative">
        <!-- Left Scroll Button -->
        <button onclick="scrollPrev()" class="absolute left-0 top-1/3 -translate-y-1/2 z-10 bg-white border shadow-md rounded-full p-2 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    
     
        <div id="carousel" class="flex flex-row overflow-x-auto gap-6 scroll-smooth pb-4  snap-x snap-mandatory no-scrollbar">
        
            <div class="snap-start min-w-[37vh]">
                <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,.../et00419530-kjtupqvphv-portrait.jpg" alt="" class="h-[60vh] rounded-md">
                <h2 class="text-xl font-semibold">Mission: Impossible<br>The Final Reckoning</h2>
                <span class="text-gray-600 font-semibold">Action/Adventure/Thriller</span>
            </div>
            <div class="snap-start min-w-[37vh]">
                <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,.../et00432143-fasdbazkpx-portrait.jpg" class="h-[60vh] rounded-md">
                <h2 class="text-xl text-gray-800 font-semibold">The Final Destination</h2>
                <span class="text-gray-600 font-semibold">Action/Adventure/Thriller</span>
            </div>
            <div class="snap-start min-w-[37vh]">
                <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,.../et00382745-lxrdjxktjl-portrait.jpg" class="h-[60vh] rounded-md">
                <h2 class="text-xl font-semibold">Raid 2</h2>
                <span class="text-gray-600 font-semibold">Drama/Thriller</span>
            </div>
            <div class="snap-start min-w-[37vh]">
                <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,.../et00440755-rgyluhxjzv-portrait.jpg" class="h-[60vh] rounded-md">
                <h2 class="text-xl font-semibold">Ata Tambchya Naay</h2>
                <span class="text-gray-600 font-semibold">Action/Adventure/Thriller</span>
            </div>
            <div class="snap-start min-w-[37vh]">
                <img src="https://assets-in.bmscdn.com/discovery-catalog/events/tr:w-400,h-600,.../et00432582-rusdvqeqzf-portrait.jpg" class="h-[60vh] rounded-md">
                <h2 class="text-xl font-semibold">Gulkand</h2>
                <span class="text-gray-600 font-semibold">Comedy/Family</span>
            </div>
        </div>
    
        <!-- Right Scroll Button -->
        <button onclick="scrollNext()" class="absolute right-0 top-1/3 -translate-y-1/2 z-10 bg-white border shadow-md rounded-full p-2 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    
        <!-- Bottom Image Section -->
        <div class="mt-10">
            <img src="https://assets-in.bmscdn.com/discovery-catalog/collections/tr:w-1440,h-120/stream-leadin-web-collection-202210241242.png" alt="">
        </div>
    </div>
    
   
    <script>
        function scrollNext() {
            const carousel = document.getElementById('carousel');
            // Scroll by one item's width + gap
            carousel.scrollBy({ 
                left: carousel.firstElementChild.offsetWidth + 24, // 24 matches gap-6
                behavior: 'smooth' 
            });
        }
    
        function scrollPrev() {
            const carousel = document.getElementById('carousel');
            carousel.scrollBy({ 
                left: -(carousel.firstElementChild.offsetWidth + 24),
                behavior: 'smooth' 
            });
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</div>