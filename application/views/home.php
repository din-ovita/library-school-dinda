<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>L'Binusa</title>
  <?php $this->load->view('style/head') ?>
</head>

<body class="font-popins">
  <div class="min-h-screen bg-second">
    <nav class=" w-full z-20 top-0 start-0">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="<?= base_url('home') ?>" class="flex items-center space-x-3 rtl:space-x-reverse">
          <span class="self-center text-2xl font-semibold whitespace-nowrap text-primary">L'Binusa</span>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
          <a href="<?= base_url('login') ?>" class="text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-4 py-2 text-center  dark:focus:ring-sky-800">Masuk</a>
        </div>
      </div>
    </nav>
    <div class="flex flex-col md:flex-row items-center md:px-12 px-5">
      <div>
        <img src="<?= base_url('assets/image/book3.png') ?>" alt="" class="w-full md:w-8/12">
      </div>
      <div>
        <div class="py-8 mx-auto max-w-screen-xl text-center md:text-right lg:py-16">
          <h1 class="mb-4 text-3xl sm:text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl">
            Perpustakaan SMK Bina Nusantara SMG
          </h1>
          <p class="mb-8 text-base md:text-lg font-normal text-gray-500 lg:text-xl ">
            Tempat dimana pengetahuan ada. <br> Buka jendela dunia kalian dengan membaca buku.
          </p>
        </div>
      </div>
    </div>
  </div>
  <?php $this->load->view('style/body') ?>
</body>

</html>