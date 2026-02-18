document.addEventListener("DOMContentLoaded", loadProducts);

function loadProducts() {
    fetch("get_products.php")
        .then(response => response.json())
        .then(data => {
            const productList = document.getElementById("productList");
            productList.innerHTML = "";

            data.forEach(product => {
                const div = document.createElement("div");
                div.classList.add("product-item");

                div.innerHTML = `
                    <p><strong>${product.name}</strong> - $${product.price}</p>
                    <button onclick="deleteProduct(${product.id})">
                        Delete
                    </button>
                `;

                productList.appendChild(div);
            });
        });
}

function deleteProduct(id) {
    if (!confirm("Are you sure you want to delete this product?")) return;

    fetch("delete_product.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        loadProducts(); // reload list
    });
}
