<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin'])) {
  // Jika belum login, redirect ke halaman login
  header("Location: ./index.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['namaUlasan'];
  $menuMakanan = $_POST['menuMakanan'];
  $rating = intval($_POST['ratingUlasan']);
  $description = $_POST['descriptionUlasan'];

  // Mengambil ID dari Data Menu
  $dataJSON = file_get_contents('./assets/json/data.json');
  $dataArray = json_decode($dataJSON, true);
  $id = getIdByProductName($dataArray, $menuMakanan);

  $data = array(
    'bintang' => $rating,
    'komentar' => $description,
    'nama' => $nama,
    'namaMakanan' => $menuMakanan,
    'id' => $id
  );

  // Menambahkan Data Komentar menjadi JSON
  $file = './assets/json/dataKomentar.json';
  $currentData = file_get_contents($file);
  $currentDataArray = json_decode($currentData, true);
  $currentDataArray[] = $data;
  $newJsonData = json_encode($currentDataArray, JSON_PRETTY_PRINT);
  file_put_contents($file, $newJsonData);
  echo "<script>window.location.href = './kulinerSemarang.php';</script>";
}

// Ambil data 'id' berdasarkan 'namaProduk'
function getIdByProductName($dataArray, $productName)
{
  $productName = strtolower($productName);
  foreach ($dataArray as $item) {
    $itemProductName = strtolower($item['namaProduk']);
    if ($itemProductName === $productName) {
      return $item['id'];
    }
  }
  return null;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="./assets/images/favicon.ico" />
  <title>Kuliner Semarang - Project Kelompok 3</title>

  <!--
    - custom css link 
  -->
  <link rel="stylesheet" href="./assets/css/foodhub.css" />
  <link rel="stylesheet" href="./assets/css/media_query.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <!--
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Monoton&family=Rubik:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
</head>

<body class="bg-putihMiaw dark:bg-hitamMiaw">
  <!--
    - main container
  -->

  <div class="container bg-putihMiaw dark:bg-hitamMiaw font-rubik">
    <!--
      - #HEADER
    -->

    <header>
      <nav class="navbar">
        <div class="navbar-wrapper">
          <a href="#">
            <img src="./assets/images/KulinerSemarang.png" alt="logo" width="150" />
          </a>

          <ul class="navbar-nav">
            <li>
              <a href="#home" class="nav-link">Home</a>
            </li>

            <li>
              <a href="#about" class="nav-link">Tentang</a>
              <!-- Tentang -->
            </li>

            <li>
              <a href="#menu" class="nav-link">Menu Kuliner</a>
              <!-- Menu -->
            </li>

            <li>
              <a href="#testimonials" class="nav-link">Ulasan</a>
              <!-- UlasanTestimonials -->
            </li>
          </ul>

          <div class="navbar-btn-group">
            <button class="menu-toggle-btn">
              <span class="line one"></span>
              <span class="line two"></span>
              <span class="line three"></span>
            </button>
          </div>
        </div>
      </nav>

      <div class="cart-box">
        <ul class="cart-box-ul">
          <h4 class="cart-h4">Your order.</h4>

          <li>
            <a href="#" class="cart-item">
              <div class="img-box">
                <img src="./assets/images/menu5.jpg" alt="product image" class="product-img" width="50" height="50"
                  loading="lazy" />
              </div>

              <h5 class="product-name">Sea bream carpaccio</h5>
              <p class="product-price"><span class="small">$</span>19</p>
            </a>
          </li>
        </ul>
      </div>
    </header>

    <main>
      <!--
        - #HOME SECTION
      -->

      <section class="home" id="home">
        <div class="home-left">
          <h1 class="main-heading text-spaceCadet dark:text-putihMiaw">
            Cari berbagai Kuliner yang ada di Kota Semarang
          </h1>

          <div class="btn-group">
            <a href="#menu">
              <button class="btn btn-primary btn-icon">
                <img src="./assets/images/menu.svg" alt="menu icon" />
                Menu Kuliner
              </button>
            </a>

            <a href="#about">
              <button class="btn btn-secondary btn-icon">
                <img src="./assets/images/arrow.svg" alt="menu icon" />
                Tentang
              </button>
            </a>
          </div>
        </div>

        <div class="home-right">
          <img src="./assets/images/food-1.png" alt="food image" class="food-1" width="200" loading="lazy"
            style="position: absolute; width: 80%" />
          <img src="./assets/images/food-2.png" alt="food image" class="food-2" width="200" loading="lazy"
            style="position: absolute; width: 55%" />
          <img src="./assets/images/food-3.png" alt="food image" class="food-3" width="200" loading="lazy"
            style="position: absolute; width: 55%" />

          <!-- GAMBAR HAPUS -->

          <!-- <img
              src="./assets/images/dialog-1.svg"
              alt="dialog"
              class="dialog dialog-1"
              width="230"
            />
            <img
              src="./assets/images/dialog-2.svg"
              alt="dialog"
              class="dialog dialog-2"
              width="230"
            /> -->

          <img src="./assets/images/circle.svg" alt="circle shape" class="shape shape-1" width="25" />
          <img src="./assets/images/circle.svg" alt="circle shape" class="shape shape-2" width="15" />
          <img src="./assets/images/circle.svg" alt="circle shape" class="shape shape-3" width="30" />
          <!-- <img
              src="./assets/images/ring.svg"
              alt="ring shape"
              class="shape shape-4"
              width="60"
            /> -->
          <img src="./assets/images/ring.svg" alt="ring shape" class="shape shape-5" width="40" />
        </div>
      </section>

      <!--
        - #ABOUT SECTION
      -->

      <section class="about" id="about">
        <div class="about-left">
          <div class="img-box">
            <img src="./assets/images/LawanSewu.png" alt="about image" class="about-img mySlides" width="250" />
            <img src="./assets/images/MesjidAgung.png" alt="about image" class="about-img mySlides" width="250" />
            <img src="./assets/images/SampoKong.png" alt="about image" class="about-img mySlides" width="250" />
          </div>

          <!-- <div class="abs-content-box">
              <div class="dotted-border">
                <p class="number-lg">476</p>
                <p class="text-md">Years
              </div>
            </div> -->

          <img src="./assets/images/circle.svg" alt="circle shape" class="shape shape-6" width="20" />
          <img src="./assets/images/circle.svg" alt="circle shape" class="shape shape-7" width="30" />
          <img src="./assets/images/ring.svg" alt="ring shape" class="shape shape-8" width="35" />
          <img src="./assets/images/ring.svg" alt="ring shape" class="shape shape-9" width="80" />
        </div>

        <div class="about-right">
          <h2 class="section-title">Kota Semarang</h2>

          <p class="section-text">
            Semarang adalah ibu kota Provinsi Jawa Tengah, Indonesia. Kota ini
            memiliki sejarah panjang sebagai pusat perdagangan dan pelabuhan
            penting di Pulau Jawa. Terletak di pantai utara Jawa, Semarang
            memiliki iklim tropis dengan dua musim, yaitu musim hujan dan
            musim kemarau. Kota Semarang memiliki banyak daya tarik, termasuk
            bangunan bersejarah seperti Kota Lama, yang merupakan kawasan
            dengan bangunan peninggalan kolonial Belanda. Kota ini juga
            terkenal dengan Masjid Agung Jawa Tengah yang megah dan Kuil Sam
            Poo Kong, salah satu kuil Tionghoa tertua di Indonesia.
          </p>

          <p class="section-text">
            Selain itu, Semarang juga dikenal sebagai surganya kuliner. Salah
            satu makanan khas yang tak boleh dilewatkan adalah lumpia
            Semarang, sejenis lumpia dengan isian rebung, udang, dan daging
            ayam yang disajikan dengan saus kacang khas. Selain itu, Anda
            dapat menikmati makanan laut segar di wilayah pelabuhan seperti
            Bandeng Presto, udang galah, dan kepiting saus tiram. Jangan lupa
            mencoba wingko babat, sejenis kue tradisional yang terbuat dari
            ketan dan gula kelapa yang lezat. Semarang juga memiliki banyak
            warung makan dan restoran yang menyajikan hidangan khas Jawa
            Tengah, seperti soto Semarang, nasi ayam, dan tahu gimbal. Dengan
            beragam pilihan kuliner yang menggugah selera, kota Semarang
            merupakan destinasi yang sempurna bagi pecinta makanan.
          </p>
        </div>
      </section>

      <!--
        - #PRODUCT SECTION
      -->

      <section class="product" id="menu">
        <h2 class="section-title">Menu Kuliner</h2>

        <p class="section-text">
          Beberapa menu kuliner yang ada di Kota Semarang
        </p>

        <form class="block sm:flex items-center">
          <label for="default-search"
            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-putihMiaw">Search</label>
          <div class="relative flex-grow mb-2 sm:mb-0">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
              </div>
              <input type="search" id="default-search"
                class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-biruMiaw focus:border-biruMiaw dark:bg-gray-200 dark:border-gray-100 dark:placeholder-gray-400 dark:text-hitamMiaw dark:focus:ring-biruMiaw dark:focus:border-biruMiaw"
                placeholder="Cari beberapa menu kuliner.....">
              <button type="submit"
                class="text-hitamMiaw absolute right-2.5 bottom-2.5 bg-biruMiaw hover:bg-blue-300 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-biruMiaw">Search</button>
            </div>
          </div>
          <a href="./tambahDataMenu.php"
            class="ml-0 sm:ml-3 block text-hitamMiaw bg-biruMiaw hover:bg-blue-300 focus:ring-biruMiaw focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-biruMiaw dark:hover:bg-blue-300">
            Tambah Menu
          </a>
        </form>


        <br />
        <div class="products-grid product-container"></div>
        <button class="btn btn-primary btn-icon" id="myButton">
          Full menu
        </button>
        <!-- Main modal -->
        <a type="button" data-modal-hide="modalDetailMakanan">
          <div id="modalDetailMakanan" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-3xl max-h-full">
              <!-- Modal content -->
              <div class="relative bg-biruMiaw1 rounded-lg shadow dark:bg-biruMiaw2 modalContent"></div>
            </div>
          </div>
        </a>
      </section>

      <!--
        - #TESTIMONIALS SECTION
      -->

      <section class="testimonials" id="testimonials">
        <div class="flex justify-between items-center border-b-4 rounded-lg mb-7">
          <h2 class="section-title">Ulasan</h2>
          <div class="flex justify-center items-center sm:flex-row sm:justify-end sm:items-end">
            <select id="ratingUlasan"
              class="bg-gray-50 border border-putihMiaw text-hitamMiaw text-sm rounded-lg block p-2.5 focus:ring-biruMiaw focus:border-biruMiaw dark:bg-gray-200 dark:border-gray-200 dark:placeholder-gray-400 dark:text-hitamMiaw">
              <option selected>Select food Rating</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
              class="ml-5 block text-hitamMiaw bg-biruMiaw hover:bg-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-biruMiaw dark:hover:bg-blue-300"
              type="button" id="tambahUlasan">
              Tambah Ulasan
            </button>
          </div>
        </div>

        <div class="testimonials-grid containerUlasan"></div>
      </section>

      <!-- Main modal -->
      <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
          <!-- Modal content -->
          <div class="relative bg-putihMiaw rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div
              class="flex items-center justify-between py-2 px-4 md:p-3 md:px-5 border-b rounded-t dark:border-gray-600">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-putihMiaw">
                Tambah Ulasan Menu
              </h3>
              <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-putihMiaw"
                data-modal-toggle="crud-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5 modalUlasan" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                  <label for="namaUlasan"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-putihMiaw">Nama</label>
                  <input type="text" name="namaUlasan" id="namaUlasan"
                    class="bg-gray-50 border border-putihMiaw text-gray-900 text-sm rounded-lg focus:ring-biruMiaw focus:border-biruMiaw block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-hitamMiaw dark:focus:border-hitamring-hitamMiaw"
                    placeholder="Rimuru Tempest" required="" />
                </div>
                <div class="col-span-2">
                  <div class="menuMakanan">
                  </div>
                </div>
                <div class="col-span-1">
                  <select id="ratingUlasan" name="ratingUlasan"
                    class="bg-gray-50 border border-putihMiaw text-gray-900 text-sm rounded-lg focus:ring-biruMiaw focus:border-biruMiaw block w-full py-3 px-4 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-hitamMiaw dark:focus:border-hitamMiaw">
                    <option selected>Pilih Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
                <div class="col-span-2">
                  <label for="descriptionUlasan"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-putihMiaw">Deskripsi Menu</label>
                  <textarea id="descriptionUlasan" name="descriptionUlasan" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-putihMiaw focus:ring-biruMiaw focus:border-biruMiaw dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-hitamMiaw dark:focus:border-hitamring-hitamMiaw"
                    placeholder="Tulis deskripsi menu disini."></textarea>
                </div>
              </div>
              <button type="submit"
                class="text-hitamMiaw inline-flex items-center bg-biruMiaw hover:bg-blue-300 font-medium rounded-lg text-sm pl-3 pr-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd"></path>
                </svg>
                Tambah Ulasan
              </button>
            </form>
          </div>
        </div>
      </div>
    </main>

    <!--
      - #FOOTER
    -->

    <footer class="bg-biruMiaw2">
      <div class="footer-wrapper">
        <div class="social-link">
          <a href="#">
            <img src="./assets/images/KulinerSemarang1.png" alt="logo" class="footer-brand" width="150" />
          </a>
          <a href="https://www.instagram.com/softwaregenone/" target="_blank">
            <img src="./assets/images/XIIRPL1.png" alt="logo" class="footer-brand" width="150" />
          </a>
        </div>

        <p class="copyright text-hitamMiaw font-medium">
          &copy; Copyright 2023 Kelompok 3. All Rights Reserved.
        </p>
      </div>
    </footer>
  </div>

  <!--
    - custom js link
  -->
  <script src="./assets/js/kulinerScript.js"></script>
  <script src="./assets/js/tailwind.config.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
  <!--
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
</body>

</html>