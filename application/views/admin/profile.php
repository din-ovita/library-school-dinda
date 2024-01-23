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
    <?php $this->load->view('style/sidebar') ?>
    <div class="p-4 sm:ml-64 bg-gray-100 min-h-screen font-popins">
        <div class="flex justify-between">
            <h1 class="text-xl font-semibold">Profile</h1>
            <ul class="flex gap-2 sm:text-base text-sm">
                <li class=""> Profile</li>
            </ul>
        </div>
        <div class="bg-white p-5 mt-5 grid mx-auto grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($user as $row) : ?>
                <div>
                    <?php if ($row->foto == '') : ?>
                        <img class="w-full" src="<?= base_url('assets/image/profile.jpg') ?>" alt="user photo">
                    <?php else : ?>
                        <img class="w-full" src="<?= base_url('assets/member/') . $row->foto ?>" alt="user photo">
                    <?php endif ?>
                </div>
                <form action="">
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
                            <input type="text" name="konfirm_pass" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Konfirmasi Password Baru">
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
</body>

</html>