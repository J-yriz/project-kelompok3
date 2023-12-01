<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai input dari form
    $menuTop = $_POST['menuTop'];
    $hargaDetail = $_POST['hargaDetail'];
    $hargaMenu = $_POST['hargaMenu'];

    // Pastikan input file ada
    if (isset($_FILES["gambarMenu"])) {
        $file = $_FILES["gambarMenu"];

        // Detail file
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];

        // Memeriksa ekstensi file
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png");

        if (in_array($fileExt, $allowedExtensions)) {
            // Memeriksa apakah tidak ada error saat upload
            if ($fileError === 0) {
                // Memeriksa ukuran file (dalam bytes)
                $maxFileSize = 15 * 1024 * 1024; // 15MB dalam bytes
                if ($fileSize <= $maxFileSize) {
                    // Memeriksa jumlah file yang sudah ada di folder
                    $filesInFolder = glob('./assets/images/menu/*'); // Mendapatkan daftar file di folder
                    $numberOfFiles = count($filesInFolder); // Menghitung jumlah file

                    // Membuat nama baru untuk file yang akan diunggah
                    $newFileName = "menu" . ($numberOfFiles + 1) . "." . $fileExt;
                    $destination = './assets/images/menu/' . $newFileName;

                    // Memindahkan file ke folder 'image' dengan nama baru
                    move_uploaded_file($fileTmpName, $destination);
                } else {
                    echo "<script>alert('Ukuran file gambar terlalu besar. Maksimum 15MB.')</script>";
                }
            } else {
                echo "<script>alert('Terjadi kesalahan saat mengunggah file gambar.')</script>";
            }
        } elseif (empty($fileExt) || $fileError === 4) {
            $newFileName = "";
        } else {
            echo "<script>alert('Hanya file gambar dengan ekstensi JPG, JPEG, PNG, atau GIF yang diperbolehkan.')</script>";
        }
    }

    $detail = array(
        "alamat" => $_POST['alamatToko'],
        "telepon" => $_POST['nomerTelepon'],
        "linkWebsite" => $_POST['websiteToko'],
        "goFood" => $_POST['goFood'],
        "menu1" => $_POST['menuDetail1'],
        "menu2" => $_POST['menuDetail2'],
        "menu3" => $_POST['menuDetail3'],
        "harga1" => $_POST['hargaDetail1'],
        "harga2" => $_POST['hargaDetail2'],
        "harga3" => $_POST['hargaDetail3']
    );

    // Buat array asosiatif dengan nilai yang diambil
    $data = array(
        'id' => generateRandomID(),
        'gambar' => $newFileName,
        'namaProduk' => $menuTop,
        'namaProduk1' => $menuTop,
        'keterangan' => $hargaDetail,
        'harga' => $hargaMenu,
        'bintang' => 0,
        'detail' => $detail
    );

    // Cek apakah ada data yang kosong
    $requiredFields = [
        'Menu Top' => $menuTop,
        'Harga Detail' => $hargaDetail,
        'Harga Menu' => $hargaMenu,
        'Alamat' => $detail['alamat'],
        'Menu 1' => $detail['menu1'],
        'Menu 2' => $detail['menu2'],
        'Menu 3' => $detail['menu3'],
        'Harga Menu 1' => $detail['harga1'],
        'Harga Menu 2' => $detail['harga2'],
        'Harga Menu 3' => $detail['harga3'],
        'Gambar' => $newFileName
    ];

    $emptyFields = [];
    foreach ($requiredFields as $fieldName => $fieldValue) {
        if (empty($fieldValue)) {
            $emptyFields[] = $fieldName;
        }
        if (empty($detail['linkWebsite'])) {
            $detail['linkWebsite'] = "";
        }
        if (empty($detail['goFood'])) {
            $detail['goFood'] = "";
        }
        if (empty($detail['telepon'])) {
            $detail['telepon'] = "";
        }
        
    }

    if (!empty($emptyFields) || $newFileName === "") {
        $errorMessage = "Data kosong: " . implode(", ", $emptyFields);
        echo "<script>alert('$errorMessage.')</script>";
        echo "<script>window.history.back();</script>";
        exit(); // Menghentikan proses jika ada data yang kosong
    }

    // Lokasi file JSON yang akan disimpan
    $file = './assets/json/data.json';

    // Membaca data dari file JSON yang sudah ada
    $currentData = file_get_contents($file);

    // Mengubah data JSON menjadi array PHP
    $currentDataArray = json_decode($currentData, true);

    // Fungsi untuk memeriksa apakah ID sudah ada
    function isIdExists($id, $data)
    {
        foreach ($data as $item) {
            if ($item['id'] == $id) {
                return true;
            }
        }
        return false;
    }

    // Pengecekan apakah ID sudah ada dalam data yang ada
    while (isIdExists($data['id'], $currentDataArray)) {
        $data['id'] = generateRandomID(); // Jika ID sudah ada, generate ID baru
    }

    // Menambahkan data baru ke dalam array
    $currentDataArray[] = $data;

    // Mengubah array PHP menjadi format JSON
    $newJsonData = json_encode($currentDataArray, JSON_PRETTY_PRINT);

    // Menyimpan data ke dalam file JSON
    file_put_contents($file, $newJsonData);
    echo "<script>window.location.href = './kulinerSemarang.php?rand=" . rand() . "';</script>";
}

function generateRandomID()
{
    // Menghasilkan ID integer dengan panjang 6 digit
    return rand(100000, 999999);
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
                        <form class="space-y-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            method="post" enctype="multipart/form-data">
                            <!-- Menu Utama -->
                            <div>
                                <label for="menuTop" class="block mb-2 text-sm font-medium text-putihMiaw">Nama Menu
                                    Utama</label>
                                <input type="text" id="menuTop" name="menuTop"
                                    class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5"
                                    placeholder="Bakso Malang Pak Beno" required>
                            </div>
                            <div>
                                <label for="hargaDetail" class="block mb-2 text-sm font-medium text-putihMiaw">Deskripsi
                                    Menu Utama</label>
                                <input type="text" id="hargaDetail" name="hargaDetail"
                                    class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5"
                                    placeholder="Bakso Urat dengan cita rasa yang kuat" required>
                            </div>
                            <div class="w-full">
                                <label for="hargaMenu" class="block mb-2 text-sm font-medium text-putihMiaw">Harga Menu
                                    Utama</label>
                                <input type="text" id="hargaMenu" name="hargaMenu"
                                    class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full pl-2.5"
                                    placeholder="50000" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-putihMiaw" for="gambarMenu">Gambar
                                    Menu Utama</label>
                                <input
                                    class="mb-6 block w-full text-sm text-putihMiaw border border-gray-300 rounded-lg cursor-pointer bg-gray-600 dark:text-gray-400 focus:outline-none dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="gambarMenu" type="file" name="gambarMenu" accept=".jpg, .jpeg, .png">
                            </div>
                            <div>
                                <label for="alamatToko" class="block mb-2 text-sm font-medium text-putihMiaw">Alamat
                                    Toko</label>
                                <input type="text" id="alamatToko" name="alamatToko"
                                    class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5"
                                    placeholder="Jl. Sukabumi no.1 Semarang Utara" required>
                            </div>
                            <!-- Menu Detail -->
                            <div class="border-t-8 border-biruMiaw1">
                                <h3 class="mb-4 mt-5 text-xl font-bold text-putihMiaw">Masukan menu Detail</h3>
                                <div>
                                    <label for="menuDetail1" class="block mb-2 text-sm font-medium text-putihMiaw">Menu
                                        1</label>
                                    <input type="text" id="menuDetail1" name="menuDetail1"
                                        class="bg-gray-600 mb-2 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div>
                                    <label for="hargaDetail1"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Harga
                                        Menu</label>
                                    <input type="text" id="hargaDetail1" name="hargaDetail1"
                                        class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div class="pt-5">
                                    <label for="menuDetail2" class="block mb-2 text-sm font-medium text-putihMiaw">Menu
                                        2</label>
                                    <input type="text" id="menuDetail2" name="menuDetail2"
                                        class="bg-gray-600 mb-2 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div>
                                    <label for="hargaDetail2"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Harga
                                        Menu</label>
                                    <input type="text" id="hargaDetail2" name="hargaDetail2"
                                        class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div class="pt-5">
                                    <label for="menuDetail3" class="block mb-2 text-sm font-medium text-putihMiaw">Menu
                                        3</label>
                                    <input type="text" id="menuDetail3" name="menuDetail3"
                                        class="bg-gray-600 mb-2 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div class="border-b-8 border-biruMiaw1 pb-5">
                                    <label for="hargaDetail3"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Harga
                                        Menu</label>
                                    <input type="text" id="hargaDetail3" name="hargaDetail3"
                                        class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                            </div>
                            <!-- Konektifitas -->
                            <div class="flex flex-col md:flex-row md:space-x-4">
                                <div class="flex-1">
                                    <label for="nomerTelepon"
                                        class="block mb-2 text-sm font-medium text-putihMiaw">Nomer Telepon</label>
                                    <input type="text" id="nomerTelepon" name="nomerTelepon"
                                        class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5">
                                </div>
                                <div class="flex-1">
                                    <label for="goFood"
                                        class="block mt-5 md:mt-0 mb-2 text-sm font-medium text-putihMiaw">GoFood</label>
                                    <input type="text" id="goFood" name="goFood"
                                        class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5"
                                        placeholder="https://gofood.co.id/semarang/restaurant/benoBakso/">
                                </div>
                                <div class="flex-1">
                                    <label for="websiteToko"
                                        class="block mt-5 md:mt-0 mb-2 text-sm font-medium text-putihMiaw">Website</label>
                                    <input type="text" id="websiteToko" name="websiteToko"
                                        class="bg-gray-600 text-putihMiaw text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full px-2.5"
                                        placeholder="https://tokobaksobeno.com/">
                                </div>
                            </div>
                            <div class="flex justify-center items-center sm:flex-row sm:justify-end sm:items-end">
                                <a href="./kulinerSemarang.php"
                                    class="mr-2 text-black bg-biruMiaw hover:bg-blue-300 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Kembali</a>
                                <button type="submit" value="InputData"
                                    class="ml-2 text-black bg-biruMiaw hover:bg-blue-300 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah
                                    Data</button>
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