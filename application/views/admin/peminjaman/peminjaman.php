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
    <div class="p-4 sm:ml-64 bg-gray-50 min-h-screen font-popins">
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
                        <a href="#" class="text-sm font-medium text-gray-500 dark:text-gray-400 dark:hover:text-white">Peminjaman</a>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white p-5 mt-5 shadow-lg rounded">
            <div class="flex justify-between">
                <div>
                    <h1 class="text-xl font-semibold">Peminjaman Buku</h1>
                </div>
                <div class="flex flex-col md:flex-row gap-2">
                    <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-sky-600 rounded-lg" type="button">
                        <i class="fas fa-edit"></i>
                        Denda </button>

                    <a href="<?= base_url('admin/tambah_peminjaman_buku') ?>">
                        <button class="block text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-sky-600 rounded-lg" type="button">
                            <i class="fas fa-plus"></i>
                            Tambah </button>
                    </a>
                </div>
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

                                <?php if ($row->konfirmasi_kembali_admin == 'not') : ?>
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

    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden mx-auto fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:w-1/2 md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Denda
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            m
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="<?php echo base_url('admin/aksi_edit_denda') ?>" method="post" class="p-4 md:p-5 space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Denda</label>
                        <div class="mb-4">
                            <input type="number" name="nominal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan nominal denda" value="<?= nominal_denda(1) ?>">
                        </div>
                    </div>
                    <p class="text-sm">Perubahan denda, untuk keterlambatan setelah perubahan</p>
                    <input type="number" value="1" name="id_denda" class="hidden">
                    <div class="flex items-center border-t pt-4 border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" class="text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-primary dark:focus:ring-sky-600">Edit</button>
                        <button data-modal-hide="default-modal" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $this->load->view('style/body') ?>
    <script type="text/javascript">
        function hapus(id) {
            Swal.fire({
                title: 'Anda Yakin Untuk Mengapus?',
                text: "Data Tidak Bisa Dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url('admin/hapus_peminjaman') ?>" + "/" + id;
                    }, 1500);
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'Berhasil Menghapus Peminjaman Buku!',
                        icon: 'success',
                        showConfirmButton: false
                    })
                }
            })
        }
    </script>
</body>

</html>