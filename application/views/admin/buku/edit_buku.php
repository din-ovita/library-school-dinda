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
            <h1 class="text-xl font-semibold">Edit Buku</h1>
            <ul class="flex gap-2">
                <li class="capitalize text-primary"><a href="<?php echo base_url('admin/buku') ?>">Buku</a></li>
                /<li class=""> Edit Buku</li>
            </ul>
        </div>
        <div class="bg-white p-5 mt-5 ">
            <h4 class="font-semibold text-2xl">Edit Buku</h4>
            <form action="<?= base_url('admin/aksi_edit_buku') ?>" method="post" enctype="multipart/form-data" class="my-4">
                <?php foreach ($buku as $row) : ?>
                    <input type="text" name="id_buku" value="<?= $row->id_buku ?>" class="hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-x-6">
                        <div><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                            <div class="mb-4">
                                <select name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="<?= $row->id_kategori ?>">Rak <?php echo tampil_nama_rak($row->id_kategori) . ' - ' . tampil_nama_kategori($row->id_kategori) ?></option>
                                    <option disabled>Pilih Kategori</option>
                                    <?php foreach ($kategori as $data) : ?>
                                        <option value="<?php echo $data->id_kategori ?>">Rak <?php echo tampil_nama_rak($data->id_kategori) . ' - ' . $data->nama_kategori ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Buku</label>
                            <div class="mb-4">
                                <input type="text" name="judul" value="<?= $row->nama_buku ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Judul Buku">
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cover Buku</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="cover" onchange="readURL(this);">
                            <div class="grid grid-cols-2 mt-2">
                                <div>
                                    <div>Cover Sebelum :</div>
                                    <img src="<?php $data = $row->foto == null ? base_url('assets/buku/book.jpg') : base_url('assets/buku/') . "/" . $row->foto;
                                                echo $data ?>" width="140" />
                                </div>
                                <div>
                                    <div>Cover Sesudah :</div>
                                    <img id="blah" name="foto" width="140" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" type="button" onclick="kembali()">
                            Kembali </button>
                        <button class="float-right text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-sky-600 rounded-lg" type="submit">
                            Edit </button>
                    </div>
                <?php endforeach ?>
            </form>
        </div>
    </div>

    <?php $this->load->view('style/body') ?>
    <script type="text/javascript">
        function kembali() {
            window.history.go(-1);
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>