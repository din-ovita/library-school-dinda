<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Binusa</title>
    <?php $this->load->view('style/head') ?>
</head>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin: 0.5em auto;
        list-style: none;
    }

    .pagination a,
    .pagination li.active a {
        border: 1px solid silver;
        padding: 0.1em 0.5em;
        border-radius: 10px;
        color: black;
        margin-right: 0.5em;
        text-decoration: none;
    }

    .pagination a:hover,
    .pagination li.active a {
        border: 1px solid rgb(14 165 233);
        background-color: rgb(14 165 233);
        color: white;
    }
</style>

<body>
    <?php $this->load->view('style/sidebar_member') ?>
    <div class="p-4 mt-14 sm:mt-0 sm:ml-64 bg-gray-50 min-h-screen font-popins">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?= base_url('member') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        <i class="text-lg fas fa-chart-pie"></i>
                        <span class="ml-2">Dashboard</span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#" class="text-sm font-medium text-gray-500 dark:text-gray-400 dark:hover:text-white">Pengembalian</a>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="font-semibold text-2xl mt-5">Pengembalian Buku</h1>

        <div class="mx-auto my-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 test">
                <?php foreach ($pengembalian as $row) : ?>
                    <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 relative">
                        <div class="p-3 h-60 text-center">
                            <p class="tracking-tight text-gray-900 font-bold text-lg"><?= $row->index_pinjam ?></p>
                            <h5 class="text-base font-medium tracking-tight text-gray-900 dark:text-white"><?= nama_byNis($row->nis) ?></h5>
                            <h5 class="mb-2 text-sm font-medium tracking-tight text-gray-700 dark:text-white"><?= $row->nis ?></h5>
                            <p class="text-sm font-normal mb-1">Tanggal Pengembalian</p>
                            <p class="font-medium">
                                <?= $row->tgl_pengembalian ?>
                            </p>
                            <p class="text-sm font-normal mt-1">Denda</p>
                            <?php if ($row->konfirmasi_kembali_admin == 'yes' && $row->status == 'telat') : ?>
                                <p class="font-medium">
                                    <?= convRupiah(denda_keterlambatan($row->index_pinjam)) ?>
                                </p>
                            <?php else : ?>
                                -
                            <?php endif ?>
                        </div>
                        <div class="absolute bottom-2 w-full px-3 flex">
                            <?php if ($row->konfirmasi_kembali == 'yes' && $row->konfirmasi_kembali_admin == 'not') : ?>
                                <button class="w-full px-3 py-2 text-xs sm:text-sm font-medium text-center text-gray-500 bg-gray-100  rounded" disabled>Menunggu Konfirmasi</button>
                            <?php elseif ($row->konfirmasi_kembali_admin == 'yes' && $row->status == 'tepat waktu') : ?>
                                <button class="w-full px-3 py-2 text-xs sm:text-sm font-medium text-center text-green-500 bg-green-100  rounded" disabled>Tepat Waktu</button>
                            <?php elseif ($row->konfirmasi_kembali_admin == 'yes' && $row->status == 'telat') : ?>
                                <button class="w-full px-3 py-2 text-xs sm:text-sm font-medium text-center text-red-500 bg-red-100  rounded" disabled>Telat</button>
                            <?php endif ?>
                            <a href="<?= base_url('member/detail_pengembalian/' . $row->index_pinjam) ?>" class="ml-2">
                                <button class="text-white bg-yellow-300 hover:bg-yellow-400 focus:outline-none font-medium text-center rounded px-2 py-1">
                                    <i class="text-base sm:text-lg fas fa-info-circle"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>

    <?php $this->load->view('style/body') ?>
</body>

</html>