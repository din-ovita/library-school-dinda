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
                        <a href="#" class="text-sm font-medium text-gray-500 dark:text-gray-400 dark:hover:text-white">Kategori</a>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="my-5 mx-5 flex gap-2">
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded text-xs md:text-sm px-3 py-1.5 md:px-5 md:py-2.5 text-center inline-flex items-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800" type="button">Kategori<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <?php foreach ($kategori as $row) : ?>
                        <li class="text-left">
                            <button onclick="kategori(<?= $row->id_kategori?>)" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left"><?= $row->nama_kategori ?></button>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>

            <!-- FORM -->
            <form onsubmit="search(event)" class="w-full flex gap-1">
                <input type="text" id="judul" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded focus:ring-primary focus:border-primary block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-blue-500" placeholder="Cari Buku...">
                <button type="submit" class="text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded text-xs md:text-sm px-3 py-1.5 md:px-5 md:py-2.5 text-center inline-flex items-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800"><i class="fas fa-search"></i></button>
            </form>
            <!-- END FORM -->
        </div>

        <div class="bg-white p-5 mt-5 shadow-lg rounded">
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
                            <th scope="col" class="px-6 py-3 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="test">
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
                                    <td class="px-6 py-4 justify-center text-center">
                                        <div>
                                            <?php if (cek_peminjaman_konfirmasi_kembali($row->id_buku, $this->session->userdata('nis')) != 0) : ?>
                                                <button class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none font-medium text-center rounded-sm px-3 py-1.5" disabled>
                                                    Pinjam</button>
                                            <?php elseif (jumlah_buku_tersedia($row->id_buku) == 0) : ?>
                                                <button class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none font-medium text-center rounded-sm px-3 py-1.5" disabled>
                                                    Pinjam</button>
                                            <?php else : ?>
                                                <input type="text" value="<?= $this->session->userdata('nis') ?>" id="nis" class="hidden">
                                                <button onclick="pinjam(<?= $row->id_buku ?>)" class="text-white bg-primary hover:bg-sky-600 focus:outline-none font-medium text-center rounded-sm px-3 py-1.5">
                                                    Pinjam</button>
                                            <?php endif ?>
                                        </div>
                                        <div class="mt-3">
                                            <a href="<?= base_url('member/detail_buku/' . $row->id_buku) ?>">
                                                <button class="text-white bg-yellow-300 hover:bg-yellow-400 focus:outline-none font-medium text-center rounded-sm px-3 py-1.5">
                                                    Detail </button>
                                            </a>
                                        </div>
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
        </div>
    </div>

    <?php $this->load->view('style/body') ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        var nis = $('#nis');

        function pinjam(id) {
            console.log('test');
            $.ajax({
                url: '<?= base_url(); ?>member/pinjam_buku',
                method: 'POST',
                data: {
                    id: id,
                    jumlah: 1,
                    nis: nis.val(),
                },
                error: function(me) {
                    console.log(me);
                },
                success: function(data) {
                    if (data.pinjam === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.messagePinjam,
                            showConfirmButton: false,
                            timer: 1500,
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.messagePinjamError,
                            showConfirmButton: false,
                            timer: 1500,
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    }
                }
            });
        }

        function search(event) {
            event.preventDefault();
            var judulValue = $('#judul').val();
            console.log(judulValue);

            $.ajax({
                url: '<?php echo base_url('member/search_buku') ?>',
                method: 'GET',
                data: {
                    judul: judulValue
                },
                success: function(response) {
                    console.log(response);
                    $('#test').html(response);
                }
            });
        }

        function kategori(id) {
            $.ajax({
                url: '<?php echo base_url('member/by_kategori_buku') ?>',
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    $('#test').html(response);
                }
            });
        }
    </script>
</body>

</html>