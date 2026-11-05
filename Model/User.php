<?php
// Model/User.php
// Model yang mengelola data USER di database (register & login).
// Seluruh query database ada di sini.
namespace NTNIndustries\Model;

class User {
    private $conn;

    public function __construct(\mysqli $conn) {
        $this->conn = $conn;
        $this->createTableIfNotExists();
    }

    // Buat tabel users otomatis jika belum ada (tabel lama tidak diubah)
    private function createTableIfNotExists() {
        $this->conn->query(
            "CREATE TABLE IF NOT EXISTS users (
                id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
                username   VARCHAR(50)  NOT NULL,
                email      VARCHAR(100) NOT NULL,
                password   VARCHAR(255) NOT NULL,
                created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                UNIQUE KEY uq_users_username (username),
                UNIQUE KEY uq_users_email (email)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
        );
    }

    public function usernameExists($username) {
        return $this->exists("SELECT id FROM users WHERE username = ? LIMIT 1", $username);
    }

    public function emailExists($email) {
        return $this->exists("SELECT id FROM users WHERE email = ? LIMIT 1", $email);
    }

    private function exists($sql, $value) {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->store_result();
        $found = $stmt->num_rows > 0;
        $stmt->close();

        return $found;
    }

    // Simpan user baru. Password di-hash di sini. Return true jika berhasil,
    // false jika username/email sudah dipakai (duplicate key).
    public function register($username, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        try {
            $stmt->execute();
            $success = true;
        } catch (\mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {   // Duplicate entry
                $success = false;
            } else {
                $stmt->close();
                throw $e;
            }
        }

        $stmt->close();
        return $success;
    }

    // Cari user berdasarkan email. Return array (id, username, password) atau null.
    public function findByEmail($email) {
        $sql = "SELECT id, username, password FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = $result->fetch_assoc();
        $stmt->close();

        return $user ? $user : null;
    }

    // Cocokkan password input dengan hash di database
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public function close() {
        $this->conn->close();
    }
}
