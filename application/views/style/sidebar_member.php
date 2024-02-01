<div class="bg-white shadow-lg inline-flex items-center py-2 w-full sm:hidden fixed top-0 z-50 sm:relative text-center gap-5">
    <button data-drawer-target="cta-button-sidebar" data-drawer-toggle="cta-button-sidebar" aria-controls="cta-button-sidebar" type="button" class=" inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>
    <a href="<?= base_url('member') ?>" class="text-3xl font-bold text-primary justify-center">
        <h1><b>L'Binusa</b></h1>
    </a>
</div>

<aside id="cta-button-sidebar" class="fixed shadow-lg top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <div class="text-center mt-4 mb-8">
            <a href="<?= base_url('member') ?>" class=" text-2xl font-bold text-primary">
                <h1><b>L'Binusa</b></h1>
            </a>
        </div>
        <ul class="space-y-2 font-medium px-3">
            <li>
                <a href="<?php echo base_url('member') ?>" class="<?php echo $menu === 'dashboard' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
                    <i class="text-lg fas fa-chart-pie"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('member/kategori_buku') ?>" class="<?php echo $menu === 'kategori' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
                    <i class="text-lg fas fa-list"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Kategori Buku</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('member/peminjaman_buku') ?>" class="<?php echo $menu === 'peminjaman' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
                    <i class="text-lg fas fa-arrow-alt-circle-right"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Peminjaman</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('member/pengembalian_buku') ?>" class="<?php echo $menu === 'pengembalian' ? 'text-white bg-primary' : 'text-gray-800 hover:bg-sky-100 dark:hover:bg-gray-700' ?> flex items-center p-2 rounded-lg dark:text-white group">
                    <i class="text-lg fas fa-arrow-alt-circle-left"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Pengembalian</span>
                </a>
            </li>
        </ul>
        <div class="bottom-5 absolute w-full px-5">
            <div class="flex justify-between">
                <a href="<?= base_url('member/profile') ?>" class="flex items-center text-gray-900 rounded-lg dark:text-white group">
                    <?php foreach ($user as $row) : ?>
                        <?php if ($row->foto == '') : ?>
                            <img class="w-8 h-8 rounded-full" src="<?= base_url('assets/image/profile.jpg') ?>" alt="user photo">
                        <?php else : ?>
                            <img class="w-8 h-8 rounded-full" src="<?= base_url('assets/member/') . $row->foto ?>" alt="user photo">
                        <?php endif ?>
                        <div class="ml-3">
                            <p class="leading-4"><span class="font-medium">
                                    <?= $row->username ?>
                                </span>
                                <span class="block text-gray-500 text-sm"><?= $row->role ?></span>
                            </p>
                        </div>
                    <?php endforeach ?>
                </a>
                <button data-popover-target="popover-default" type="button" class="text-gray-400 hover:text-gray-500 font-medium text-lg "><i class="fas fa-ellipsis-v"></i></button>
                <div data-popover id="popover-default" role="tooltip" class="absolute z-10 invisible inline-block w-24 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                    <div class="px-3 py-2 bg-white border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                        <a href="<?= base_url('login/logout') ?>">Keluar</a>
                    </div>
                    <div data-popper-arrow></div>
                </div>
            </div>
        </div>
    </div>
</aside>
