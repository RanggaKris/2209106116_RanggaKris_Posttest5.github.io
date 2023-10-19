<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_mobil";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $model = $_POST["model"];
    $harga = $_POST["harga"];

    $sql = "UPDATE cars SET model = ?, harga = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sii", $model, $harga, $id);
        if ($stmt->execute()) {
            echo "Data mobil berhasil diperbarui.";
            header("Location: listdatabase.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $car = $result->fetch_assoc();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mobil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h3 {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }

        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        form {
            margin: 20px;
            padding: 20px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h3>Edit Data Mobil</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $car["id"]; ?>">
        <table>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Model:</td>
                <td><input type="text" name="model" value="<?php echo $car["model"]; ?>"></td>
            </tr>
            <tr>
                <td>Harga:</td>
                <td><input type="number" name="harga" value="<?php echo $car["harga"]; ?>"></td>
            </tr>
        </table>
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
