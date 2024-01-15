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
    <?php $this->load->view('style/sidebar') ?>
    <div class="p-4 sm:ml-64 bg-gray-100 min-h-screen font-popins">
        <div class="mt-14 flex justify-between">
            <h1 class="text-xl font-semibold">Peminjaman Buku</h1>
            <ul class="flex gap-2 sm:text-base text-sm">
                <li class=""> Peminjaman</li>
            </ul>
        </div>
        <div class="bg-white p-5 mt-5 ">
            <div class="flex justify-between">
                <div></div>
                <a href="<?= base_url('admin/tambah_peminjaman_buku') ?>">
                    <button class="block text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-sky-600 rounded-lg" type="button">
                        <i class="fas fa-plus"></i>
                        Tambah </button>
                </a>
            </div>
            <div class="relative overflow-x-auto mt-5 mb-5">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
                        <tr>
                            <th scope="col" class="px-6 py-3" style="width: 8%;">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                No Peminjaman
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Peminjam
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tanggal Pinjam
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tanggal Kembali
                            </th>
                            <th scope="col" class="px-6 py-3 text-center"">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($peminjaman) : ?>
                            <?php $no = 0;
                            foreach ($peminjaman as $row) : $no++ ?>
                                <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?php echo $no ?>
                            </th>
                            <td class="px-6 py-4">
                                <?php echo $row->index_pinjam ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo nama_byNis($row->nis) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $row->tgl_pinjam ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $row->tgl_kembali ?>
                            </td>
                            <td class="px-6 py-4 flex items-center justify-center">
                                <a href="<?= base_url('admin/detail_peminjaman/' . $row->index_pinjam) ?>">
                                    <button class="text-white bg-yellow-300 hover:bg-yellow-400 focus:outline-none font-medium text-center rounded-sm px-2 py-1">
                                        <i class="text-base sm:text-lg fas fa-info-circle"></i>
                                    </button>
                                </a>

                                <?php if ($row->konfirmasi_pinjam == 'not') : ?>
                                    <a href="<?= base_url('admin/konfirmasi_pinjam/' . $row->index_pinjam) ?>">
                                        <button class="ml-2 text-white bg-green-400 hover:bg-green-500 focus:outline-none font-medium text-center rounded-sm px-2 py-1">
                                            <i class="text-base sm:text-lg fas fa-check"></i>
                                        </button>
                                    </a>
                                <?php endif ?>

                                <?php if ($row->konfirmasi_kembali == 'not') : ?>
                                    <a href="<?= base_url('admin/konfirmasi_kembali/' . $row->index_pinjam) ?>">
                                        <button class="ml-2 text-white bg-primary hover:bg-sky-600 focus:outline-none font-medium text-center rounded-sm px-2 py-1">
                                            <i class="text-base sm:text-lg fas fa-arrow-alt-circle-left"></i>
                                        </button>
                                    </a>
                                <?php endif ?>

                                <button class="ml-2 text-white bg-red-500 hover:bg-red-600 focus:outline-none font-medium text-center rounded-sm px-2 py-1" onclick="hapus('<?php echo $row->index_pinjam ?>')">
                                    <i class="text-base sm:text-lg fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" colspan="7" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Tidak ada data
                        </th>
                    </tr>
                <?php endif ?>
                </tbody>
                </table>
            </div>
            <div class="pagination">
                <?php echo $pagination_links; ?>
            </div>
        </div>
    </div>

    <?php $this->load->view('style/body') ?>
    <script type="text/javascript">
        function hapus(id) {
            var yes = confirm('Anda Yakin Untuk Menghapus?');
            if (yes == true) {
                window.location.href = "<?php echo base_url('admin/hapus_peminjaman/') ?>" + id;
            }
        }
    </script>
</body>

</html>