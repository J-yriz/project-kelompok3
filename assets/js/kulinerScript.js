'use strict';

// navbar variables
const nav = document.querySelector('.navbar-nav');
const navLinks = document.querySelectorAll('.nav-link');
const navToggleBtn = document.querySelector('.menu-toggle-btn');
const shoppingCart = document.querySelector('.cart-box');

// nav toggle function
const navToggleFunc = function () {
    nav.classList.toggle('active');
    navToggleBtn.classList.toggle('active');
}

// shopping cart toggle function
const cartToggleFunc = function () { shoppingCart.classList.toggle('active') }

// add event on nav-toggle-btn
navToggleBtn.addEventListener('click', function () {
    if (shoppingCart.classList.contains('active')) cartToggleFunc();
    navToggleFunc();
});

// add event on all nav-link
for (let i = 0; i < navLinks.length; i++) {
    navLinks[i].addEventListener('click', navToggleFunc);
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
        const modalContainer = document.querySelector(".modal-container");
        const aClassStyle = document.getElementsByClassName("kartuProduk");
        const button = document.getElementById("myButton");
        let isFullMenu = true;

        function loadData(ea) {
            let card = '';
            data.forEach((e, i) => {
                if (i < 3) {
                    if (e.namaProduk.length > 12) {
                        e.namaProduk = e.namaProduk.slice(0, 12) + '..';
                    }
                    e.namaProduk = capitalizeEachWord(e.namaProduk);
                    card += isiHtmlCards(e);
                } else{
                    if (e.namaProduk.length > 12) {
                        e.namaProduk = e.namaProduk.slice(0, 12) + '..';
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
        document.addEventListener('DOMContentLoaded', function () {
            const searchForm = document.querySelector('form');
            const searchInput = document.querySelector('#default-search');

            searchForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const inputValue = searchInput.value.toLowerCase();
                const cardInput = data
                    .filter((e) => e.namaProduk.toLowerCase().includes(inputValue))
                    .map((e) => ({
                        ...e,
                        namaProduk: capitalizeEachWord(e.namaProduk),
                    }))
                    .map(isiHtmlCards)
                    .join('');

                if (cardInput) {
                    productContainer.innerHTML = cardInput;
                } else {
                    alert("Maaf nama makanan tidak tersedia.");
                }
                productContainer.innerHTML = cardInput;
                button.style.display = 'none';
                if (inputValue === '') {
                    displayShortMenu();
                    button.style.display = 'block';
                }
            });
        });

        // Rating dropdown
        const ratingDropdown = document.getElementById('rating');

        ratingDropdown.addEventListener('change', function () {
            const selectedRating = parseInt(ratingDropdown.value, 10);

            if (isNaN(selectedRating)) {
                displayShortMenu();
                button.style.display = "block";
            } else {
                // Filter products based on the selected rating
                const filteredProducts = data
                    .filter((e) => Math.floor(e.bintang) === selectedRating)
                    .map((e) => ({
                        ...e,
                        namaProduk: capitalizeEachWord(e.namaProduk),
                    }))
                    .map(isiHtmlCards)
                    .join('');
        
                // Update the displayed products
                if (filteredProducts) {
                    productContainer.innerHTML = filteredProducts;
                } else {
                    productContainer.innerHTML = '';
                }

                button.style.display = "none";
            }
        });
    }
};
xhttp.open("GET", "data.json", true);
xhttp.send();

function isiHtmlCards(e, s) {
    let starIcons = Array.from({ length: e.bintang }, () => '<ion-icon name="star"></ion-icon>').join('');
    return `<a class="kartuProduk" ${s} onclick="console.log('ea');" data-modal-target="modalDetailMakanan" data-modal-toggle="modalDetailMakanan">
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

                    <p class="product-price">${e.harga}</p>
                    </div>

                    <p class="product-text">
                    ${e.keterangan}
                    </p>

                    <div class="product-rating">
                        ${starIcons}
                    </div>
                </div>
                </div>
            </a>`
};

function capitalizeEachWord(str) {
    const words = str.split(' ');

    const capitalizedWords = words.map(word => {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    });

    return capitalizedWords.join(' ');
}