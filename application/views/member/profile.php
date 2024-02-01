<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Binusa</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php $this->load->view('style/head') ?>
</head>

<body>
    <?php $this->load->view('style/sidebar_member') ?>
    <div class="p-4 sm:ml-64 bg-gray-50 min-h-screen font-popins">
    <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?= base_url('member') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        <i class="text-lg fas fa-chart-pie"></i>
                        <span class="ml-2">Dashboard</span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#" class="text-sm font-medium text-gray-500 dark:text-gray-400 dark:hover:text-white">Profile</a>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white shadow-lg rounded p-5 mt-5 grid mx-auto grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($user as $row) : ?>
                <div>
                    <?php if ($row->foto == '') : ?>
                        <img class="w-full" src="<?= base_url('assets/image/profile.jpg') ?>" alt="user photo">
                    <?php else : ?>
                        <img class="w-full" src="<?= base_url('assets/member/') . $row->foto ?>" alt="user photo">
                    <?php endif ?>
                </div>
                <form action="<?= base_url('member/aksi_update_profile') ?>" method="POST" enctype="multipart/form-data">
                    <input type="text" value="<?= $row->id_level ?>" class="hidden" name="id_level">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                        <div class="mb-4">
                            <input type="text" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Username" value="<?= $row->username ?>">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Baru</label>
                        <div class="mb-4">
                            <input type="text" name="new_pass" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Password Baru">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password Baru</label>
                        <div class="mb-4">
                            <input type="text" name="confirm_pass" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Konfirmasi Password Baru">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto</label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="foto" onchange="readURL(this);">
                        <div class="grid grid-cols-2 mt-2">
                            <div>
                                <div>Foto Sebelum :</div>
                                <img src="<?php $data = $row->foto == null ? base_url('assets/image/profile.jpg') : base_url('assets/member/') . "/" . $row->foto;
                                            echo $data ?>" width="140" />
                            </div>
                            <div>
                                <div>Foto Sesudah :</div>
                                <img id="blah" name="foto" width="140" />
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="flex justify-end">
                        <button class="text-white bg-primary hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-sky-600 rounded-lg" type="submit">Update Profile</button>
                    </div>
                </form>
            <?php endforeach ?>
        </div>
    </div>
    <?php $this->load->view('style/body') ?>
    <script>
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

    <!-- SWEETALERT -->
    <?php if ($this->session->flashdata('successEditMember')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $this->session->flashdata('successEditMember') ?>',
                showConfirmButton: false,
                timer: 1500,
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('errorNewPassMember')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= $this->session->flashdata('errorNewPassMember') ?>',
                showConfirmButton: false,
                timer: 1500,
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('errorConfirmPassMember')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= $this->session->flashdata('errorConfirmPassMember') ?>',
                showConfirmButton: false,
                timer: 1500,
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('errorEditMember')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= $this->session->flashdata('errorEditMember') ?>',
                showConfirmButton: false,
                timer: 1500,
            });
        </script>
    <?php endif; ?>
    <!-- END SWEETALERT -->

</body>

</html>