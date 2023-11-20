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

// Ambil data.json
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        var data = JSON.parse(xhttp.responseText);
        const productContainer = document.querySelector(".product-container");
        const aClassStyle = document.getElementsByClassName("kartuProduk");
        const button = document.getElementById("myButton");
        let isFullMenu = true;

        function loadData(ea) {
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
            // loadData("N");
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

        // Rating dropdown
        const ratingDropdown = document.getElementById("rating");

        ratingDropdown.addEventListener("change", function () {
            const selectedRating = parseInt(ratingDropdown.value, 10);

            if (isNaN(selectedRating)) {
                for (let i = 0; i < aClassStyle.length; i++) {
                    aClassStyle[i].style.display = "block";
                }
                displayShortMenu();
                button.style.display = "block";
            } else {
                // Loop through all elements and hide/show based on the filter
                for (let i = 0; i < aClassStyle.length; i++) {
                    const product = data[i];
                    const productRating = Math.floor(product.bintang);

                    if (productRating === selectedRating) {
                        aClassStyle[i].style.display = "block";
                    } else {
                        aClassStyle[i].style.display = "none";
                    }
                }

                button.style.display = "none";
            }
        });

        // ModalDetail
        const kartuPro = document.querySelectorAll('.kartuProduk');
        const modalContent = document.querySelector('.modalContent')

        kartuPro.forEach((elemen) => {
            elemen.addEventListener('click', function () {
                const dataDetail = Number(elemen.getAttribute('data-detail'));
                data.forEach((e) => {
                    if (e.id === dataDetail) {
                        let modalDetailMakanan = `
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <p class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                            <a style="margin-right: 5px;" href="${e.detail.linkWebsite}" target="_blank"">${e.namaProduk} |</a>
                            <span class="small">Rp.</span> ${e.harga.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}
                            </p>
                        </div>
                        <!-- Modal body -->
                        <div class="flex flex-col md:flex-row p-4 md:p-5 space-y-4 md:space-y-0 md:space-x-4 items-center">
                            <img src="./assets/images/${e.gambar}" alt="product image" class="w-30 sm:w-2/5" loading="lazy" />
                            <div class="penjelasanMakanan text-base leading-relaxed text-gray-500 dark:text-gray-400">
                            <div class="keteranganMakanan border p-2 md:p3 md:rounded-md">
                                <div class="kotakAsikSendiri border-b flex flex-col md:flex-row pb-2">
                                <p class="mr-4"><span class="font-semibold text-white">Rating Menu</span>${e.bintang}</p>
                                <p><span class="font-semibold text-white">Keterangan</span>${e.keterangan}</p>
                                </div>
                                <p class="border-b pb-2"><span class="font-semibold text-white">Alamat</span>${e.detail.alamat}</p>
                                <p><span class="font-semibold text-white">Menu lainnya</span>- ${e.detail.menu1} | Rp.${e.detail.harga1.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}<br>- ${e.detail.menu2} | Rp.${e.detail.harga2.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}<br>- ${e.detail.menu3} | Rp.${e.detail.harga3.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>
                            </div>
                            </div>
                        </div>
                        <iframe
                            src="${e.detail.linkMap}"
                            loading="lazy" class="px-4 md:px-5 w-full h-80 md:h-56" frameborder="0">
                        </iframe>`
                        
                        modalContent.innerHTML = modalDetailMakanan;
                    }
                })
            });
        });

    }
};
xhttp.open("GET", "assets/json/data.json", true);
xhttp.send();

function isiHtmlCards(e, s) {
    let starIcons = Array.from(
        { length: e.bintang },
        () => '<ion-icon name="star"></ion-icon>'
    ).join("");
    return `<a class="kartuProduk" ${s} data-modal-target="modalDetailMakanan" data-modal-toggle="modalDetailMakanan" data-detail=" ${e.id}">
                <div class="product-card">
                <div class="img-box">
                    <img
                    src="./assets/images/${e.gambar}"
                    alt="product image"
                    class="product-img"
                    width="200"
                    loading="lazy"
                    />
                </div>

                <div class "product-content">
                    <div class="wrapper">
                    <h3 class="product-name">${e.namaProduk}</h3>

                    <p class="product-price"><span class='small'>Rp.</span>${e.harga.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>
                    </div>

                    <p class="product-text">
                    ${e.keterangan}
                    </p>

                    <div class="product-rating">
                        ${starIcons}
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
