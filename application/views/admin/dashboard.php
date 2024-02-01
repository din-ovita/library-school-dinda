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
    .chart-canvas {
        width: 200px;
        /* Set the desired width */
        height: 200px;
        /* Set the desired height */
    }
</style>

<body class="h-screen">
    <?php $this->load->view('style/sidebar') ?>
    <div class="p-4 sm:ml-64 bg-gray-50 min-h-screen font-popins">
        <div class="bg-sky-200 shadow-lg mt-6 md:mt-12 h-32 md:h-40 p-2 md:p-5 rounded items-center w-full flex justify-between overflow-visible">
            <div>
                <?php foreach ($user as $row) : ?>
                    <h1 class="font-bold text-xl md:text-4xl">Hi, <?= $row->username ?></h1>
                    <p class="md:text-base text-xs">Bersiap untuk atur data perpustakaan!</p>
                <?php endforeach ?>
            </div>
            <img src="<?= base_url('assets/image/book4.png') ?>" alt="" class="h-48 md:h-72 z-20 mb-16 md:mb-28">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">
            <div class="flex items-center justify-between h-28 rounded bg-white shadow-lg p-3">
                <div>
                    <p class="font-medium"> Total Rak</p>
                    <p class="text-2xl font-semibold mt-4"><?= jumlah_rak() ?></p>
                </div>
                <div class="rounded-primary bg-primary p-5 text-white">
                    <i class="text-3xl fas fa-table"></i>
                </div>
            </div>
            <div class="flex items-center justify-between h-28 rounded bg-white shadow-lg p-3">
                <div>
                    <p class="font-medium"> Total Kategori</p>
                    <p class="text-2xl font-semibold mt-4"><?= jumlah_kategori() ?></p>
                </div>
                <div class="rounded-primary bg-primary p-5 text-white">
                    <i class="text-3xl fas fa-list"></i>
                </div>
            </div>
            <div class="flex items-center justify-between h-28 rounded bg-white shadow-lg p-3">
                <div>
                    <p class="font-medium"> Total Judul Buku</p>
                    <p class="text-2xl font-semibold mt-4"><?= jumlah_judul_buku() ?></p>
                </div>
                <div class="rounded-primary bg-primary p-5 text-white">
                    <i class="text-3xl fas fa-book"></i>
                </div>
            </div>
        </div>
        <div class="my-4">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <?php $this->load->view('style/body') ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myChart');

            const labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Data Peminjaman',
                    data: [<?php echo $jan ?>, <?php echo $feb ?>, <?php echo $maret ?>, <?php echo $april ?>, <?php echo $mei ?>, <?php echo $juni ?>, <?php echo $juli ?>, <?php echo $agustus ?>, <?php echo $september ?>, <?php echo $oktober ?>, <?php echo $november ?>, <?php echo $desember ?>],
                    backgroundColor: [
                        '#0ea5e9'
                    ],
                    borderColor: [
                        '#0ea5e9'
                    ],
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            };

            new Chart(ctx, config);

            console.log(config);
        });
    </script>
</body>

</html>