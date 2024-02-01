<?php if ($buku_kategori) : ?>
    <?php $no = 0;
    foreach ($buku_kategori as $row) : $no++ ?>
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