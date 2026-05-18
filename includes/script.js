// =========================
// CATEGORY NAVIGATION
// =========================
function goToCategory(category) {
    window.location.href = "shop.php?category=" + category;
}


document.addEventListener("DOMContentLoaded", function () {

    /* =========================
       CART QUANTITY SYSTEM
    ========================= */

    let subtotalEl = document.getElementById("subtotal");

    function updateTotal() {

        if (!subtotalEl) return;

        let sum = 0;

        document.querySelectorAll(".item-total").forEach(el => {

            let val = parseFloat(
                el.innerText.replace("KES", "").trim()
            ) || 0;

            sum += val;
        });

        subtotalEl.innerText = sum;
    }

    /* =========================
       PLUS BUTTON
    ========================= */

    document.querySelectorAll(".plus").forEach(btn => {

        btn.addEventListener("click", function () {

            let id = this.dataset.id;
            let row = this.closest("tr");

            let price = parseFloat(row.dataset.price);

            let qtyEl = document.getElementById("qty-" + id);
            let qty = parseInt(qtyEl.innerText);

            qty++;

            qtyEl.innerText = qty;

            document.getElementById("total-" + id).innerText =
                "KES " + (qty * price);

            updateTotal();
        });

    });

    /* =========================
       MINUS BUTTON
    ========================= */

    document.querySelectorAll(".minus").forEach(btn => {

        btn.addEventListener("click", function () {

            let id = this.dataset.id;
            let row = this.closest("tr");

            let price = parseFloat(row.dataset.price);

            let qtyEl = document.getElementById("qty-" + id);
            let qty = parseInt(qtyEl.innerText);

            if (qty > 1) qty--;

            qtyEl.innerText = qty;

            document.getElementById("total-" + id).innerText =
                "KES " + (qty * price);

            updateTotal();
        });

    });

    /* =========================
       ADD TO CART (AJAX)
    ========================= */

    document.querySelectorAll(".add-cart").forEach(button => {

        button.addEventListener("click", function (e) {

            e.preventDefault();

            let id = this.dataset.id;

            fetch("add_to_cart.php", {

                method: "POST",

                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },

                body: "id=" + encodeURIComponent(id)

            })

            .then(res => res.text())

            .then(count => {

                document.querySelectorAll(".cart-count").forEach(el => {
                    el.innerText = count;
                });

            })

            .catch(err => console.error("Cart error:", err));

        });

    });

    /* =========================
       MOBILE NAVBAR TOGGLE
    ========================= */

    const mobile = document.getElementById("mobile");
    const navbar = document.getElementById("navbar");
    const close = document.getElementById("close");

    if (mobile && navbar) {
        mobile.addEventListener("click", () => {
            navbar.classList.add("active");
        });
    }

    if (close && navbar) {
        close.addEventListener("click", (e) => {
            e.preventDefault();
            navbar.classList.remove("active");
        });
    }

    /* =========================
       PRODUCT SEARCH SYSTEM
    ========================= */

    const searchInput = document.getElementById("search-input");
    const searchBtn = document.getElementById("search-btn");

    function searchProduct() {

        if (!searchInput) return;

        let searchValue = searchInput.value.toLowerCase().trim();

        let products = document.querySelectorAll(".pro");

        let found = false;

        products.forEach(product => {

            let productName =
                product.querySelector("h5").innerText.toLowerCase();

            if (productName.includes(searchValue)) {

                found = true;

                product.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });

                product.style.border = "3px solid hotpink";
                product.style.boxShadow = "0 0 20px hotpink";

                setTimeout(() => {
                    product.style.border = "";
                    product.style.boxShadow = "";
                }, 3000);

            }

        });

        if (!found) {
            window.location.href = "shop.php";
        }

    }

    if (searchBtn) {
        searchBtn.addEventListener("click", searchProduct);
    }

    if (searchInput) {
        searchInput.addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
                searchProduct();
            }
        });
    }

});