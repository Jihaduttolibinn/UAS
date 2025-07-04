-- Tabel User (Mahasiswa & Asisten)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('mahasiswa', 'asisten') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Mata Praktikum
CREATE TABLE praktikum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_praktikum VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Modul/ Materi Praktikum
CREATE TABLE modul (
    id INT AUTO_INCREMENT PRIMARY KEY,
    praktikum_id INT NOT NULL,
    judul_modul VARCHAR(100) NOT NULL,
    file_materi VARCHAR(255), -- path file materi (PDF/DOCX)
    tanggal DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (praktikum_id) REFERENCES praktikum(id) ON DELETE CASCADE
);

-- Tabel Pendaftaran Praktikum oleh Mahasiswa
CREATE TABLE pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    praktikum_id INT NOT NULL,
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (praktikum_id) REFERENCES praktikum(id) ON DELETE CASCADE,
    UNIQUE KEY unique_pendaftaran (user_id, praktikum_id)
);

-- Tabel Laporan Mahasiswa
CREATE TABLE laporan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    modul_id INT NOT NULL,
    file_laporan VARCHAR(255) NOT NULL, -- path file laporan
    tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('dikirim', 'dinilai') DEFAULT 'dikirim',
    nilai DECIMAL(5,2), -- nilai angka, boleh null jika belum dinilai
    feedback TEXT,       -- feedback asisten
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (modul_id) REFERENCES modul(id) ON DELETE CASCADE,
    UNIQUE KEY unique_laporan (user_id, modul_id)
);