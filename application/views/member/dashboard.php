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
    <div class="mt-12 bg-gradient-to-b from-second to-white h-screen flex flex-col-reverse md:flex-row md:gap-32 px-5 md:px-12 items-center">
        <div class="">
            <div class="py-8 px-4 mx-auto max-w-screen-xl text-left lg:py-16 z-10 relative">
                <p class="mb-8 text-base font-normal text-gray-500 lg:text-xl dark:text-gray-200"><span class="text-4xl md:text-6xl font-extrabold tracking-tight leading-none">"Perpustakaan</span> menyimpan energi yang memicu imajinasi. Perpustakaan membuka jendela ke dunia dan menginspirasi kita untuk mengeksplorasi dan mencapai, dan berkontribusi untuk meningkatkan kualitas hidup kita." <span class="font-semibold">- Sidney Sheldon</span></p>
            </div>
        </div>
        <div id="indicators-carousel" class="relative w-52 md:w-full" data-carousel="static">
            <div class="relative h-56 overflow-hidden rounded-lg md:h-[26rem] ">
                <?php $id = 0;
                foreach ($books as $row) : $id++ ?>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item="<?= $id ?>">
                        <img src="<?= base_url('assets/buku/' . $row->foto) ?>" class="absolute block h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                    </div>
                <?php endforeach ?>
            </div>

            <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
                <?php for ($i = 0; $i < count($books); $i++) : ?>
                    <button type="button" class="w-3 h-3 rounded-full <?= $i === 0 ? 'bg-white dark:bg-gray-800' : 'bg-white/30 dark:bg-gray-800/30' ?>" aria-current="<?= $i === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $i + 1 ?>" data-carousel-slide-to="<?= $i ?>"></button>
                <?php endfor ?>
            </div>
        </div>
    </div>
    <div class="px-3 md:px-12">
        <h1 class="text-2xl font-medium tracking-tight leading-none text-gray-900 md:text-3xl lg:text-5xl">Rekomendasi L'Binusa</h1>
        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="mx-4 md:hidden text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800" type="button">Kategori Buku
        </button>
        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 ">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <?php foreach ($kategori as $row) : ?>
                    <li class="px-5 py-2 hover:bg-gray-100">
                        <button class="flex items-center rounded-lg group kategori<?= $row->id_kategori ?>" onclick="kategori(<?= $row->id_kategori ?>)">
                            <?= $row->nama_kategori ?>
                        </button>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>

        <div class="flex my-12">
            <div class="border-r-2 hidden md:block mr-8">
                <ul class="space-y-2 font-medium w-48">
                    <?php foreach ($kategori as $row) : ?>
                        <li>
                            <button class="flex items-center p-2 rounded-lg group kategori<?= $row->id_kategori ?>" onclick="kategori(<?= $row->id_kategori ?>)">
                                <?= $row->nama_kategori ?>
                            </button>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-5 test">
                    <?php foreach ($buku as $row) : ?>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-xl dark:bg-gray-800 dark:border-gray-700 relative">
                            <img class="rounded-t-lg w-full h-56" src="<?= base_url('assets/buku/' . $row->foto) ?>" alt="" />
                            <div class="p-2 h-32 md:h-40">
                                <p class="font-medium text-xs md:text-sm text-gray-700 mb-2"><?= $row->pengarang ?></p>
                                <p class="font-semibold text-sm md:text-base"><?= $row->nama_buku ?></p>
                            </div>
                            <?php if (jumlah_buku_tersedia($row->id_buku) == 0) : ?>
                                <button class="absolute bottom-2 mx-2 w-[90%] items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-500 rounded-lg hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-sky-800" disabled>
                                    Tidak Tersedia
                                </button>
                            <?php elseif (cek_peminjaman_konfirmasi_kembali($row->id_buku, $this->session->userdata('nis')) != 0) : ?>
                                <button class="absolute bottom-2 mx-2 w-[90%] items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" disabled>
                                    Sedang Dipinjam
                                </button>
                            <?php else : ?>
                                <button class="absolute bottom-2 mx-2 w-[90%] items-center px-3 py-2 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800" onclick='pinjam(<?php echo $row->id_buku ?>)'>
                                    Pinjam
                                </button>
                                <input type="text" value="<?= $this->session->userdata('nis') ?>" id="nis" class="hidden">
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('style/body') ?>
    <script>
        function kategori(id) {
            selectedId = id;
            console.log("Clicked button with ID:", selectedId);
            $.ajax({
                url: '<?php echo base_url('member/data_buku') ?>',
                method: 'POST',
                data: {
                    id: selectedId
                },
                success: function(response) {
                    $('.test').html(response)
                }
            });
        }

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
                    console.log(data);
                    window.location.reload();
                }
            });
        }
    </script>
</body>

</html>