```php
<?php
session_start();

// Membuat angka rahasia hanya sekali
if (!isset($_SESSION['angka'])) {
    $_SESSION['angka'] = rand(1, 5);
    $_SESSION['percobaan'] = 0;
}

$x = $_SESSION['angka'];
$pesan = "";
$jenis_pesan = "";

if (isset($_POST['tebak'])) {

    $_SESSION['percobaan']++;

    $tebakan = $_POST['tebak'];
    $percobaan = $_SESSION['percobaan'];

    if ($tebakan == $x) {

        $pesan = "🎉 Tebakan Anda Benar!<br>
                  Angka yang benar adalah <strong>$x</strong>";
        $jenis_pesan = "benar";

        // Reset game
        unset($_SESSION['angka']);
        unset($_SESSION['percobaan']);

    } elseif ($percobaan >= 3) {

        $pesan = "💀 Tebakan Anda Salah!<br>
                  Kesempatan Anda sudah habis.<br>
                  Angka yang benar adalah <strong>$x</strong>";
        $jenis_pesan = "salah";

        // Reset game
        unset($_SESSION['angka']);
        unset($_SESSION['percobaan']);

    } else {

        $sisa = 3 - $percobaan;

        $pesan = "⚡ Tebakan Anda Salah!<br>
                  Anda masih memiliki <strong>$sisa kesempatan</strong>.";
        $jenis_pesan = "salah";
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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:
                radial-gradient(circle at top left, #1e3a8a, transparent 35%),
                radial-gradient(circle at bottom right, #581c87, transparent 35%),
                #050816;
            color: white;
            overflow: hidden;
        }

        /* Efek background */

        body::before {
            content: "";
            position: fixed;
            width: 300px;
            height: 300px;
            background: #00e5ff;
            filter: blur(150px);
            opacity: 0.15;
            top: -100px;
            left: -100px;
        }

        body::after {
            content: "";
            position: fixed;
            width: 300px;
            height: 300px;
            background: #a855f7;
            filter: blur(150px);
            opacity: 0.15;
            bottom: -100px;
            right: -100px;
        }

        .container {
            width: 430px;
            padding: 35px;
            border-radius: 25px;

            background: rgba(15, 23, 42, 0.90);

            border: 1px solid rgba(0, 229, 255, 0.25);

            box-shadow:
                0 0 30px rgba(0, 229, 255, 0.12),
                0 25px 60px rgba(0, 0, 0, 0.6);

            text-align: center;

            position: relative;
            z-index: 2;
        }

        .icon {
            width: 85px;
            height: 85px;

            margin: 0 auto 18px;

            display: flex;
            justify-content: center;
            align-items: center;

            border-radius: 50%;

            font-size: 42px;

            background: linear-gradient(
                135deg,
                #06b6d4,
                #7c3aed
            );

            box-shadow:
                0 0 25px rgba(6, 182, 212, 0.4);

            animation: float 2s infinite ease-in-out;
        }

        @keyframes float {

            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }

        }

        h1 {
            font-size: 30px;
            margin-bottom: 8px;

            background: linear-gradient(
                90deg,
                #22d3ee,
                #a78bfa
            );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .deskripsi {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .aturan {
            text-align: left;

            background: rgba(30, 41, 59, 0.8);

            border: 1px solid rgba(148, 163, 184, 0.15);

            padding: 17px;

            border-radius: 15px;

            margin-bottom: 22px;

            color: #cbd5e1;

            font-size: 14px;

            line-height: 1.8;
        }

        .aturan strong {
            color: #22d3ee;
        }

        .input-label {
            display: block;

            text-align: left;

            margin-bottom: 8px;

            color: #cbd5e1;

            font-size: 14px;

            font-weight: bold;
        }

        input {
            width: 100%;

            padding: 15px;

            border-radius: 12px;

            border: 2px solid #334155;

            outline: none;

            background: #0f172a;

            color: white;

            font-size: 18px;

            text-align: center;

            transition: 0.3s;

            margin-bottom: 15px;
        }

        input::placeholder {
            color: #64748b;
        }

        input:focus {
            border-color: #22d3ee;

            box-shadow:
                0 0 15px rgba(34, 211, 238, 0.25);
        }

        button {
            width: 100%;

            padding: 15px;

            border: none;

            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #06b6d4,
                #7c3aed
            );

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;

            box-shadow:
                0 8px 20px rgba(124, 58, 237, 0.3);
        }

        button:hover {
            transform: translateY(-2px);

            box-shadow:
                0 12px 25px rgba(6, 182, 212, 0.35);
        }

        button:active {
            transform: scale(0.98);
        }

        .hasil {
            margin-top: 20px;

            padding: 17px;

            border-radius: 12px;

            line-height: 1.7;

            font-size: 14px;

            animation: muncul 0.4s ease;
        }

        @keyframes muncul {

            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        .benar {
            background: rgba(34, 197, 94, 0.12);

            border: 1px solid rgba(34, 197, 94, 0.4);

            color: #86efac;

            box-shadow:
                0 0 15px rgba(34, 197, 94, 0.08);
        }

        .salah {
            background: rgba(239, 68, 68, 0.12);

            border: 1px solid rgba(239, 68, 68, 0.4);

            color: #fca5a5;

            box-shadow:
                0 0 15px rgba(239, 68, 68, 0.08);
        }

        .footer {
            margin-top: 25px;

            color: #64748b;

            font-size: 12px;

            padding-top: 15px;

            border-top: 1px solid rgba(148, 163, 184, 0.1);
        }

        .status {
            display: inline-block;

            margin-top: 8px;

            padding: 5px 12px;

            border-radius: 20px;

            background: rgba(34, 211, 238, 0.1);

            color: #22d3ee;

            font-size: 11px;
        }

        @media (max-width: 500px) {

            .container {
                width: 90%;
                padding: 28px 22px;
            }

            h1 {
                font-size: 25px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="icon">
        🎯
    </div>

    <h1>CYBER NUMBER</h1>

    <p class="deskripsi">
        Tantang keberuntunganmu dan temukan angka rahasia!
    </p>

    <div class="status">
        ● GAME ONLINE
    </div>

    <div class="aturan">

        <strong>⚡ MISSION RULES</strong><br>

        🎯 Angka rahasia: <b>1 – 5</b><br>

        ❤️ Kesempatan bermain: <b>3 kali</b><br>

        🔐 Angka rahasia tetap selama permainan

    </div>

    <form method="post">

        <label class="input-label">
            MASUKKAN ANGKA
        </label>

        <input
            type="number"
            name="tebak"
            min="1"
            max="5"
            placeholder="1 - 5"
            required
        >

        <button type="submit">
            🚀 SUBMIT TEBAKAN
        </button>

    </form>

    <?php if ($pesan != "") { ?>

        <div class="hasil <?php echo $jenis_pesan; ?>">

            <?php echo $pesan; ?>

        </div>

    <?php } ?>

    <div class="footer">

        🎮 CYBER NUMBER GAME
        <br>
        Powered by PHP

    </div>

</div>

</body>
</html>
```
