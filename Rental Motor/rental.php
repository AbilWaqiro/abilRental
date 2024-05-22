<!-- start php -->
<?php
session_start();

class Motor {
    private $harga;
    private $isMember;
    public $pajak = 10000;

    public function __construct($harga, $isMember = false) {
        $this->harga = $harga;
        $this->isMember = $isMember;
    }

    public function hitungTotalHarga($lamaWaktu) {
        $memberDiscount = 0.05;
        $nonMemberPrice = $this->harga * $lamaWaktu;

        if ($this->isMember) {
            $subTotal = $nonMemberPrice * (1 - $memberDiscount);
        } else {
            $subTotal = $nonMemberPrice;
        }

        $totalHarga = $subTotal + $this->pajak;
        return $totalHarga;
    }
}

$hargaMotor = [
    "supra" => 50000,
    "vario" => 70000,
    "nmax" => 90000,
    "zx25r" => 120000
];

$memberList = ["udin", "hendro", "rahmat"];

$result="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaPelanggan = $_POST["namaPelanggan"];
    $lamaWaktu = $_POST["lamaWaktu"];
    $jenisMotor = $_POST["jenisMotor"];

    // Basic validation
    if (empty($namaPelanggan) || empty($lamaWaktu) || empty($jenisMotor) || !is_numeric($lamaWaktu)) {
        $result = "Please fill in all fields correctly.";
    } else {
        $harga = isset($hargaMotor[$jenisMotor]) ? $hargaMotor[$jenisMotor] : 0;

        $isMember = in_array($namaPelanggan, $memberList);

        $motor = new Motor($harga, $isMember);

        $totalHarga = $motor->hitungTotalHarga($lamaWaktu);

        $result = "<br>$namaPelanggan " . ($isMember ? "berstatus sebagai member mendapatkan diskon sebanyak 5%<br>" : "bukan member<br>") . "jenis motor yang dirental adalah $jenisMotor selama $lamaWaktu hari<br>Harga rental per harinya adalah: Rp. " . number_format($harga, 3) . "<br><br>Besar yang harus dibayarkan adalah: Rp. " . number_format($totalHarga, 3);
    }
}
?>
<!-- end php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        select {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 4px;
            text-align : center;
        }
    </style>
<body>
<div class="container">
    <h1>Rental Motor</h1>
    <form action="" method="POST">
        <label for="namaPelanggan">Nama Pelanggan:</label>
        <input type="text" id="namaPelanggan" name="namaPelanggan" required>
        
        <label for="lamaWaktu">Lama Waktu (hari):</label>
        <input type="number" id="lamaWaktu" name="lamaWaktu" required>
        
        <label for="jenisMotor">Jenis Motor:</label>
        <select id="jenisMotor" name="jenisMotor" required>
            <option value="">Pilih jenis motor</option>
            <option value="supra">Supra</option>
            <option value="vario">Vario</option>
            <option value="nmax">Nmax</option>
            <option value="zx25r">ZX25R</option>
        </select>
        
        <input type="submit" value="Submit">
    </form>
    <div class="result">
        <?php echo $result; ?>
    </div>
</div>
</body>
</html>