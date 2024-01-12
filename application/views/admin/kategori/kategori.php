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
    <div class="p-4 sm:ml-64 bg-gray-100  min-h-screen font-popins">
        <div class="mt-14 flex justify-between">
            <h1 class="text-xl font-semibold">Kategori Buku</h1>
            <ul class="flex gap-2">
                <li class=""> Kategori Buku</li>
            </ul>
        </div>
        <div class="bg-white p-5 mt-5 ">
            <div class="flex justify-between">
                <div></div>
                <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-sky-600 rounded-lg" type="button">
                    <i class="fas fa-plus"></i>
                    Tambah </button>
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
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($kategori) : ?>
                            <?php $no = 0;
                            foreach ($kategori as $row) : $no++ ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $no ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo tampil_nama_rak($row->id_rak) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->nama_kategori ?>
                                    </td>
                                    <td class="px-6 py-4 flex">
                                        <button type="button" data-modal-target="default-modal2" data-modal-toggle="default-modal2" onclick='tampilId(<?php echo $row->id_kategori ?>)' class="text-white bg-primary hover:bg-sky-600 focus:outline-none font-medium text-center rounded-sm px-2 py-1">
                                            <i class="text-base sm:text-lg fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="ml-3 text-white bg-red-500 hover:bg-red-600 focus:outline-none font-medium text-center rounded-sm px-2 py-1" onclick="hapus(<?php echo $row->id_kategori ?>)"> <i class="text-base sm:text-lg fas fa-trash"></i>
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
            <div class="pagination">
                <?php echo $pagination_links; ?>
            </div>
        </div>


        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden mx-auto fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:w-1/2 md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Tambah Kategori Buku
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                m
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form action="<?php echo base_url('admin/aksi_tambah_kategori') ?>" method="post" class="p-4 md:p-5 space-y-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rak</label>
                            <div class="mb-4">
                                <select name="rak" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Pilih Rak</option>
                                    <?php foreach ($rak as $row) : ?>
                                        <option value="<?php echo $row->id_rak ?>"><?php echo $row->nama_rak ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kategori</label>
                            <div class="mb-4">
                                <input type="text" name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Kategori Buku">
                            </div>
                        </div>
                        <div class="flex items-center border-t pt-4 border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-primary dark:focus:ring-sky-600">Tambah</button>
                            <button data-modal-hide="default-modal" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="default-modal2" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden mx-auto fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:w-1/2 md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Edit Kategori Buku
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal2">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                m
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form onsubmit="editKategori(event)" method="post" class="p-4 md:p-5 space-y-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rak</label>
                            <div class="mb-4">
                                <select id="rak" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Pilih Rak</option>
                                    <?php foreach ($rak as $row) : ?>
                                        <option value="<?php echo $row->id_rak ?>"><?php echo $row->nama_rak ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kategori</label>
                            <div class="mb-4">
                                <input type="text" id="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Kategori Buku">
                            </div>
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
                window.location.href = "<?php echo base_url('admin/hapus_kategori/') ?>" + id;
            }
        }

        let rak = $('#rak');
        let kategori = $('#kategori');
        let selectedId = null;

        function tampilId(id) {
            selectedId = id;
            console.log("Clicked button with ID:", selectedId);
            $.ajax({
                url: '<?php echo base_url('admin/get_kategori') ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: selectedId
                },
                success: function(response) {
                    console.log(response);
                    console.log(response[0]['id_rak']);
                    rak.val(response[0]['id_rak']);
                    kategori.val(response[0]['nama_kategori']);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function editKategori(e) {
            e.preventDefault();
            console.log("Testing");
            $.ajax({
                url: '<?= base_url(); ?>admin/aksi_edit_kategori',
                method: 'POST',
                data: {
                    id: selectedId,
                    rak: rak.val(),
                    kategori: kategori.val(),
                },
                error: function(me) {
                    console.log(me);
                },
                success: function(data) {
                    console.log(data);
                    window.location.reload();
                }
            });
        }
    </script>
</body>

</html>