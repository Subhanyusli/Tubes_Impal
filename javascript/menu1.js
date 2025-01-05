//mengambil data menu dari table menu
document.addEventListener("DOMContentLoaded", () => {
    let menuItems = []; // global menu items

    function fetchMenuItems() {
        fetch('../php/get_menu.php')
            .then(response => response.json())
            .then(menu => {
                menuItems = menu; // menyimpan menu items
                displayMenu('all');
            })
            .catch(error => console.error('Error:', error));
    }

    function displayMenu(filter) {
        const menuContainer = document.querySelector("#menu-container");
        menuContainer.innerHTML = "";

        const filteredMenu = filter === "all" ? menuItems : menuItems.filter(item => item.type === filter);

        filteredMenu.forEach(item => {
            const menuItem = document.createElement("div");
            menuItem.className = "menu-item";
            // Harga diubah ke format number tanpa "Rp. "
            const price = parseInt(item.harga);
            menuItem.innerHTML = `
                <img src="${item.image_path}" alt="${item.nama_menu}">
                <h3>${item.nama_menu}</h3>
                <p>${item.deskripsi}</p>
                <span>Rp. ${price.toLocaleString('id-ID')}</span>
                <button onclick="addToCart(${item.id_menu})">
                    Add to cart
                </button>
            `;
            menuContainer.appendChild(menuItem);
        });
    }

    // Event listener untuk tombol filter
    document.querySelector("#allButton").addEventListener("click", () => displayMenu("all"));
    document.querySelector("#foodButton").addEventListener("click", () => displayMenu("food"));
    document.querySelector("#drinkButton").addEventListener("click", () => displayMenu("drink"));

    fetchMenuItems();
});

// menambahkan menu ke cart
function addToCart(menuId) {
    const formData = new FormData();
    formData.append('id_menu', menuId);

    fetch('../php/cart_handler1.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Item berhasil ditambahkan ke keranjang!', 'success');
        } else {
            showNotification(data.message || 'Gagal menambahkan item ke keranjang', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Item Sudah Terdaftar dalam Keranjang', 'error');
    });
}


//menampilkan notifikasi
function showNotification(message, type) {
    //Cek apakah sudah ada notifikasi sebelumnya
    const existingNotif = document.querySelector('.notification');
    if (existingNotif) {
        existingNotif.remove();
    }

    //Buat elemen notifikasi baru
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    //Tambahkan ke body
    document.body.appendChild(notification);

    //Hilangkan notifikasi setelah 3 detik
    setTimeout(() => {
        notification.remove();
    }, 3000);
}