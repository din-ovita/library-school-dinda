<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Binusa</title>
    <?php $this->load->view('style/head') ?>
</head>

<body class="font-popins">
    <?php $this->load->view('style/navbar') ?>
    <div class="pt-24 bg-gradient-to-b from-second to-white min-h-screen px-5 lg:px-12">
        <h1 class="text-center mb-10 text-3xl font-extrabold tracking-tight leading-none text-primary md:text-4xl lg:text-5xl">Peminjaman</h1>
        <div class="flex justify-center items-center">
            <button class="<?php $indikator === 1 ? 'text-gray-500' : 'text-primary' ?> ms-3  bg-white focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-primary focus:z-10 mb-3 md:mb-0" onclick="getPeminjaman(1)">Menunggu Konfirmasi</button>
            <button class="<?php $indikator === 2 ? 'text-gray-500' : 'text-primary' ?> ms-3 bg-white focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-primary focus:z-10 " onclick="getPeminjaman(2)">Peminjaman Buku</button>
        </div>
        <div class="relative overflow-x-auto mt-5 mb-5 bg-white p-5 shadow-xl">
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
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($peminjaman) : ?>
                        <?php $no = 0;
                        foreach ($peminjaman as $row) : $no++ ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?php echo $no ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo $row->index_pinjam ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo nama_byNis($row->nis) ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button" class="text-white bg-primary hover:bg-sky-600 focus:outline-none font-medium text-center rounded-sm px-2 py-1" onclick="edit(<?php echo $row->id ?>)"> <i class="text-base sm:text-lg fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="ml-2 text-white bg-red-500 hover:bg-red-600 focus:outline-none font-medium text-center rounded-sm px-2 py-1" onclick="hapus(<?php echo $row->id ?>)"> <i class="text-base sm:text-lg fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" colspan="4" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Tidak ada data
                            </th>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>

        <!-- 
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 items-start gap-6 px-4 md:px-8 test my-12">
            <?php foreach ($peminjaman as $row) : ?>
                <div class="h-auto bg-white border border-gray-200 rounded-lg shadow-xl dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <h5 class="text-lg md:text-xl font-bold tracking-tight text-gray-900 "><?= $row->index_pinjam ?></h5>
                        <?php if ($row->konfirmasi_pinjam === 'yes') : ?>
                            <div class="my-2">
                                <p class="font-semibold text-sm mb-1">Tanggal Pinjam</p>
                                <p><?= indonesian_date($row->tgl_pinjam) ?></p>
                            </div>
                            <hr>
                            <div class="my-2">
                                <p class="font-semibold text-sm mb-1">Tanggal Kembali</p>
                                <p><?= indonesian_date($row->tgl_kembali) ?></p>
                            </div>
                            <hr class="mb-5">
                        <?php endif ?>
                        <span class="text-sm text-green-700 bg-green-200 p-1 rounded-md">Buku Yang Dipinjam</span>
                        <ul class="mt-5 ml-5 list-outside list-disc">
                            <?php $buku_dipinjam = $this->db->where(['index_pinjam' => $row->index_pinjam])->get('table_peminjaman')->result();
                            foreach ($buku_dipinjam as $buku) : ?>
                                <li>
                                    <p class="font-semibold"><?= judulBuku_byIndex($buku->index_buku) ?></p>
                                    <p><?= $buku->index_buku ?></p>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        <?php if ($row->konfirmasi_pinjam === 'yes') : ?>
                            <button onclick="kembalikan('<?= $row->index_pinjam ?>')" class="mt-5 w-full text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Kembalikan</button>
                        <?php else : ?>
                            <button disabled class="mt-5 w-full text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Menunggu Konfirmasi</button>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div> -->
    </div>
    <?php $this->load->view('style/body') ?>
    <script>
        function getPeminjaman(id) {
            window.location.href = "<?= base_url() ?>member/peminjaman_buku" + '?indikator=' + id;
        }

        function kembalikan(id) {
            window.location.href = "<?= base_url() ?>member/kembalikan_buku/" + id;
        }
    </script>
</body>

</html>