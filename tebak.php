
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

$batas_percobaan = 3;

// Reset permainan
if (isset($_POST['reset'])) {

    unset($_SESSION['angka']);
    unset($_SESSION['percobaan']);

    header("Location: tebak.php");
    exit();
}

// Proses tebakan
if (isset($_POST['tebak'])) {

    $tebakan = $_POST['tebak'];

    // Validasi angka
    if ($tebakan < 1 || $tebakan > 5) {

        $pesan = "⚠️ Masukkan angka antara <strong>1 sampai 5</strong>.";
        $jenis_pesan = "salah";

    } else {

        $_SESSION['percobaan']++;

        $percobaan = $_SESSION['percobaan'];

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

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Cyber Number Game</title>

<style>

/* =========================
   RESET
========================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* =========================
   BODY
========================= */

body {

    font-family: Arial, sans-serif;

    min-height: 100vh;

    display: flex;

    justify-content: center;

    align-items: center;

    padding: 20px;

    color: white;

    background:
        radial-gradient(
            circle at 20% 20%,
            rgba(0, 247, 255, 0.15),
            transparent 30%
        ),
        radial-gradient(
            circle at 80% 80%,
            rgba(168, 85, 247, 0.15),
            transparent 30%
        ),
        linear-gradient(
            135deg,
            #020617,
            #0f172a,
            #020617
        );

}


/* =========================
   CONTAINER
========================= */

.game-container {

    width: 100%;

    max-width: 520px;

}


/* =========================
   GAME BOX
========================= */

.game-box {

    position: relative;

    padding: 35px;

    border: 1px solid #00f7ff;

    border-radius: 22px;

    background:
        rgba(2, 6, 23, 0.92);

    box-shadow:

        0 0 10px #00f7ff,

        0 0 30px rgba(0, 247, 255, 0.4),

        0 0 80px rgba(0, 247, 255, 0.15);

    text-align: center;

    overflow: hidden;

}


/* =========================
   GARIS NEON
========================= */

.game-box::before {

    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 2px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #00f7ff,
            transparent
        );

    box-shadow:
        0 0 15px #00f7ff;

}


/* =========================
   HEADER
========================= */

.game-header {

    margin-bottom: 25px;

}

.icon {

    font-size: 65px;

    margin-bottom: 10px;

    filter:
        drop-shadow(0 0 12px #00f7ff);

}


h1 {

    color: #00f7ff;

    font-size: 36px;

    letter-spacing: 5px;

    text-shadow:

        0 0 5px #00f7ff,

        0 0 15px #00f7ff,

        0 0 30px #00f7ff;

    margin-bottom: 12px;

}


.online {

    color: #00ff88;

    font-size: 14px;

    letter-spacing: 2px;

    text-shadow:
        0 0 8px #00ff88;

}


/* =========================
   INFO GAME
========================= */

.game-info {

    background:
        rgba(0, 247, 255, 0.06);

    border:

        1px solid
        rgba(0, 247, 255, 0.35);

    border-radius: 14px;

    padding: 18px;

    margin-bottom: 25px;

    line-height: 1.8;

    color: #cbd5e1;

    box-shadow:

        inset 0 0 20px
        rgba(0, 247, 255, 0.04);

}


.game-info strong {

    color: #00f7ff;

    text-shadow:
        0 0 8px #00f7ff;

}


/* =========================
   INPUT
========================= */

.input-group {

    margin-bottom: 20px;

}


label {

    display: block;

    margin-bottom: 12px;

    color: #00f7ff;

    font-weight: bold;

    letter-spacing: 1px;

}


input[type="number"] {

    width: 100%;

    padding: 16px;

    border-radius: 12px;

    border: 1px solid #00f7ff;

    background: #020617;

    color: white;

    font-size: 22px;

    text-align: center;

    outline: none;

    box-shadow:

        inset 0 0 15px
        rgba(0, 247, 255, 0.08),

        0 0 8px
        rgba(0, 247, 255, 0.2);

    transition: 0.3s;

}


input[type="number"]:focus {

    border-color: #00ff88;

    box-shadow:

        0 0 10px #00f7ff,

        0 0 25px
        rgba(0, 247, 255, 0.4);

}


/* =========================
   BUTTON
========================= */

button {

    width: 100%;

    padding: 16px;

    border: none;

    border-radius: 12px;

    background:
        linear-gradient(
            90deg,
            #00f7ff,
            #00ff88
        );

    color: #020617;

    font-size: 18px;

    font-weight: bold;

    letter-spacing: 1px;

    cursor: pointer;

    transition: 0.3s;

    box-shadow:

        0 0 10px
        rgba(0, 247, 255, 0.5);

}


button:hover {

    transform:
        translateY(-3px);

    box-shadow:

        0 0 10px #00f7ff,

        0 0 30px #00f7ff;

}


button:active {

    transform:
        translateY(0);

}


/* =========================
   HASIL
========================= */

.hasil {

    margin-top: 25px;

    padding: 20px;

    border-radius: 14px;

    line-height: 1.7;

    font-size: 16px;

    animation:
        muncul 0.4s ease;

}


@keyframes muncul {

    from {

        opacity: 0;

        transform:
            translateY(10px);

    }

    to {

        opacity: 1;

        transform:
            translateY(0);

    }

}


/* =========================
   HASIL BENAR
========================= */

.benar {

    background:
        rgba(0, 255, 136, 0.1);

    border:
        1px solid #00ff88;

    color: #00ff88;

    box-shadow:

        0 0 10px
        rgba(0, 255, 136, 0.4),

        inset 0 0 15px
        rgba(0, 255, 136, 0.05);

}


/* =========================
   HASIL SALAH
========================= */

.salah {

    background:
        rgba(255, 0, 80, 0.1);

    border:
        1px solid #ff0055;

    color: #ff4d88;

    box-shadow:

        0 0 10px
        rgba(255, 0, 80, 0.4),

        inset 0 0 15px
        rgba(255, 0, 80, 0.05);

}


/* =========================
   RESET BUTTON
========================= */

.reset-button {

    margin-top: 12px;

    background:
        linear-gradient(
            90deg,
            #a855f7,
            #ec4899
        );

    color: white;

    box-shadow:

        0 0 10px
        rgba(236, 72, 153, 0.5);

}


.reset-button:hover {

    box-shadow:

        0 0 10px #ec4899,

        0 0 30px #ec4899;

}


/* =========================
   FOOTER
========================= */

.game-footer {

    margin-top: 25px;

    font-size: 12px;

    color: #64748b;

    letter-spacing: 1px;

}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 600px) {

    .game-box {

        padding: 25px;

    }

    h1 {

        font-size: 28px;

        letter-spacing: 3px;

    }

    .icon {

        font-size: 50px;

    }

}

</style>

</head>


<body>


<div class="game-container">

    <div class="game-box">


        <!-- HEADER -->

        <header class="game-header">

            <div class="icon">
                🎯
            </div>

            <h1>
                CYBER NUMBER
            </h1>

            <div class="online">
                ● GAME ONLINE
            </div>

        </header>


        <!-- INFORMASI -->

        <section class="game-info">

            Tebak angka rahasia dari
            <strong>1 sampai 5</strong>.

            <br>

            Kamu memiliki
            <strong>3 kesempatan</strong>
            untuk menebak.

        </section>


        <!-- GAME -->

        <main class="game-content">


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


            <!-- HASIL -->

            <?php if ($pesan != "") { ?>

                <div
                    class="hasil <?php echo $jenis_pesan; ?>"
                >

                    <?php echo $pesan; ?>

                </div>

            <?php } ?>


            <!-- RESET -->

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


        </main>


        <!-- FOOTER -->

        <footer class="game-footer">

            CYBER NUMBER GAME © 2026

        </footer>


    </div>

</div>


</body>

</html>

