document.addEventListener("DOMContentLoaded", function () {
    const categoriesContainer = document.getElementById("categories");
    const itemsContainer = document.getElementById("items-container");
    const billContents = document.getElementById("bill-contents");
    const grandTotal = document.getElementById("grand-total");

    const loadCategories = () => {
        fetch("get_categories.php")
            .then(response => response.json())
            .then(data => {
                data.forEach(category => {
                    const button = document.createElement("button");
                    button.textContent = category;
                    button.addEventListener("click", () => loadItems(category));
                    categoriesContainer.appendChild(button);
                });
                loadItems(); // Load all items on initial load
            });
    };

    const loadItems = (category = "") => {
        const params = new URLSearchParams();
        if (category) params.append("category", category);

        fetch(`get_items.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                itemsContainer.innerHTML = ""; // Clear previous items
                data.forEach(item => {
                    const card = document.createElement("div");
                    card.className = "item-card";
                    card.innerHTML = `
                        <img src="${item.image_path}" alt="${item.name}">
                        <p>${item.name}</p>
                        <p>${item.price}</p>
                    `;
                    card.addEventListener("click", () => addToBill(item));
                    itemsContainer.appendChild(card);
                });
            });
    };

    const addToBill = item => {
        let existingRow = Array.from(billContents.children).find(
            row => row.dataset.itemId === String(item.id)
        );

        if (existingRow) {
            const quantityCell = existingRow.querySelector(".quantity");
            const totalCell = existingRow.querySelector(".total");
            const newQuantity = parseInt(quantityCell.textContent) + 1;
            quantityCell.textContent = newQuantity;
            totalCell.textContent = (newQuantity * item.price).toFixed(2);
        } else {
            const row = document.createElement("tr");
            row.dataset.itemId = item.id;
            row.innerHTML = `
                <td>${item.name}</td>
                <td>${item.price}</td>
                <td class="quantity">1</td>
                <td class="total">${item.price}</td>
            `;
            billContents.appendChild(row);
        }
        updateGrandTotal();
    };

    const updateGrandTotal = () => {
        let total = 0;
        billContents.querySelectorAll(".total").forEach(cell => {
            total += parseFloat(cell.textContent);
        });
        grandTotal.textContent = total.toFixed(2);
    };

    loadCategories();
});

// document.getElementById('checkout-btn').addEventListener('click', function () {
//     const receiptContent = document.getElementById('receipt-content');
//     const billRows = document.querySelectorAll('#bill-contents tr');

//     if (billRows.length === 0) {
//         alert('No items in the bill to checkout.');
//         return;
//     }

//     let receiptHTML = '<table><thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead><tbody>';
//     let grandTotal = 0;

//     billRows.forEach(row => {
//         const item = row.children[0].textContent;
//         const price = row.children[1].textContent;
//         const qty = row.children[2].textContent;
//         const total = row.children[3].textContent;

//         receiptHTML += `<tr>
//             <td>${item}</td>
//             <td>${price}</td>
//             <td>${qty}</td>
//             <td>${total}</td>
//         </tr>`;
//         grandTotal += parseFloat(total);
//     });

//     receiptHTML += `
//         </tbody>
//         <tfoot>
//             <tr>
//                 <td colspan="3"><strong>Grand Total:</strong></td>
//                 <td>${grandTotal.toFixed(2)}</td>
//             </tr>
//         </tfoot>
//     </table>`;

//     receiptContent.innerHTML = receiptHTML;
//     document.getElementById('receipt').style.display = 'block';
// });

document.getElementById('checkout-btn').addEventListener('click', function () {
    const serviceType = document.getElementById('service-type').value;
    const receiptContent = document.getElementById('receipt-content');
    const billRows = document.querySelectorAll('#bill-contents tr');

    if (billRows.length === 0) {
        alert('No items in the bill to checkout.');
        return;
    }

    let receiptHTML = `<p><strong>Service Type:</strong> ${serviceType}</p>`;
    receiptHTML += '<table><thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead><tbody>';
    let grandTotal = 0;

    billRows.forEach(row => {
        const item = row.children[0].textContent;
        const price = row.children[1].textContent;
        const qty = row.children[2].textContent;
        const total = row.children[3].textContent;

        receiptHTML += `<tr>
            <td>${item}</td>
            <td>${price}</td>
            <td>${qty}</td>
            <td>${total}</td>
        </tr>`;
        grandTotal += parseFloat(total);
    });

    receiptHTML += `
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Grand Total:</strong></td>
                <td>${grandTotal.toFixed(2)}</td>
            </tr>
        </tfoot>
    </table>`;

    receiptContent.innerHTML = receiptHTML;
    document.getElementById('receipt').style.display = 'block';

    // Optional: Save the order to the database (if required)
    saveOrderToDatabase(serviceType, grandTotal);
});

// Optional: Save order details to the database
function saveOrderToDatabase(serviceType, grandTotal) {
    const billItems = [];
    document.querySelectorAll('#bill-contents tr').forEach(row => {
        const item = row.children[0].textContent;
        const price = parseFloat(row.children[1].textContent);
        const qty = parseInt(row.children[2].textContent);
        const total = parseFloat(row.children[3].textContent);

        billItems.push({ item, price, qty, total });
    });

    const data = { serviceType, grandTotal, billItems };

    fetch('save_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Order saved successfully!');
            } else {
                alert('Failed to save order.');
            }
        })
        .catch(error => console.error('Error:', error));
}


document.getElementById('checkout-btn').addEventListener('click', function () {
    const serviceType = document.getElementById('service-type').value;
    const receiptContent = document.getElementById('printable-receipt');
    const billRows = document.querySelectorAll('#bill-contents tr');

    if (billRows.length === 0) {
        alert('No items in the bill to checkout.');
        return;
    }

    let receiptHTML = `<p><strong>Service Type:</strong> ${serviceType}</p>`;
    receiptHTML += '<table><thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead><tbody>';
    let grandTotal = 0;

    billRows.forEach(row => {
        const item = row.children[0].textContent;
        const price = row.children[1].textContent;
        const qty = row.children[2].textContent;
        const total = row.children[3].textContent;

        receiptHTML += `<tr>
            <td>${item}</td>
            <td>${price}</td>
            <td>${qty}</td>
            <td>${total}</td>
        </tr>`;
        grandTotal += parseFloat(total);
    });

    receiptHTML += `
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Grand Total:</strong></td>
                <td>${grandTotal.toFixed(2)}</td>
            </tr>
        </tfoot>
    </table>`;

    // Set receipt content and display it
    receiptContent.innerHTML = receiptHTML;
    document.getElementById('receipt').style.display = 'block';

    // Trigger print
    printReceipt();
});

function printReceipt() {
    const printContents = document.getElementById('printable-receipt').innerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents; // Temporarily replace page content
    window.print();
    document.body.innerHTML = originalContents; // Restore original content

    // Reload the page to restore event listeners
    location.reload();
}



