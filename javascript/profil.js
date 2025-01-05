//toogle edit profil
var originalValues = {};
function toggleEditMode(isEditing) {
    var formContainer = document.querySelector('.form-container');
    var editProfileButton = document.querySelector('.edit-profile-button');
    var buttonGroup = document.querySelector('.button-group');
    var inputs = document.querySelectorAll('.form-group input');

    if (isEditing) {
        //menyimpan nilai sebelum diubah 
        inputs.forEach(input => originalValues[input.id] = input.value);

        inputs.forEach(input => input.removeAttribute('readonly'));
        buttonGroup.style.display = 'flex';
        editProfileButton.style.display = 'none';
    } else {
        //mengembalikan nilai jika cancel
        inputs.forEach(input => {
            input.value = originalValues[input.id];
            input.setAttribute('readonly', true);
        });
        buttonGroup.style.display = 'none';
        editProfileButton.style.display = 'flex';
    }
}
//menyimpan nilai dan mengupdate profil ketika menekan save
async function saveProfile() {
    const inputs = document.querySelectorAll('.form-group input');
    const profileData = {};

    inputs.forEach(input => {
        profileData[input.name] = input.value;
    });


    try {
        const response = await fetch('update_profil.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(profileData)
        });

        if (!response.ok) throw new Error('Gagal update profile');
        
        toggleEditMode(false);
        await loadUserProfile(); // Reload data setelah update
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal menyimpan perubahan');
    }
}
//mengambil data profil dari table user
async function loadUserProfile() {
    try {
        const response = await fetch('get_profil.php');
        if (!response.ok) {
            console.error('Status:', response.status);
            return;
        }
        const userData = await response.json();
        if (userData.error) {
            console.error('Error:', userData.error);
            return;
        }
        updateProfileUI(userData);
    } catch (error) {
        console.error('Fetch error:', error);
    }
}
//memperbarui tampilan profil dari table user
function updateProfileUI(userData) {
    document.getElementById('nama').value = userData.nama;
    document.getElementById('alamat').value = userData.alamat;
    document.getElementById('no-telpon').value = userData.nomor_telepon;
    document.getElementById('email').value = userData.email;
    document.querySelector('.user-name').textContent = userData.nama;
}

document.addEventListener('DOMContentLoaded', loadUserProfile);