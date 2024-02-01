<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Binusa</title>
    <?php $this->load->view('style/head') ?>
</head>

<body>
    <section class="grid grid-cols-1 sm:grid-cols-3 font-popins">
        <div class="col-span-2 bg-second hidden sm:block">
            <img src="<?php echo base_url('assets/image/book.jpg') ?>" alt="login" class="mx-auto h-screen">
        </div>
        <div class="col-span-1 flex items-center justify-center">
            <div class="mt-24 sm:mt-0">
                <h1 class="text-center text-4xl text-primary"><b>L'Binusa</b></h1>
                <form action="<?php echo base_url('login/aksi_login_admin') ?>" method="POST" class="mb-4 mt-12">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                    <div class="relative mb-4">
                        <div class="absolute bottom-2 left-3">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <input type="text" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan username">
                    </div>
                    <div class="relative">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="password" id="password" placeholder="***" required>
                        <div class="absolute bottom-2 left-3">
                            <i class="fas fa-eye-slash" onclick="togglePassword()" id="icon"></i>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="text-white bg-primary hover:bg-sky-600 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full w-full text-sm px-5 py-2.5 text-center me-2 mb-2">Masuk</button>
                    </div>
                </form>
                <!-- <p class="text-sm text-gray-900 font-medium">Belum punya akun? Silahkan <a href="<?php echo base_url('register') ?>" class="underline text-primary">Daftar</a></p> -->
            </div>
        </div>
    </section>
    <?php $this->load->view('style/body') ?>
    <script>
        function togglePassword() {
            var passwordType = document.getElementById("password");
            var icon = document.getElementById("icon");
            if (passwordType.type === "password") {
                passwordType.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordType.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>

    <!-- SWEETALERT -->
    <?php if ($this->session->flashdata('error_message')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Masuk!',
                text: '<?= $this->session->flashdata('error_message') ?>',
                showConfirmButton: false,
                timer: 1500,
            });
        </script>
    <?php endif; ?>
    <!-- END SWEETALERT -->
</body>

</html>