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
    <div class="p-4 sm:ml-64 bg-gray-100  min-h-screen font-popins">
        <div class=" flex justify-between">
            <h1 class="text-xl font-semibold">Detail Peminjaman Buku</h1>
            <ul class="flex gap-2 sm:text-base text-sm">
                <li class="capitalize text-primary"><a href="<?php echo base_url('admin/peminjaman_buku') ?>">Peminjaman</a></li>
                /<li class="text-center"> Detail Peminjaman Buku</li>
            </ul>
        </div>
        <div class="bg-white p-5 mt-5 ">
            <h4 class="font-semibold text-2xl">Detail Peminjaman Buku</h4>
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
                        foreach ($peminjaman as $data) : $no++ ?>
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

        </div>
        <br>
        <div class="flex justify-between">
            <div></div>
            <div>
                <a href="<?= base_url('admin/peminjaman_buku') ?>" class="float-right text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center rounded-lg">Kembali</a>
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