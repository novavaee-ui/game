
<?php
session_start();

// Sistem session untuk menyimpan data permainan

// Membuat angka rahasia secara acak dari 1 sampai 5
if (!isset($_SESSION['angka'])) {
    $_SESSION['angka'] = rand(1, 5);
    $_SESSION['percobaan'] = 0;
}

$x = $_SESSION['angka'];
$pesan = "";
$jenis_pesan = "";
$game_selesai = false;

// Batas maksimal percobaan
$batas_percobaan = 3;

// Tombol reset permainan
if (isset($_POST['reset'])) {

    unset($_SESSION['angka']);
    unset($_SESSION['percobaan']);

    header("Location: tebak.php");
    exit();
}

if (isset($_POST['tebak'])) {

    // Mengambil angka yang dimasukkan pemain
    $tebakan = $_POST['tebak'];

    // Validasi angka tebakan
    if ($tebakan < 1 || $tebakan > 5) {

        $pesan = "⚠️ Masukkan angka antara <strong>1 sampai 5</strong>.";
        $jenis_pesan = "salah";

    } else {

        // Menambah jumlah percobaan
        $_SESSION['percobaan']++;

        $percobaan = $_SESSION['percobaan'];

        // Memeriksa jawaban
        if ($tebakan == $x) {

            $pesan = "🎉 Tebakan Anda Benar!<br>
                      Angka yang benar adalah <strong>$x</strong>";
            $jenis_pesan = "benar";
            $game_selesai = true;

        } elseif ($percobaan >= $batas_percobaan) {

            $pesan = "💀 Tebakan Anda Salah!<br>
                      Kesempatan Anda sudah habis.<br>
                      Angka yang benar adalah <strong>$x</strong>";
            $jenis_pesan = "salah";
            $game_selesai = true;

        } else {

            $sisa = $batas_percobaan - $percobaan;

            $pesan = "⚡ Tebakan Anda Salah!<br>
                      Anda masih memiliki <strong>$sisa kesempatan</strong>.";
            $jenis_pesan = "salah";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cyber Number Game</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background:
                radial-gradient(circle at top, #172554, #020617 60%);
            color: white;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .game-box {
            width: 100%;
            max-width: 500px;
            padding: 35px;
            border: 1px solid #00f7ff;
            border-radius: 20px;
            background: rgba(2, 6, 23, 0.9);
            box-shadow:
                0 0 20px #00f7ff,
                0 0 50px rgba(0, 247, 255, 0.2);
            text-align: center;
        }

        .icon {
            font-size: 60px;
            margin-bottom: 10px;
        }

        h1 {
            color: #00f7ff;
            font-size: 36px;
            letter-spacing: 4px;
            text-shadow: 0 0 15px #00f7ff;
            margin-bottom: 10px;
        }

        .online {
            color: #00ff88;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .rules {
            background: rgba(0, 247, 255, 0.08);
            border: 1px solid rgba(0, 247, 255, 0.3);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            line-height: 1.7;
            color: #cbd5e1;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #00f7ff;
            font-weight: bold;
        }

        input[type="number"] {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #00f7ff;
            background: #020617;
            color: white;
            font-size: 20px;
            text-align: center;
            outline: none;
        }

        input[type="number"]:focus {
            box-shadow: 0 0 15px #00f7ff;
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, #00f7ff, #00ff88);
            color: #020617;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 5px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px #00f7ff;
        }

        .reset-button {
            background: linear-gradient(90deg, #a855f7, #ec4899);
            color: white;
            margin-top: 12px;
        }

        .reset-button:hover {
            box-shadow: 0 0 20px #ec4899;
        }

        .hasil {
            margin-top: 25px;
            padding: 18px;
            border-radius: 12px;
            line-height: 1.6;
            font-size: 16px;
        }

        .benar {
            background: rgba(0, 255, 136, 0.12);
            border: 1px solid #00ff88;
            color: #00ff88;
        }

        .salah {
            background: rgba(255, 0, 80, 0.12);
            border: 1px solid #ff0055;
            color: #ff4d88;
        }

        footer {
            margin-top: 25px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>

<body>

<div class="game-box">

    <div class="icon">🎯</div>

    <h1>CYBER NUMBER</h1>

    <div class="online">
        ● GAME ONLINE
    </div>

    <div class="rules">
        Tebak angka rahasia dari <strong>1 sampai 5</strong>.<br>
        Kamu memiliki <strong>3 kesempatan</strong> untuk menebak.
    </div>

    <?php if (!$game_selesai) { ?>

        <form method="POST">

            <div class="input-group">

                <label for="tebak">
                    MASUKKAN TEBAKAN
                </label>

                <input
                    type="number"
                    id="tebak"
                    name="tebak"
                    min="1"
                    max="5"
                    required
                    placeholder="1 - 5"
                >

            </div>

            <button type="submit">
                🚀 TEBAK SEKARANG
            </button>

        </form>

    <?php } ?>

    <?php if ($pesan != "") { ?>

        <div class="hasil <?php echo $jenis_pesan; ?>">
            <?php echo $pesan; ?>
        </div>

    <?php } ?>

    <?php if ($game_selesai) { ?>

        <form method="POST">

            <button
                type="submit"
                name="reset"
                class="reset-button"
            >
                🔄 MAIN LAGI
            </button>

        </form>

    <?php } ?>

    <footer>
        CYBER NUMBER GAME © 2026
    </footer>

</div>

</body>
</html>

