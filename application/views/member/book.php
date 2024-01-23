<!-- <?php foreach ($buku2 as $row) : ?>
    <div class="bg-white border border-gray-200 rounded-lg shadow-xl dark:bg-gray-800 dark:border-gray-700">
        <img class="rounded-t-lg w-full h-56" src="<?= base_url('assets/buku/' . $row->foto) ?>" alt="" />
        <div class="p-2 md:p-5">
            <h5 class="mb-2 text-lg md:text-2xl font-bold tracking-tight text-gray-900 "><?= $row->nama_buku ?></h5>
            <?php if (jumlah_buku($row->id_buku) == 0) : ?>
                <span class="text-sm text-sky-700 bg-sky-200 p-1 rounded-md">Sedang Dipinjam</span>
            <?php else : ?>
                <span class="text-sm text-green-700 bg-green-200 p-1 rounded-md">Tersedia</span>
            <?php endif ?>
            <p class="my-3 text-sm md:text-base font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
            <button class=" w-full items-center px-3 py-2 text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800">
                Pinjam </button>
        </div>
    </div>
<?php endforeach ?> -->