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
            <h1 class="text-xl font-semibold">Buku</h1>
            <ul class="flex gap-2 sm:text-base text-sm">
                <li class=""> Buku</li>
            </ul>
        </div>
        <div class="bg-white p-5 mt-5 ">
            <div class="flex justify-between">
                <div></div>
                <a href="<?= base_url('admin/tambah_buku') ?>">
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
                                Rak
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Kategori Buku
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Judul Buku
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cover Buku
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah Buku
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($buku) : ?>
                            <?php $no = 0;
                            foreach ($buku as $row) : $no++ ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $no ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo namaRak_byKategori($row->id_kategori) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo tampil_nama_kategori($row->id_kategori) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->nama_buku ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($row->foto == '') : ?>
                                            <img src="<?= base_url('assets/image/book.jpg') ?>" alt="" width="100">
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/buku/' . $row->foto) ?>" alt="" width="100">
                                        <?php endif ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php echo jumlah_buku($row->id_buku) ?>
                                    </td>
                                    <td class="px-6 py-4 flex items-center justify-center">
                                        <a href="<?= base_url('admin/edit_buku/' . $row->id_buku) ?>">
                                            <button class="text-white bg-primary hover:bg-sky-600 focus:outline-none font-medium text-center rounded-sm px-2 py-1">
                                                <i class="text-base sm:text-lg fas fa-edit"></i>
                                            </button>
                                        </a>
                                        <a href="<?= base_url('admin/detail_buku/' . $row->id_buku) ?>">
                                            <button class="ml-2 text-white bg-yellow-300 hover:bg-yellow-400 focus:outline-none font-medium text-center rounded-sm px-2 py-1">
                                                <i class="text-base sm:text-lg fas fa-info-circle"></i>
                                            </button>
                                        </a>
                                        <button type="button" class="ml-2 text-white bg-red-500 hover:bg-red-600 focus:outline-none font-medium text-center rounded-sm px-2 py-1" onclick="hapus(<?php echo $row->id_buku ?>)">
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
                window.location.href = "<?php echo base_url('admin/hapus_buku/') ?>" + id;
            }
        }
    </script>
</body>

</html>