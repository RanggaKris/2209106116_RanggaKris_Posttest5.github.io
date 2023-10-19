<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST["model"];
    $harga = $_POST["harga"];

    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "db_mobil"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    $sql = "INSERT INTO cars (model, harga) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $model, $harga); 
        if ($stmt->execute()) {
            echo "Mobil berhasil ditambahkan ke database.";
            header("Location: listdatabase.php"); 
            exit(); 
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<a href="listdatabase.php">klik untuk kembali</a>
