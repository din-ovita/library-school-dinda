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
    <div class="p-4 sm:ml-64 bg-gray-50  min-h-screen font-popins">
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
            <h4 class="font-semibold text-2xl">Tambah Peminjaman Buku</h4>
            <form action="<?= base_url('admin/aksi_tambah_buku_dipinjam') ?>" method="post" class="my-4">
                <?php foreach ($index as $row) : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Index Peminjaman</label>
                            <div class="mb-4">
                                <p><?= $row->index_pinjam ?></p>
                                <input type="text" name="index" class="hidden" value="<?= $row->index_pinjam ?>">
                                <input type="text" name="member" class="hidden" value="<?= $row->nis ?>">
                            </div>
                            <hr>
                        </div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Anggota</label>
                            <div class="mb-4">
                                <p><?= nama_byNis($row->nis) . ' - ' . $row->nis ?></p>
                            </div>
                            <hr>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pinjam</label>
                            <div class="mb-4">
                                <p><?= $row->tgl_pinjam ?></p>
                            </div>
                            <hr>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Kembali</label>
                            <div class="mb-4">
                                <p><?= $row->tgl_kembali ?></p>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <br>
                    <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-x-6 gap-y-6 sm:gap-y-0">
                        <div><label class="block mb-2 text-sm font-medium text-gray-900">Buku</label>
                            <div class="mb-4">
                                <select name="buku" id="buku" style="width: 100%;" required>
                                    <option selected value="">Pilih Buku</option>
                                    <?php foreach ($buku as $row) : ?>
                                        <option value="<?php echo $row->id_buku ?>"><?php echo $row->nama_buku ?></option>
                                    <?php endforeach ?>
                                </select>
                                <p class="mt-2" id="jumlah_buku"></p>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jumlah Buku</label>
                            <div class="mb-4">
                                <input type="number" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 " placeholder="Jumlah Buku" required>
                                <p class="mt-2 text-red-500" id="batas_jml"></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="flex justify-between">
                        <div></div>
                        <button id="button" class="float-right text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center rounded-lg" type="submit">
                            Pinjam </button>
                    </div>
                <?php endforeach ?>
            </form>
            <div class="relative overflow-x-auto mt-5 mb-5">
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
                                Index Buku
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                        foreach ($peminjaman as $data) : $no++ ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $no ?></td>
                                <td class="px-6 py-4">
                                    <?= judulBuku_byIndex($data->index_buku) ?></td>
                                <td class="px-6 py-4">
                                    <?= $data->index_buku ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>
        <br>
        <div class="flex justify-between">
            <div></div>
            <div>
                <a href="<?= base_url('admin/peminjaman_buku') ?>" class="float-right text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center rounded-lg">Selesai</a>
            </div>
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

        let id_buku = $('#buku');
        let jumlah = $('#jumlah');

        id_buku.change(function() {
            $.ajax({
                url: '<?php echo base_url('admin/jumlah_buku') ?>',
                method: 'POST',
                data: {
                    id_buku: id_buku.val()
                },
                success: function(response) {
                    console.log(response);
                    $('#jumlah_buku').html('Jumlah buku tersedia : ' + response);
                    let jml = response;
                    jumlah.change(function() {
                        if (parseInt(jumlah.val()) > parseInt(jml)) {
                            $('#batas_jml').html('Melebihi batas tersedia !');
                            $('#button').prop('type', 'button');
                            $('#button').removeClass('bg-primary');
                            $('#button').removeClass('hover:bg-sky-600');
                            $('#button').addClass('hover:bg-gray-600');
                            $('#button').addClass('bg-gray-500');
                        } else {
                            $('#batas_jml').html('');
                            $('#button').prop('type', 'submit');
                            $('#button').removeClass('bg-gray-500');
                            $('#button').removeClass('hover:bg-gray-600');
                            $('#button').addClass('bg-primary');
                            $('#button').addClass('hover:bg-sky-600');
                        }
                    });

                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        // let form = $('#form');
        // form.submit(function() {
        //     event.preventDefault();

        //     $.ajax({
        //         url: '<?php echo base_url('admin/tambah_peminjaman') ?>',
        //         method: 'POST',
        //         data: {
        //             buku: id_buku.val(),
        //             jumlah: jumlah.val(),
        //             nis: $('#nis').val(),
        //             index: $('#index').val(),
        //         },
        //         success: function(response) {
        //             console.log(response);
        //             $('#hasil').html(response);
        //         }
        //     })
        // })
    </script>
</body>

</html>