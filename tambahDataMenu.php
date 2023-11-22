<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai input dari form
    $menuTop = $_POST['menuTop'];

    // Buat array asosiatif dengan nilai yang diambil
    $data = array(
        'menu_utama' => $menuTop
    );

    // Konversi array ke JSON
    $json = json_encode($data);

    // Lokasi file JSON yang akan disimpan
    $file = './assets/json/test.json';

    // Simpan data JSON ke dalam file
    file_put_contents($file, $json);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.ico">
    <title>Tambah Data Menu - Project Kelompok 3</title>
    <!-- Style -->
    <link rel="stylesheet" href="./assets/css/foodhub.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-putihMiaw">

    <div class="container font-rubik">
        <main>
            <section class="tambahDataMenu">
                <div class="relative bg-hitamMiaw">
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-bold text-putihMiaw">Masukan menu Utama</h3>
                        <form class="space-y-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <!-- Menu Utama -->
                            <div>
                                <label for="menuTop" class="block mb-2 text-sm font-medium text-putihMiaw">Nama Menu
                                    Utama</label>
                                <input type="text" id="menuTop" name="menuTop"
                                    class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5"
                                    placeholder="Bakso Malang Pak Beno" required>
                            </div>
                            <div>
                                <label for="deskripsiMenu"
                                    class="block mb-2 text-sm font-medium text-putihMiaw">Deskripsi
                                    Menu Utama</label>
                                <input type="text" id="deskripsiMenu" name="deskripsiMenu"
                                    class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5"
                                    required>
                            </div>
                            <div class="w-full">
                                <label for="hargaMenu" class="block mb-2 text-sm font-medium text-putihMiaw">Harga Menu
                                    Utama</label>
                                <input type="text" id="hargaMenu" name="hargaMenu"
                                    class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full pl-2.5"
                                    required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-putihMiaw" for="gambarMenu">Gambar
                                    Menu Utama</label>
                                <input
                                    class="mb-6 block w-full text-sm text-putihMiaw border border-gray-300 rounded-lg cursor-pointer bg-gray-600 dark:text-gray-400 focus:outline-none dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="gambarMenu" type="file">
                            </div>
                            <div>
                                <label for="alamatToko" class="block mb-2 text-sm font-medium text-putihMiaw">Alamat
                                    Toko</label>
                                <input type="text" id="alamatToko" name="alamatToko"
                                    class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5"
                                    required>
                            </div>
                            <!-- Menu Detail -->
                            <div class="border-t-8 border-biruMiaw1">
                                <h3 class="mb-4 mt-5 text-xl font-bold text-putihMiaw">Masukan menu Detail</h3>
                                <div>
                                    <label for="menuDetail1"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Menu
                                        1</label>
                                    <input type="text" id="menuDetail1" name="menuDetail1"
                                        class="bg-gray-600 mb-2 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div>
                                    <label for="deskripsiMenu"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Harga
                                        Menu</label>
                                    <input type="text" id="deskripsiMenu1" name="deskripsiMenu"
                                        class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div class="pt-5">
                                    <label for="menuDetail2"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Menu
                                        2</label>
                                    <input type="text" id="menuDetail2" name="menuDetail2"
                                        class="bg-gray-600 mb-2 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div>
                                    <label for="deskripsiMenu"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Harga
                                        Menu</label>
                                    <input type="text" id="deskripsiMenu2" name="deskripsiMenu"
                                        class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div class="pt-5">
                                    <label for="menuDetail3"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Menu
                                        3</label>
                                    <input type="text" id="menuDetail3" name="menuDetail3"
                                        class="bg-gray-600 mb-2 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div class="border-b-8 border-biruMiaw1 pb-5">
                                    <label for="deskripsiMenu"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Harga
                                        Menu</label>
                                    <input type="text" id="deskripsiMenu3" name="deskripsiMenu"
                                        class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                            </div>
                            <!-- Konektifitas -->
                            <div class="flex flex-col md:flex-row md:space-x-4">
                                <div class="flex-1">
                                    <label for="nomerTelepon" class="block mb-2 text-sm font-medium text-putihMiaw">Nomer Telepon</label>
                                    <input type="text" id="nomerTelepon" name="nomerTelepon" class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div class="flex-1">
                                    <label for="sosialMedia" class="block mt-5 md:mt-0 mb-2 text-sm font-medium text-putihMiaw">Sosial Media</label>
                                    <input type="text" id="sosialMedia" name="sosialMedia" class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5" placeholder="https://instagram.com/@benoBakso/">
                                </div>
                                <div class="flex-1">
                                    <label for="websiteToko" class="block mt-5 md:mt-0 mb-2 text-sm font-medium text-putihMiaw">Website</label>
                                    <input type="text" id="websiteToko" name="websiteToko" class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5" placeholder="https://tokobaksobeno.com/">
                                </div>
                            </div>
                            <div class="flex justify-center items-center sm:flex-row sm:justify-end sm:items-end">
                                <a href="./kulinerSemarang.html" class="mr-2 text-black bg-biruMiaw hover:bg-blue-300 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Kembali</a>
                                <button type="submit" value="InputData" class="ml-2 text-black bg-biruMiaw hover:bg-blue-300 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!-- Script -->
    <script src="./assets/js/tailwind.config.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
</body>

</html>