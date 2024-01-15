<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Binusa</title>
    <?php $this->load->view('style/head') ?>
</head>

<body>
    <?php $this->load->view('style/sidebar') ?>
    <div class="p-4 sm:ml-64 bg-gray-100 min-h-screen font-popins">
        <div class="mt-14 flex justify-between">
            <h1 class="text-xl font-semibold">Buku</h1>
            <ul class="flex gap-2 sm:text-base text-sm">
                <li class="capitalize text-primary"><a href="<?php echo base_url('admin/buku') ?>">Buku</a></li>
                /<li class=""> Detail Buku</li>
            </ul>
        </div>
        <div class="bg-white p-3 sm:p-5 mt-5 ">
            <?php foreach ($buku as $row) : ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-x-6">
                    <img src="<?= base_url('assets/buku/' . $row->foto) ?>" class="w-full h-full sm:h-5/6">
                    <div class="mt-5 sm:mt-0">
                        <div>
                            <p class="text-sm font-semibold">Judul Buku</p>
                            <br>
                            <p><?= $row->nama_buku ?></p>
                            <hr>
                        </div>
                        <br>
                        <div>
                            <p class="text-sm font-semibold">Kategori Buku</p>
                            <br>
                            <p><?= tampil_nama_kategori($row->id_kategori) ?></p>
                            <hr>
                        </div>
                        <br>
                        <div>
                            <p class="text-sm font-semibold">Rak Buku</p>
                            <br>
                            <p><?= namaRak_byKategori($row->id_kategori) ?></p>
                            <hr>
                        </div>
                        <br>
                        <div>
                            <p class="text-sm font-semibold">Jumlah Buku</p>
                            <br>
                            <p><?= jumlah_buku($row->id_buku) ?></p>
                            <hr>
                        </div>
                        <br>
                        <div class="flex justify-between ">
                            <div></div>
                            <button type="button" data-modal-target="default-modal2" data-modal-toggle="default-modal2" onclick='tampilId(<?php echo $row->id_buku ?>)' class="block text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-sky-600 rounded-lg" type="button">
                                <i class="fas fa-plus"></i>
                                Tambah Jumlah</button>
                        </div>
                    </div>
                </div>
                <div class="relative overflow-x-auto mb-5 mt-4 sm:mt-0">
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
                                    ID Buku
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status </th>
                                <th scope="col" class="px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($index) : ?>
                                <?php $no = 0;
                                foreach ($index as $data) : $no++ ?>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <?php echo $no ?>
                                        </th>
                                        <td class="px-6 py-4">
                                            <?php echo judul_buku($data->id_buku) ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo $data->index_buku ?>
                                        </td>
                                        <td class="px-6 py-4 capitalize">
                                            <?php echo $data->status ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button type="button" class="ml-2 text-white bg-red-500 hover:bg-red-600 focus:outline-none font-medium text-center rounded-sm px-2 py-1" onclick="hapus(<?php echo $data->id ?>)">
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
            <?php endforeach ?>
        </div>

        <div id="default-modal2" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden mx-auto fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:w-1/2 md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Tambah Jumlah Buku
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal2">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                m
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form onsubmit="tambah(event)" method="post" class="p-4 md:p-5 space-y-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Buku</label>
                        <div class="mb-4">
                            <input type="number" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Jumlah Buku">
                        </div>
                        <div class="flex items-center border-t pt-4 border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-primary dark:focus:ring-sky-600">Edit</button>
                            <button data-modal-hide="default-modal2" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <?php $this->load->view('style/body') ?>
    <script type="text/javascript">
        function hapus(id) {
            var yes = confirm('Anda Yakin Untuk Menghapus?');
            if (yes == true) {
                window.location.href = "<?php echo base_url('admin/hapus_index_buku/') ?>" + id;
            }
        }

        let jumlah = $('#jumlah');
        let selectedId = null;

        function tampilId(id) {
            selectedId = id;
            console.log("Clicked button with ID:", selectedId);
        }

        function tambah(e) {
            e.preventDefault();
            console.log("Testing");
            $.ajax({
                url: '<?= base_url(); ?>admin/aksi_tambah_jumlah_buku',
                method: 'POST',
                data: {
                    id: selectedId,
                    jumlah: jumlah.val(),
                },
                error: function(me) {
                    console.log(me);
                },
                success: function(data) {
                    console.log(data);
                    // window.location.reload();
                }
            });
        }
    </script>
</body>

</html>