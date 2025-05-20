<div class="mt-8 flex gap-4 p-10 flex-col">
    <h2 class="text-2xl font-bold">The Best Of Live Events</h2>
    <div class="relative">
      <!-- Left Scroll Button -->
      <button onclick="scrollRev()" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white border shadow-md rounded-full p-2 hover:bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
      </button>
  
   
      <div id="carousel1" class="flex flex-row overflow-x-auto gap-6 scroll-smooth pb-4  snap-x snap-mandatory no-scrollbar">
      
          <div class="snap-start min-w-[37vh]">
              <img src="https://assets-in.bmscdn.com/discovery-catalog/collections/tr:w-800,h-800:l-text,ie-MTY1KyBFdmVudHM%3D,co-FFFFFF,ff-Roboto,fs-64,lx-48,ly-320,tg-b,pa-8_0_0_0,l-end:w-300/comedy-shows-collection-202211140440.png" alt="" class="h-[40vh] rounded-md">
             
          </div>
          <div class="snap-start min-w-[37vh]">
              <img src="https://assets-in.bmscdn.com/discovery-catalog/collections/tr:w-800,h-800:l-text,ie-MjUrIEV2ZW50cw%3D%3D,co-FFFFFF,ff-Roboto,fs-64,lx-48,ly-320,tg-b,pa-8_0_0_0,l-end:w-300/amusement-parks-banner-desktop-collection-202503251132.png" alt="" class="h-[40vh] rounded-md">
             
          </div> <div class="snap-start min-w-[37vh]">
              <img src="https://assets-in.bmscdn.com/discovery-catalog/collections/tr:w-800,h-800:l-text,ie-MTY1KyBFdmVudHM%3D,co-FFFFFF,ff-Roboto,fs-64,lx-48,ly-320,tg-b,pa-8_0_0_0,l-end:w-300/theatre-shows-collection-202211140440.png" alt="" class="h-[40vh] rounded-md">
             
          </div> <div class="snap-start min-w-[37vh]">
              <img src=https://assets-in.bmscdn.com/discovery-catalog/collections/tr:w-800,h-800:l-text,ie-NTArIEV2ZW50cw%3D%3D,co-FFFFFF,ff-Roboto,fs-64,lx-48,ly-320,tg-b,pa-8_0_0_0,l-end:w-300/kids-banner-desktop-collection-202503251132.png alt="" class="h-[40vh] rounded-md">
             
          </div> <div class="snap-start min-w-[37vh]">
              <img src=https://assets-in.bmscdn.com/discovery-catalog/collections/tr:w-800,h-800:l-text,ie-NTUrIEV2ZW50cw%3D%3D,co-FFFFFF,ff-Roboto,fs-64,lx-48,ly-320,tg-b,pa-8_0_0_0,l-end:w-300/adventure-fun-collection-202211140440.png alt="" class="h-[40vh] rounded-md">
             
          </div>
          
      </div>
  
      <!-- Right Scroll Button -->
      <button onclick="scrollNew()" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white border shadow-md rounded-full p-2 hover:bg-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
      </button>
      <script>
          function scrollNew() {
              const carousel1 = document.getElementById('carousel1');
              carousel1.scrollBy({ 
                  left: carousel1.firstElementChild.offsetWidth + 24,
                  behavior: 'smooth' 
              });
          }
      
          function scrollRev() {
              const carousel1 = document.getElementById('carousel1');
              carousel1.scrollBy({ 
                  left: -(carousel1.firstElementChild.offsetWidth + 24),
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