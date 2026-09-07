
<?php
session_start();

/* ==============================
   SISTEM GAME
   ============================== */

// Membuat angka rahasia hanya sekali
if (!isset($_SESSION['angka'])) {
    $_SESSION['angka'] = rand(1, 5);
    $_SESSION['percobaan'] = 0;
}

$x = $_SESSION['angka'];
$pesan = "";
$jenis_pesan = "";
$game_selesai = false;

$batas_percobaan = 3;


/* ==============================
   RESET PERMAINAN
   ============================== */

if (isset($_POST['reset'])) {

    unset($_SESSION['angka']);
    unset($_SESSION['percobaan']);

    header("Location: tebak.php");
    exit();
}


/* ==============================
   PROSES TEBAKAN
   ============================== */

if (isset($_POST['tebak'])) {

    $tebakan = $_POST['tebak'];

    // Validasi angka
    if ($tebakan < 1 || $tebakan > 5) {

        $pesan = "⚠️ Masukkan angka antara <strong>1 sampai 5</strong>.";
        $jenis_pesan = "salah";

    } else {

        // Menambah jumlah percobaan
        $_SESSION['percobaan']++;

        $percobaan = $_SESSION['percobaan'];

        // Jika jawaban benar
        if ($tebakan == $x) {

            $pesan = "🎉 Tebakan Anda Benar!<br>
                      Angka yang benar adalah <strong>$x</strong>";

            $jenis_pesan = "benar";
            $game_selesai = true;

        }

        // Jika kesempatan habis
        elseif ($percobaan >= $batas_percobaan) {

            $pesan = "💀 Tebakan Anda Salah!<br>
                      Kesempatan Anda sudah habis.<br>
                      Angka yang benar adalah <strong>$x</strong>";

            $jenis_pesan = "salah";
            $game_selesai = true;

        }

        // Jika masih ada kesempatan
        else {

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

/* ==============================
   RESET
   ============================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* ==============================
   BODY
   ============================== */

body {

    min-height: 100vh;

    display: flex;

    justify-content: center;

    align-items: center;

    font-family: Arial, Helvetica, sans-serif;

    background:
        radial-gradient(circle at top left, #123c52, transparent 35%),
        radial-gradient(circle at bottom right, #102e24, transparent 35%),
        #050b12;

    color: white;

    padding: 20px;
}


/* ==============================
   CONTAINER
   ============================== */

.game-container {

    width: 100%;

    max-width: 500px;

}


/* ==============================
   GAME BOX
   ============================== */

.game-box {

    position: relative;

    background: rgba(7, 18, 27, 0.95);

    border: 1px solid #00f7ff;

    border-radius: 20px;

    padding: 35px;

    box-shadow:
        0 0 15px rgba(0, 247, 255, 0.4),
        0 0 40px rgba(0, 247, 255, 0.15);

    overflow: hidden;
}


/* ==============================
   NEON LINE
   ============================== */

.game-box::before {

    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;

    height: 4px;

    background: linear-gradient(
        90deg,
        #00f7ff,
        #00ff88,
        #00f7ff
    );

    box-shadow: 0 0 15px #00f7ff;
}


/* ==============================
   HEADER
   ============================== */

.game-header {

    text-align: center;

    margin-bottom: 30px;
}


.icon {

    font-size: 55px;

    margin-bottom: 10px;

    filter:
        drop-shadow(0 0 10px #00f7ff);
}


h1 {

    font-size: 30px;

    letter-spacing: 4px;

    color: #00f7ff;

    text-shadow:
        0 0 10px #00f7ff,
        0 0 20px #00f7ff;

    margin-bottom: 10px;
}


.online {

    color: #00ff88;

    font-size: 13px;

    letter-spacing: 2px;

    text-shadow: 0 0 8px #00ff88;
}


/* ==============================
   INFO GAME
   ============================== */

.game-info {

    text-align: center;

    margin-bottom: 25px;

    padding: 15px;

    border-radius: 12px;

    background: rgba(0, 247, 255, 0.05);

    border: 1px solid rgba(0, 247, 255, 0.2);

    line-height: 1.7;

    color: #c7e8ec;
}


.game-info strong {

    color: #00f7ff;

}


/* ==============================
   FORM
   ============================== */

form {

    display: flex;

    flex-direction: column;

    gap: 15px;
}


label {

    font-size: 14px;

    color: #9ed9df;

    text-align: center;
}


/* ==============================
   INPUT
   ============================== */

input[type="number"] {

    width: 100%;

    padding: 16px;

    background: #02070b;

    border: 1px solid #00f7ff;

    border-radius: 10px;

    color: #ffffff;

    font-size: 22px;

    text-align: center;

    outline: none;

    box-shadow:
        inset 0 0 10px rgba(0, 247, 255, 0.08);

    transition: 0.3s;
}


input[type="number"]:focus {

    border-color: #00ff88;

    box-shadow:
        0 0 10px rgba(0, 255, 136, 0.5),
        inset 0 0 10px rgba(0, 255, 136, 0.08);
}


input[type="number"]::placeholder {

    color: #547078;
}


/* ==============================
   BUTTON TEBAK
   ============================== */

button {

    border: none;

    border-radius: 10px;

    padding: 15px;

    font-size: 15px;

    font-weight: bold;

    cursor: pointer;

    color: #001014;

    background: linear-gradient(
        90deg,
        #00f7ff,
        #00ff88
    );

    box-shadow:
        0 0 12px rgba(0, 247, 255, 0.4);

    transition: 0.3s;
}


button:hover {

    transform: translateY(-2px);

    box-shadow:
        0 0 20px rgba(0, 247, 255, 0.7);
}


button:active {

    transform: scale(0.98);
}


/* ==============================
   HASIL
   ============================== */

.hasil {

    margin-top: 25px;

    padding: 20px;

    border-radius: 12px;

    text-align: center;

    line-height: 1.8;

    font-size: 15px;
}


/* ==============================
   HASIL BENAR
   ============================== */

.benar {

    background: rgba(0, 255, 136, 0.08);

    border: 1px solid #00ff88;

    color: #00ff88;

    box-shadow:
        0 0 15px rgba(0, 255, 136, 0.2);
}


/* ==============================
   HASIL SALAH
   ============================== */

.salah {

    background: rgba(255, 50, 100, 0.08);

    border: 1px solid #ff3264;

    color: #ff6b8c;

    box-shadow:
        0 0 15px rgba(255, 50, 100, 0.15);
}


/* ==============================
   RESET BUTTON
   ============================== */

.reset-form {

    margin-top: 15px;
}


.reset-button {

    width: 100%;

    background: linear-gradient(
        90deg,
        #8b5cf6,
        #ec4899
    );

    color: white;

    box-shadow:
        0 0 12px rgba(236, 72, 153, 0.4);
}


.reset-button:hover {

    box-shadow:
        0 0 20px rgba(236, 72, 153, 0.7);
}


/* ==============================
   FOOTER
   ============================== */

.game-footer {

    margin-top: 25px;

    text-align: center;

    font-size: 12px;

    color: #58737a;

    letter-spacing: 1px;
}


/* ==============================
   RESPONSIVE
   ============================== */

@media (max-width: 600px) {

    body {

        padding: 15px;
    }

    .game-box {

        padding: 25px 20px;
    }

    h1 {

        font-size: 24px;

        letter-spacing: 3px;
    }

    .icon {

        font-size: 45px;
    }
}

</style>

</head>


<body>


<div class="game-container">

    <div class="game-box">


        <!-- HEADER -->

        <div class="game-header">

            <div class="icon">🎯</div>

            <h1>CYBER NUMBER</h1>

            <div class="online">
                ● GAME ONLINE
            </div>

        </div>


        <!-- INFORMASI GAME -->

        <div class="game-info">

            Tebak angka rahasia dari

            <strong>1 sampai 5</strong>.

            <br>

            Anda memiliki

            <strong>3 kesempatan</strong>

            untuk menemukan angka yang benar.

        </div>


        <!-- FORM TEBAK -->

        <?php if (!$game_selesai) { ?>

        <form method="POST">

            <label for="tebakan">
                Masukkan angka tebakan Anda
            </label>


            <input
                type="number"
                id="tebakan"
                name="tebak"
                min="1"
                max="5"
                placeholder="1 - 5"
                required
            >


            <button type="submit">
                🚀 TEBAK SEKARANG
            </button>

        </form>

        <?php } ?>


        <!-- HASIL -->

        <?php if ($pesan != "") { ?>

        <div class="hasil <?php echo $jenis_pesan; ?>">

            <?php echo $pesan; ?>

        </div>

        <?php } ?>


        <!-- RESET -->

        <?php if ($game_selesai) { ?>

        <form method="POST" class="reset-form">

            <button
                type="submit"
                name="reset"
                class="reset-button"
            >
                🔄 MAIN LAGI
            </button>

        </form>

        <?php } ?>


        <!-- FOOTER -->

        <div class="game-footer">

            CYBER NUMBER GAME • PHP SESSION

        </div>


    </div>

</div>


</body>

</html>

