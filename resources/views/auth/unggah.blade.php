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
    <div class="container">
        <h2>Upload Resepmu Yu</h2>
        <form action="/upload" method="POST" enctype="multipart/form-data">
            <div class="left-column">
                <img src="https://via.placeholder.com/250" alt="Gambar Resep" class="recipe-image">
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="right-column">
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" id="title" name="title" placeholder="Judul Resep" required>
                    
                    <label for="category">Kategori</label>
                    <input type="text" id="category" name="category" placeholder="Kategori Resep" required>
                </div>
                
                <div class="form-group">
                    <label for="ingredients">Bahan</label>
                    <textarea id="ingredients" name="ingredients" rows="5" placeholder="Bahan-bahan" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="5" placeholder="Deskripsi Resep" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="instructions">Cara Buat</label>
                    <textarea id="instructions" name="instructions" rows="6" placeholder="Cara Membuat" required></textarea>
                </div>
                
                <button type="submit" class="submit-button">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>

