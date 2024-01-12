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
        <div class="mt-14 flex justify-between">
            <h1 class="text-xl font-semibold">Tambah Peminjaman Buku</h1>
            <ul class="flex gap-2">
                <li class="capitalize text-primary"><a href="<?php echo base_url('admin/peminjaman_buku') ?>">Peminjaman</a></li>
                /<li class=""> Tambah Peminjaman Buku</li>
            </ul>
        </div>
        <div class="bg-white p-5 mt-5 ">
            <h4 class="font-semibold text-2xl">Tambah Peminjaman Buku</h4>
            <form action="<?= base_url('admin/tambah_peminjaman_buku') ?>" method="post" class="my-4">
                <div class="">
                    <div><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Anggota</label>
                        <div class="mb-4">
                            <select name="member" id="member" class="w-full">
                                <option selected value="">Pilih Anggota</option>
                                <?php foreach ($member as $row) : ?>
                                    <option value="<?php echo $row->nis ?>"><?php echo $row->nis . ' - ' . $row->nama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-3">
                    <div></div>
                    <?php if ($nis_member == '') : ?>
                        <button class="float-right text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-sky-600 rounded-lg" type="submit">
                            Pilih </button>
                    <?php else : ?>
                        <button class="float-right text-white bg-gray-600 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-600 rounded-lg" type="button" disabled>
                            Pilih </button>
                    <?php endif ?>
                </div>
            </form>
            <br>
            <hr>
            <?php if ($nis_member == '') : ?>
            <?php else : ?>
                <br>
                <?php foreach ($index_pinjam as $data) : ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-x-6 gap-y-6">
                        <div>
                            <p class="text-sm mb-3 font-semibold">No Peminjaman</p>
                            <p><?= $data->index_pinjam ?></p>
                            <hr>
                        </div>
                        <div>
                            <p class="text-sm mb-3 font-semibold">Nama Peminjam</p>
                            <p><?= $data->nis . ' - ' . nama_byNis($data->nis) ?></p>
                            <hr>
                        </div>
                        <div>
                            <p class="text-sm mb-3 font-semibold">Tanggal Pinjam</p>
                            <p><?= $data->tgl_pinjam ?></p>
                            <hr>
                        </div>
                        <div>
                            <p class="text-sm mb-3 font-semibold">Tanggal Kembali</p>
                            <p><?= $data->tgl_kembali ?></p>
                            <hr>
                        </div>
                    </div>
                    <br><br><br>
                    <form action="<?= base_url('admin/tambah_peminjaman') ?>" method="post">
                        <input type="text" name="index" value="<?= $data->id ?>" class="hidden">
                        <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-x-6">
                            <div><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buku</label>
                                <div class="mb-4">
                                    <select name="buku" id="buku" class="w-full">
                                        <option selected value="">Pilih Buku</option>
                                        <?php foreach ($buku as $row) : ?>
                                            <option value="<?php echo $row->id_buku ?>"><?php echo $row->nama_buku ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Buku</label>
                                <div class="mb-4">
                                    <input type="number" name="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Jumlah Buku">
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div></div>
                            <button class="float-right text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-sky-600 rounded-lg" type="submit">
                                Pinjam </button>
                        </div>
                    </form>
                <?php endforeach ?>
            <?php endif ?>
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
    <script>
        $(function() {
            $("#member").select2();
            $("#buku").select2();
        });
    </script>
</body>

</html>