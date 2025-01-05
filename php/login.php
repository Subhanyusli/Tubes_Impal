<?php
require 'db_connection.php';
session_start();
#memeriksa metode permintaan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = ['success' => false, 'message' => ''];
    #mengambil input dan memastikan tidak kosong
    try {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            throw new Exception("Email dan Password tidak boleh kosong!");
        }

        // Periksa di tabel admin
        $stmt = $conn->prepare("SELECT id_admin, nama, password FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id_admin'];
                $_SESSION['admin_name'] = $admin['nama'];
                $_SESSION['is_admin'] = true;
                
                $response['success'] = true;
                $response['message'] = "Login berhasil!";
                $response['redirect'] = "../php/admin_recipe.php";
            } else {
                throw new Exception("Password salah!");
            }
        } else {
            // Periksa di tabel user
            $stmt = $conn->prepare("SELECT id_user, nama, password FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['user_name'] = $user['nama'];
                    $_SESSION['is_admin'] = false;
                    
                    $response['success'] = true;
                    $response['message'] = "Login berhasil!";
                    $response['redirect'] = "../php/main.php";
                } else {
                    throw new Exception("Password salah!");
                }
            } else {
                throw new Exception("Email tidak ditemukan!");
            }
        }
        $stmt->close();
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
        // Tambahkan log kesalahan
        error_log("Login error: " . $e->getMessage());
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
