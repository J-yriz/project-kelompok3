"use strict";

// navbar variables
const nav = document.querySelector(".navbar-nav");
const navLinks = document.querySelectorAll(".nav-link");
const navToggleBtn = document.querySelector(".menu-toggle-btn");
const shoppingCart = document.querySelector(".cart-box");

// nav toggle function
const navToggleFunc = function () {
    nav.classList.toggle("active");
    navToggleBtn.classList.toggle("active");
};

// shopping cart toggle function
const cartToggleFunc = function () {
    shoppingCart.classList.toggle("active");
};

// add event on nav-toggle-btn
navToggleBtn.addEventListener("click", function () {
    if (shoppingCart.classList.contains("active")) cartToggleFunc();
    navToggleFunc();
});

// add event on all nav-link
for (let i = 0; i < navLinks.length; i++) {
    navLinks[i].addEventListener("click", navToggleFunc);
}

// Automatic Slideshow
let slideIndex = 0;

function carousel() {
    const slides = document.getElementsByClassName("mySlides");
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex].style.display = "block";
    slideIndex = (slideIndex + 1) % slides.length;
    setTimeout(carousel, 10000);
}
carousel();

// Ambil dataKomentar.json
let secondxhttp = new XMLHttpRequest();
secondxhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        let data = JSON.parse(secondxhttp.responseText);
        const tempatUlasan = document.querySelector(".containerUlasan")
        let dataUlasan = '';
        data.forEach((e) => {
            dataUlasan += isiUlasan(e)
        })
        tempatUlasan.innerHTML = dataUlasan;

        // Rating dropdown
        const ratingDropdown = document.getElementById("ratingUlasan");

        ratingDropdown.addEventListener("change", function () {
            let dataUlasanFilter = '';
            const selectedRating = parseInt(ratingDropdown.value, 10);

            if (isNaN(selectedRating)) {
                tempatUlasan.innerHTML = dataUlasan;
            } else {
                for (let i = 0; i < data.length; i++) {
                    if (data[i].bintang === selectedRating) {
                        dataUlasanFilter += isiUlasan(data[i])
                    }
                }
                tempatUlasan.innerHTML = dataUlasanFilter;
            }
        });

    }
}
secondxhttp.open("GET", "assets/json/dataKomentar.json", true);
secondxhttp.send();

// Ambil data.json
let xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        let data = JSON.parse(xhttp.responseText);
        let dataKomentar = JSON.parse(secondxhttp.responseText)
        const productContainer = document.querySelector(".product-container");
        const aClassStyle = document.getElementsByClassName("kartuProduk");
        const button = document.getElementById("myButton");
        let isFullMenu = true;

        function loadData() {
            let card = "";
            data.forEach((e, i) => {
                if (i < 3) {
                    if (e.namaProduk.length > 12) {
                        e.namaProduk = e.namaProduk.slice(0, 12) + "..";
                    }
                    e.namaProduk = capitalizeEachWord(e.namaProduk);
                    card += isiHtmlCards(e);
                } else {
                    if (e.namaProduk.length > 12) {
                        e.namaProduk = e.namaProduk.slice(0, 12) + "..";
                    }
                    e.namaProduk = capitalizeEachWord(e.namaProduk);
                    card += isiHtmlCards(e, `style="display: none;"`);
                }
            });
            return card;
        }

        productContainer.innerHTML = loadData();

        function displayShortMenu() {
            for (let i = 3; i < aClassStyle.length; i++) {
                aClassStyle[i].style.display = "none";
            }
            button.textContent = "Full menu";
        }

        function displayFullMenu() {
            for (let i = 0; i < aClassStyle.length; i++) {
                aClassStyle[i].style.display = "block";
            }
            button.textContent = "Short menu";
        }

        displayShortMenu(); // Tampilkan menu penuh saat halaman dimuat

        button.addEventListener("click", () => {
            if (!isFullMenu) {
                displayShortMenu(); // Tampilkan menu singkat
            } else {
                displayFullMenu(); // Tampilkan menu penuh
            }

            isFullMenu = !isFullMenu; // Toggle status menu
        });

        // Search Input
        document.addEventListener("DOMContentLoaded", function () {
            const searchForm = document.querySelector("form");
            const searchInput = document.querySelector("#default-search");

            searchForm.addEventListener("submit", function (event) {
                event.preventDefault();
                const inputValue = searchInput.value.toLowerCase();

                for (let i = 0; i < aClassStyle.length; i++) {
                    const product = data[i];
                    const productName = product.namaProduk.toLowerCase();

                    if (productName.includes(inputValue)) {
                        aClassStyle[i].style.display = "block";
                    } else {
                        aClassStyle[i].style.display = "none";
                    }
                }

                button.style.display = "none";
                if (inputValue === "") {
                    displayShortMenu();
                    button.style.display = "block";
                }
            });
        });

        // ModalDetail
        const kartuPro = document.querySelectorAll('.kartuProduk');
        const modalContent = document.querySelector('.modalContent')

        kartuPro.forEach((elemen) => {
            elemen.addEventListener('click', function () {
                const dataDetail = Number(elemen.getAttribute('data-detail'));
                let dataKomentarModal = '';
                let logika = dataKomentar.some((x) => x.id === dataDetail) ? 'overflow-y-auto h-80 md:h-40' : 'block pb-5 md:pb-0';
                data.forEach((e) => {
                    if (e.id === dataDetail) {
                        e.detail.menu1 = capitalizeEachWord(e.detail.menu1);
                        e.detail.menu2 = capitalizeEachWord(e.detail.menu2);
                        e.detail.menu3 = capitalizeEachWord(e.detail.menu3);
                        dataKomentar.forEach((x) => {
                            if(x.id === dataDetail) {
                                let starIcons = Array.from(
                                    { length: x.bintang },
                                    () => '<ion-icon name="star"></ion-icon>'
                                ).join("");
                                let gtw = '';
                                if (x.bintang === 1) {
                                    gtw += 'Sangat Buruk!'
                                } else if (x.bintang === 2) {
                                    gtw += 'Buruk!'
                                } else if (x.bintang === 3) {
                                    gtw += 'Cukup!'
                                } else if (x.bintang === 4) {
                                    gtw += 'Bagus!'
                                } else {
                                    gtw += 'Sangat Bagus!'
                                }
                                dataKomentarModal += `
                                    <div class="testimonials-card px-10 py-5 md:pt-5">
                                        <h4 class="card-title">${gtw}</h4>
                        
                                        <div class="testimonials-rating">
                                            ${starIcons}
                                        </div>
                        
                                        <p class="testimonials-text">${x.komentar}</p>
                        
                                        <div class="customer-info">
                                        <div class="customer-img-box">
                                            <img src="./assets/images/profile.png" alt="customer image" class="customer-img" width="100"
                                            loading="lazy" />
                                        </div>
                        
                                        <h5 class="customer-name">${x.nama}</h5>
                                        </div>
                                    </div>`
                            } else {
                                dataKomentarModal += '';
                            }
                        })
                        let modalDetailMakanan = `
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <p class="text-xl font-semibold text-putihMiaw dark:text-putihMiaw flex items-center">
                            <a style="margin-right: 5px;" href="${e.detail.goFood}" target="_blank"">${capitalizeEachWord(e.namaProduk1)} |</a>
                            <span class="small">Rp.</span> ${e.harga.includes(".") ? e.harga : e.harga.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}
                            </p>
                        </div>
                        <!-- Modal body -->
                        <div class="flex flex-col md:flex-row p-4 md:p-5 space-y-4 md:space-y-0 md:space-x-4 items-center">
                            <img src="./assets/images/menu/${e.gambar}" alt="product image" class="w-30 sm:w-2/5" loading="lazy" />
                            <div class="hidden md:block penjelasanMakanan text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                <div class="keteranganMakanan border border-biruModal bg-biruModal shadow-xl p-2 md:p3 rounded-md">
                                    <div class="kotakAsikSendiri border-b flex flex-col md:flex-row pb-2">
                                        <p class="text-gray-600"><span class="font-bold text-white">Keterangan</span>${e.keterangan}</p>
                                    </div>
                                        <p class="border-b pb-2 text-gray-600"><span class="font-bold text-white">Alamat</span>${e.detail.alamat}</p>
                                        <p class="text-gray-600"><span class="font-bold text-white">Menu lainnya</span>- ${e.detail.menu1} | Rp.${e.detail.harga1.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}<br>- ${e.detail.menu2} | Rp.${e.detail.harga2.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}<br>- ${e.detail.menu3} | Rp.${e.detail.harga3.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>
                                </div>
                            </div>
                        </div>
                        <div class="${logika}">
                            <div class="block md:hidden penjelasanMakanan text-base leading-relaxed text-gray-500 dark:text-gray-400 px-5">
                                <div class="keteranganMakanan border border-biruModal bg-biruModal shadow-xl p-2 md:p3 rounded-md">
                                    <div class="kotakAsikSendiri border-b flex flex-col md:flex-row pb-2">
                                        <p class="text-gray-600"><span class="font-bold text-putihMiaw">Keterangan</span>${e.keterangan}</p>
                                    </div>
                                    <p class="border-b pb-2 text-gray-600"><span class="font-bold text-putihMiaw">Alamat</span>${e.detail.alamat}</p>
                                    <p class="text-gray-600"><span class="font-bold text-putihMiaw">Menu lainnya</span>- ${e.detail.menu1} | Rp.${e.detail.harga1.includes(".") ? e.detail.harga1 : e.detail.harga1.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}<br>- ${e.detail.menu2} | Rp.${e.detail.harga2.includes(".") ? e.detail.harga2 : e.detail.harga2.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}<br>- ${e.detail.menu3} | Rp.${e.detail.harga3.includes(".") ? e.detail.harga3 : e.detail.harga3.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>
                                </div>
                            </div>
                            <div class="testimonials-grid">
                            ${dataKomentarModal}
                            </div>
                        </div>`


                        modalContent.innerHTML = modalDetailMakanan;
                    }
                })
            });
        });

        // Tambah Ulasan
        const tambahUlasanBtn = document.getElementById('tambahUlasan');
        const modalMenu = document.querySelector('.menuMakanan');

        tambahUlasanBtn.addEventListener('click', function () {
            let options = '<option value="" selected disabled>Pilih Menu</option>';
            data.forEach((e) => {
                options += `<option value="${capitalizeEachWord(e.namaProduk1)}">${capitalizeEachWord(e.namaProduk1)}</option>`;
            })
            let modalMakanan = `<label for="menuMakanan"
                                class="block mb-2 font-medium text-gray-900 dark:text-putihMiaw">Menu</label>
                            <select id="menuMakanan" name="menuMakanan"
                                class="bg-gray-50 border border-putihMiaw text-gray-900 text-sm rounded-lg focus:ring-biruMiaw focus:border-biruMiaw block w-full py-3 px-4 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-putihMiaw dark:focus:ring-hitamMiaw dark:focus:border-hitaring-hitamMiaw">
                                ${options}
                            </select>`
            modalMenu.innerHTML = modalMakanan;
        });

    }
};
xhttp.open("GET", "assets/json/data.json", true);
xhttp.send();

function isiUlasan(e) {
    let starIcons = Array.from(
        { length: e.bintang },
        () => '<ion-icon name="star"></ion-icon>'
    ).join("");
    let gtw = '';
    if (e.bintang === 1) {
        gtw += 'Sangat Buruk!'
    } else if (e.bintang === 2) {
        gtw += 'Buruk!'
    } else if (e.bintang === 3) {
        gtw += 'Cukup!'
    } else if (e.bintang === 4) {
        gtw += 'Bagus!'
    } else {
        gtw += 'Sangat Bagus!'
    }
    return `<div class="testimonials-card">
                <h4 class="card-title">${e.namaMakanan} | ${gtw}</h4>

                <div class="testimonials-rating">
                    ${starIcons}
                </div>

                <p class="testimonials-text">${e.komentar}</p>

                <div class="customer-info">
                <div class="customer-img-box">
                    <img src="./assets/images/profile.png" alt="customer image" class="customer-img" width="100"
                    loading="lazy" />
                </div>

                <h5 class="customer-name">${e.nama}</h5>
                </div>
            </div>`
}


function isiHtmlCards(e, s) {
    let starIcons = Array.from(
        { length: e.bintang },
        () => '<ion-icon name="star"></ion-icon>'
    ).join("");
    return `<a class="kartuProduk shadow-xl rounded-lg" ${s} data-modal-target="modalDetailMakanan" data-modal-toggle="modalDetailMakanan" data-detail=" ${e.id}">
                <div class="product-card">
                    <div class="img-box">
                        <img
                        src="./assets/images/menu/${e.gambar}"
                        alt="product image"
                        class="product-img"
                        width="200"
                        loading="lazy"
                        />
                    </div>

                    <div class "product-content">
                        <div class="wrapper bg-putihMiaw3">
                            <h3 class="product-name">${e.namaProduk}</h3>

                            <p class="product-price bg-biruMiaw"><span class='small'>Rp.</span>${e.harga.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>
                            </div>

                            <p class="product-text px-5">
                            ${e.keterangan}
                            </p>

                            <div class="product-rating px-5 pb-5">
                                ${starIcons}
                            </div>
                        </div>
                    </div>
                </div>
            </a>`;
}

function capitalizeEachWord(str) {
    const words = str.split(" ");

    const capitalizedWords = words.map((word) => {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    });

    return capitalizedWords.join(" ");
}
