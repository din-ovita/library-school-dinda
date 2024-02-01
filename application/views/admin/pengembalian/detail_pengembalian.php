<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Binusa</title>
    <?php $this->load->view('style/head') ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <?php $this->load->view('style/sidebar') ?>
    <div class="p-4 sm:ml-64 bg-gray-50  min-h-screen font-popins">
    <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?= base_url('admin') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        <i class="text-lg fas fa-chart-pie"></i>
                        <span class="ml-2">Dashboard</span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="<?= base_url('admin/pengembalian_buku') ?>" class="text-sm font-medium text-gray-700 hover:text-primary dark:text-gray-400 dark:hover:text-white">Pengembalian</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#" class="text-sm font-medium text-gray-500 dark:text-gray-400 dark:hover:text-white">Detail</a>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white p-5 mt-5 shadow-lg rounded">
            <h4 class="font-semibold text-2xl">Detail Pengembalian Buku</h4>
            <br>
            <?php foreach ($index as $row) : ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-x-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Index Peminjaman</label>
                        <div class="mb-4">
                            <p><?= $row->index_pinjam ?></p>
                            <input type="text" name="index" class="hidden" value="<?= $row->index_pinjam ?>">
                            <input type="text" name="member" class="hidden" value="<?= $row->nis ?>">
                        </div>
                        <hr>
                        <br>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Peminjam</label>
                        <div class="mb-4">
                            <p><?= nama_byNis($row->nis) . ' - ' . $row->nis ?></p>
                        </div>
                        <hr><br>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pinjam</label>
                        <div class="mb-4">
                            <p><?= $row->tgl_pinjam ?></p>
                        </div>
                        <hr>
                        <br>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Kembali</label>
                        <div class="mb-4">
                            <p><?= $row->tgl_kembali ?></p>
                        </div>
                        <hr><br>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengembalian</label>
                        <div class="mb-4">
                            <p><?= $row->tgl_pengembalian ?></p>
                        </div>
                        <hr><br>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <div class="mb-4">
                            <p class="capitalize"><?= $row->status ?></p>
                        </div>
                        <hr><br>
                    </div>
                    <?php if ($row->status == 'telat') : ?>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Denda</label>
                            <div class="mb-4">
                                <p class="capitaliz"><?= convRupiah(denda_keterlambatan($row->index_pinjam)) ?></p>
                            </div>
                            <hr><br>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Denda Terbayar</label>
                            <div class="mb-4">
                                <p class="capitalize"><?= konfirmasi_bayar_denda($row->index_pinjam) ?></p>
                            </div>
                            <hr><br>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
            <div class="relative overflow-x-auto mt-5 mb-5">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
                        <tr>
                            <th scope="col" class="px-6 py-3" style="width: 8%;">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Judul Buku
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Index Buku
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                        foreach ($pengembalian as $data) : $no++ ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $no ?></td>
                                <td class="px-6 py-4">
                                    <?= judulBuku_byIndex($data->index_buku) ?></td>
                                <td class="px-6 py-4">
                                    <?= $data->index_buku ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="flex justify-end">
                <a href="<?= base_url('admin/pengembalian_buku') ?>" class="text-gray-500 bg-white hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    Kembali </a>
            </div>
        </div>
    </div>

    <?php $this->load->view('style/body') ?>
    <script type="text/javascript">
        function kembali() {
            window.history.go(-1);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>