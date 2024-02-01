<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Binusa</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php $this->load->view('style/head') ?>
</head>

<style>
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px #f3f4f6;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>

<body>
    <?php $this->load->view('style/sidebar_member') ?>
    <div class="p-4 mt-16 md:mt-0 sm:ml-64 bg-gray-50 font-popins">
        <div class="bg-sky-100 shadow-lg mt-6 md:mt-12 h-32 md:h-44 p-2 md:p-5 rounded items-center w-full flex justify-between overflow-visible">
            <div>
                <?php foreach ($user as $row) : ?>
                    <h1 class="font-bold text-xl md:text-4xl">Hi, <?= $row->username ?></h1>
                    <p class="md:text-base text-xs">Bersiap untuk jelajahi pengetahuan baru!</p>
                <?php endforeach ?>
            </div>
            <img src="<?= base_url('assets/image/book6.png') ?>" alt="" class="h-48 md:h-72 z-20 mb-6 md:mb-14">
        </div>
        <div class="my-8">
            <h1 class="font-semibold text-2xl">Buku Terbaru</h1>
            <div class="mx-auto m2-5">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4 test">
                    <?php foreach ($new_book as $row) : ?>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 relative">
                            <img class="rounded-t-lg w-full h-44 md:h-52" src="<?= base_url('assets/buku/' . $row->foto) ?>" alt="" />
                            <div class="p-3 h-36">
                                <p class="tracking-tight text-gray-900 font-medium text-sm"><?= $row->pengarang ?></p>
                                <h5 class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white"><?= $row->nama_buku ?></h5>
                            </div>
                            <div class="absolute bottom-2 w-full px-3">
                                <?php if (jumlah_buku_tersedia($row->id_buku) == 0) : ?>
                                    <button class="w-full px-3 py-2 text-xs sm:text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" disabled>Tidak Tersedia</button>
                                <?php elseif (cek_peminjaman_konfirmasi_kembali($row->id_buku, $this->session->userdata('nis')) != 0) : ?>
                                    <button class=" w-full px-3 py-2 text-xs sm:text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" disabled>Sedang Dipinjam</button>
                                <?php else : ?>
                                    <input type="text" value="<?= $this->session->userdata('nis') ?>" id="nis" class="hidden">
                                    <button onclick="pinjam(<?= $row->id_buku ?>)" class="w-full px-3 py-2 text-xs sm:text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800">Pinjam</button>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="flex justify-center items-center mt-12">
                    <a href="<?= base_url('member/kategori_buku') ?>" class="ms-3 text-gray-500 bg-white hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Lihat Lebih Banyak</a>
                </div>
            </div>
        </div>
        <!-- <div class="my-8">
            <h1 class="font-semibold text-2xl">Buku Rekomendasi</h1>
            <div class="mx-auto mt-2">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4 test">
                    <?php foreach ($all_book as $row) : ?>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 relative">
                            <img class="rounded-t-lg w-full h-44 md:h-56" src="<?= base_url('assets/buku/' . $row->foto) ?>" alt="" />
                            <div class="p-3 h-36">
                                <p class="tracking-tight text-gray-900 font-medium text-sm"><?= $row->pengarang ?></p>
                                <h5 class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white"><?= $row->nama_buku ?></h5>
                            </div>
                            <div class="absolute bottom-2 w-full px-3">
                                <?php if (cek_peminjaman_konfirmasi_kembali($row->id_buku, $this->session->userdata('nis')) != 0) : ?>
                                    <button class=" w-full px-3 py-2 text-xs sm:text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" disabled>Sedang Dipinjam</button>
                                <?php elseif (jumlah_buku_tersedia($row->id_buku) == 0) : ?>
                                    <button class=" w-full px-3 py-2 text-xs sm:text-sm font-medium text-center text-white bg-gray-500 rounded-lg hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800" disabled>Tidak Tersedia</button>
                                <?php else : ?>
                                    <input type="text" value="<?= $this->session->userdata('nis') ?>" id="nis" class="hidden">
                                    <button onclick="pinjam(<?= $row->id_buku ?>)" class="w-full px-3 py-2 text-xs sm:text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800">Pinjam</button>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="flex justify-center items-center mt-12">
                <a href="<?= base_url('member/kategori_buku') ?>" class="ms-3 text-gray-500 bg-white hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Lihat Lebih Banyak</a>
            </div>
        </div> -->
    </div>

    <?php $this->load->view('style/body') ?>

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
    </script>
</body>

</html>