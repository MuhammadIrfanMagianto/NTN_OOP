-- database.sql
-- Opsional: import manual lewat phpMyAdmin / HeidiSQL (Laragon).
-- Aplikasi juga membuat database & tabel ini otomatis saat auth.php dibuka.

CREATE DATABASE IF NOT EXISTS ntn_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ntn_db;

CREATE TABLE IF NOT EXISTS users (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  username   VARCHAR(50)  NOT NULL,
  email      VARCHAR(100) NOT NULL,
  password   VARCHAR(255) NOT NULL,
  created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_username (username),
  UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
