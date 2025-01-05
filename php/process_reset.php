<?php
session_start();
require_once 'db_connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once '../vendor/autoload.php';

function sendResetEmail($email, $token) {
    try {
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fly7onx@gmail.com';
        // Gunakan app password yang dibuat khusus
        $mail->Password = 'qqxx uxqx cdnf kvzz'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Penerima
        $mail->setFrom('fly7onx@gmail.com', 'Reset Password');
        $mail->addAddress($email);
        
        // isinya
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Link';
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . 
             "/Tubes_Impal/html/reset-password.html?token=".$token;
        $mail->Body = "Klik link berikut untuk reset password: <a href='$resetLink'>Reset Password</a>";
        
        $mail->send();
        error_log("Email sent successfully to: " . $email);
        return true;
    } catch (Exception $e) {
        error_log("Failed to send email. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Proses forgot password
if (isset($_POST['forgot_password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!$email) {
        die("Email tidak valid");
    }
    
    $token = bin2hex(random_bytes(32));
    
    $sql = "UPDATE user SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $token, $email);
    
    if ($stmt->execute() && sendResetEmail($email, $token)) {
        header("Location: ../html/forgot-password.html?status=success&message=Link reset password telah dikirim");
        exit();
    } else {
        header("Location: ../html/forgot-password.html?status=error&message=Gagal mengirim email reset password");
        exit();
    }
}

// Proses reset password
if (isset($_POST['reset_password'])) {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($token) || empty($password)) {
        die("Token atau password tidak boleh kosong");
    }
    
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "UPDATE user SET password = ?, reset_token = NULL, reset_expires = NULL 
            WHERE reset_token = ? AND reset_expires > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $password, $token);
    
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        header("Location: ../html/login.html");
        exit();
    } else {
        header("Location: ../html/reset-password.html?status=error&message=Token tidak valid atau sudah expired");
        exit();
    }
}
?>