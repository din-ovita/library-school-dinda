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
                                    Pinjam
                                </button>
                            <?php else : ?>
                                <button class="absolute bottom-2 mx-2 w-[90%] items-center px-3 py-2 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800" data-modal-target="default-modal2" data-modal-toggle="default-modal2" onclick='tampilId(<?php echo $row->id_buku ?>)'>
                                    Pinjam
                                </button>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <div id="default-modal2" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden mx-auto fixed top-0 right-0 left-0 z-50 justify-center items-center w-full sm:w-1/2 md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Peminjaman <span id="judul_buku"></span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal2">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                m
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form onsubmit="pinjam(event)" method="post" class="p-4 md:p-5 space-y-4">
                        <input type="text" name="buku" id="buku" class="hidden">
                        <input type="text" id="nis" value="<?= nisMember_byIdLevel($this->session->userdata('id')) ?>" class="hidden">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
                        <div class="mb-4">
                            <input type="number" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan jumlah buku yang akan di pinjam ...">
                        </div>
                        <p class="text-sm mt-2" id="batas_jml"></p>
                        <div class="flex items-center border-t pt-4 border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" id="button" class="text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-primary dark:focus:ring-sky-600">Pinjam</button>
                            <button data-modal-hide="default-modal2" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                        </div>
                    </form>
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

        let buku = $('#buku');
        let jumlah = $('#jumlah');
        let nis = $('#nis');
        let judul_buku = $('#judul_buku');
        let id = null;

        function tampilId(id) {
            id = id;
            buku.val(id);
            $.ajax({
                url: '<?php echo base_url('member/judul_buku') ?>',
                method: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    judul_buku.html(response)
                }
            });
        }

        function pinjam(e) {
            e.preventDefault();
            console.log('test');
            $.ajax({
                url: '<?= base_url(); ?>member/pinjam_buku',
                method: 'POST',
                data: {
                    id: buku.val(),
                    jumlah: jumlah.val(),
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

        jumlah.change(function() {
            $.ajax({
                url: '<?php echo base_url('member/jumlah_buku') ?>',
                method: 'POST',
                data: {
                    id_buku: buku.val()
                },
                success: function(response) {
                    console.log(response);
                    $('#jumlah_buku').html('Jumlah buku tersedia : ' + response);
                    let jml = response;
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
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    </script>
</body>

</html>