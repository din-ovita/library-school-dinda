<nav class="fixed top-0 z-50 w-full bg-primary dark:bg-gray-800 dark:border-gray-700 font-popins">
   <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
         <div class="flex items-center justify-start rtl:justify-end">
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-white rounded-lg sm:hidden hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
               <span class="sr-only">Open sidebar</span>
               <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
               </svg>
            </button>
            <a href="<?php echo base_url('admin') ?>" class="flex ms-2 md:me-24">
               <h1 class="text-center text-2xl text-white"><b>L'Binusa</b></h1>
            </a>
         </div>
         <div class="flex items-center">
            <div class="flex items-center ms-3">
               <div>
                  <button type="button" class="flex text-sm rounded-full focus:ring-2 focus:ring-sky-300" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                     <span class="sr-only">Open user menu</span>
                     <img class="w-8 h-8 rounded-full" src="<?php echo base_url('assets/image/profile.jpg') ?>">
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
</nav>

<aside id="logo-sidebar" class="fixed font-popins top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="<?php echo base_url('admin') ?>" class="<?php echo $menu === 'dashboard' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
               <i class="text-lg fas fa-chart-pie"></i>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         <li>
            <a href="<?php echo base_url('admin/rak_buku') ?>" class="<?php echo $menu === 'rak' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
               <i class="text-lg fas fa-table"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Rak Buku</span>
            </a>
         </li>
         <li>
            <a href="<?php echo base_url('admin/kategori_buku') ?>" class="<?php echo $menu === 'kategori' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
               <i class="text-lg fas fa-list"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Kategori Buku</span>
            </a>
         </li>
         <li>
            <a href="<?php echo base_url('admin/buku') ?>" class="<?php echo $menu === 'buku' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
               <i class="text-lg fas fa-book"></i> <span class="flex-1 ms-3 whitespace-nowrap">Buku</span>
            </a>
         </li>
         <li>
            <a href="<?php echo base_url('admin/anggota') ?>" class="<?php echo $menu === 'anggota' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
               <i class="text-lg fas fa-users"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Anggota</span>
            </a>
         </li>
         <li>
            <a href="<?php echo base_url('admin/peminjaman_buku') ?>" class="<?php echo $menu === 'peminjaman' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
               <i class="text-lg fas fa-arrow-alt-circle-right"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Peminjaman</span>
            </a>
         </li>
         <li>
            <a href="<?php echo base_url('admin/pengembalian_buku') ?>" class="<?php echo $menu === 'pengembalian' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
               <i class="text-lg fas fa-arrow-alt-circle-left"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Pengembalian</span>
            </a>
         </li>
         <li class="fixed bottom-5">
            <a href="<?php echo base_url('login/logout') ?>" class="flex w-full items-center p-2 text-gray-900 rounded-lg dark:text-white group">
               <i class="text-lg far fa-circle"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Keluar</span>
            </a>
         </li>
      </ul>
   </div>
</aside>