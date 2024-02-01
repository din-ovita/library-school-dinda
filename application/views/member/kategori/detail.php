<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Binusa</title>
    <?php $this->load->view('style/head') ?>
</head>

<body>
    <?php $this->load->view('style/sidebar_member') ?>
    <div class="p-4 sm:ml-64 bg-gray-50 min-h-screen font-popins">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?= base_url('member') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        <i class="text-lg fas fa-chart-pie"></i>
                        <span class="ml-2">Dashboard</span>
                    </a>
                </li>
                <li class="ml-1">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="<?= base_url('member/kategori_buku') ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary md:ms-2 dark:text-gray-400 dark:hover:text-white">Kategori</a>
                    </div>
                </li>
                <li aria-current="page" class="ml-1">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Detail</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="bg-white p-3 sm:p-5 mt-5 shadow-lg rounded">
            <h1 class="font-semibold text-2xl my-2">Detail Buku</h1>
            <?php foreach ($buku as $row) : ?>
                <div class="flex flex-col md:flex-row sm:gap-x-6">
                    <img src="<?= base_url('assets/buku/' . $row->foto) ?>" class="w-32 h-64">
                    <div class="grid grid-cols-1 md:grid-cols-2 mt-5 sm:mt-0 w-full gap-3">
                        <div>
                            <p class="text-sm font-semibold">Judul Buku</p>
                            <br>
                            <p class="text-sm md:text-base"><?= $row->nama_buku ?></p>
                            <hr>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Pengarang Buku</p>
                            <br>
                            <p class="text-sm md:text-base"><?= $row->pengarang ?></p>
                            <hr>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Kategori Buku</p>
                            <br>
                            <p class="text-sm md:text-base"><?= tampil_nama_kategori($row->id_kategori) ?></p>
                            <hr>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Rak Buku</p>
                            <br>
                            <p class="text-sm md:text-base"><?= namaRak_byKategori($row->id_kategori) ?></p>
                            <hr>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Jumlah Buku</p>
                            <br>
                            <p class="text-sm md:text-base"><?= jumlah_buku($row->id_buku) ?></p>
                            <hr>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Deskripsi Buku</p>
                            <br>
                            <p class="text-sm md:text-base"><?= $row->deskripsi ?></p>
                            <hr>
                        </div>
                    </div>
                </div>
                <br>
            <?php endforeach ?>
            <div class="flex justify-end">
                <a href="<?= base_url('member/kategori_buku') ?>" class="text-gray-500 bg-white hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    Kembali </a>
            </div>
        </div>
    </div>

    <?php $this->load->view('style/body') ?>
</body>

</html>