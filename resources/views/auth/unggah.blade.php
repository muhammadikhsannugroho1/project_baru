<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Resep</title>
    <link rel="stylesheet" href="{{ asset ("asset/css/unggah.css") }}">
</head>
<body>
    <body>
        <div class="container">
            <h2>UPLOAD RESEPMU YU</h2>
    
            <!-- Form Upload Resep -->
            <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-container">
                    <!-- Kiri: Upload Gambar -->
                    <div class="image-container">
                        <img id="imagePreview" src="https://via.placeholder.com/250" alt="Resep Image">
                        <input type="file" id="imageUpload" name="image" accept="image/*">
                    </div>
    
                    <!-- Kanan: Formulir -->
                    <div class="form">
                        <!-- Input Judul dan Kategori -->
                        <div class="input-group">
                            <input type="text" name="judul" placeholder="JUDUL" required>
                            <input type="text" name="kategori" placeholder="KATEGORI" required>
                        </div>
    
                        <!-- Input Bahan -->
                        <div id="bahan-container">
                            <div class="input-group">
                                <textarea name="bahan[]" placeholder="BAHAN" id="bahan-1" required></textarea>
                            </div>
                        </div>
                        <button id="tambahBahan" type="button">+BAHAN</button>
    
                        <!-- Input Cara Buat -->
                        <div id="cara-container">
                            <div class="input-group">
                                <textarea name="cara[]" placeholder="CARA BUAT" id="cara-1" required></textarea>
                            </div>
                        </div>
                        <button id="tambahCara" type="button">+CARA BUAT</button>
    
                        <!-- Input Deskripsi -->
                        <div class="input-group">
                            <textarea name="deskripsi" placeholder="DESKRIPSI" required></textarea>
                        </div>
    
                        <!-- Tombol Simpan -->
                        <button type="submit" class="submit-btn">SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    
    
        
        <script>
            document.getElementById('tambahBahan').addEventListener('click', function() {
                event.preventDefault();
         // Membuat elemen textarea baru untuk bahan
            const bahanSection = document.createElement('textarea');
            bahanSection.setAttribute('placeholder', 'BAHAN');

        // Menambahkan elemen baru sebelum tombol tambah bahan
            const form = document.querySelector('.form');
            form.insertBefore(bahanSection, document.getElementById('tambahBahan'));
            });


            document.getElementById('tambahCara').addEventListener('click', function() {
            // Membuat elemen textarea baru untuk cara buat
            const caraSection = document.createElement('textarea');
            caraSection.setAttribute('placeholder', 'CARA BUAT');

            // Menambahkan elemen baru sebelum tombol tambah cara
            const form = document.querySelector('.form');
            form.insertBefore(caraSection, document.getElementById('tambahCara'));
            });
        </script>
</body>
</html>

