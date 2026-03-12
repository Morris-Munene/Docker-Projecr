<?php
$name = '';
$greeted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username'])) {
    $name = htmlspecialchars(trim($_POST['username']));
    $greeted = true;
}

$hour = (int)date('H');
if ($hour >= 5 && $hour < 12) {
    $timeGreeting = "Good morning";
    $emoji = "🌤️";
} elseif ($hour >= 12 && $hour < 17) {
    $timeGreeting = "Good afternoon";
    $emoji = "☀️";
} elseif ($hour >= 17 && $hour < 21) {
    $timeGreeting = "Good evening";
    $emoji = "🌇";
} else {
    $timeGreeting = "Good night";
    $emoji = "🌙";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello There</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #e0e5ec;
            --shadow-dark: #a3b1c6;
            --shadow-light: #ffffff;
            --accent: #6c8ebf;
            --accent-dark: #4a6fa5;
            --text-main: #3a4a5c;
            --text-muted: #7a8fa6;
            --font: 'Nunito', sans-serif;
        }

        body {
            background-color: var(--bg);
            font-family: var(--font);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: var(--bg);
            border-radius: 28px;
            padding: 50px 44px;
            width: 100%;
            max-width: 440px;
            box-shadow:
                10px 10px 30px var(--shadow-dark),
                -10px -10px 30px var(--shadow-light);
            text-align: center;
            animation: fadeUp 0.6s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .icon-wrap {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--bg);
            box-shadow:
                6px 6px 16px var(--shadow-dark),
                -6px -6px 16px var(--shadow-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            font-size: 2.2rem;
        }

        h1 {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .subtitle {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 36px;
            font-weight: 400;
        }

        /* ── Input ── */
        .input-wrap {
            position: relative;
            margin-bottom: 28px;
        }

        input[type="text"] {
            width: 100%;
            padding: 16px 20px;
            font-family: var(--font);
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-main);
            background: var(--bg);
            border: none;
            border-radius: 14px;
            outline: none;
            box-shadow:
                inset 5px 5px 12px var(--shadow-dark),
                inset -5px -5px 12px var(--shadow-light);
            transition: box-shadow 0.25s ease;
        }

        input[type="text"]::placeholder {
            color: var(--text-muted);
            font-weight: 400;
        }

        input[type="text"]:focus {
            box-shadow:
                inset 6px 6px 14px var(--shadow-dark),
                inset -6px -6px 14px var(--shadow-light),
                0 0 0 3px rgba(108,142,191,0.25);
        }

        /* ── Button ── */
        button {
            width: 100%;
            padding: 16px;
            font-family: var(--font);
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border: none;
            border-radius: 14px;
            cursor: pointer;
            box-shadow:
                5px 5px 14px var(--shadow-dark),
                -3px -3px 10px var(--shadow-light);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow:
                8px 8px 20px var(--shadow-dark),
                -4px -4px 14px var(--shadow-light);
        }

        button:active {
            transform: translateY(1px);
            box-shadow:
                3px 3px 8px var(--shadow-dark),
                -2px -2px 6px var(--shadow-light);
        }

        /* ── Greeting result ── */
        .greeting-box {
            background: var(--bg);
            border-radius: 20px;
            padding: 32px 24px;
            box-shadow:
                inset 4px 4px 12px var(--shadow-dark),
                inset -4px -4px 12px var(--shadow-light);
            animation: popIn 0.5s cubic-bezier(.34,1.56,.64,1) both;
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.88); }
            to   { opacity: 1; transform: scale(1); }
        }

        .greeting-emoji {
            font-size: 2.8rem;
            margin-bottom: 14px;
            display: block;
            animation: wave 1.4s ease-in-out 0.3s 2;
            transform-origin: 70% 80%;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg);  }
            20%       { transform: rotate(18deg); }
            40%       { transform: rotate(-10deg);}
            60%       { transform: rotate(14deg); }
            80%       { transform: rotate(-6deg); }
        }

        .greeting-time {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 6px;
        }

        .greeting-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 10px;
        }

        .greeting-name span {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .greeting-msg {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .try-again {
            display: inline-block;
            margin-top: 24px;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-muted);
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 10px;
            background: var(--bg);
            box-shadow:
                4px 4px 10px var(--shadow-dark),
                -4px -4px 10px var(--shadow-light);
            transition: all 0.2s ease;
        }

        .try-again:hover {
            color: var(--accent);
            box-shadow:
                6px 6px 14px var(--shadow-dark),
                -5px -5px 12px var(--shadow-light);
        }

        /* ── Divider dots ── */
        .dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 28px 0 0;
        }

        .dots span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--shadow-dark);
            box-shadow:
                2px 2px 4px var(--shadow-dark),
                -1px -1px 3px var(--shadow-light);
        }

        .dots span:nth-child(2) { opacity: 0.6; }
        .dots span:nth-child(3) { opacity: 0.3; }
    </style>
</head>
<body>

<div class="card">

    <?php if (!$greeted): ?>

        <div class="icon-wrap">👋</div>
        <h1>Hello, stranger!</h1>
        <p class="subtitle">Tell me your name and I'll greet you properly.</p>

        <form method="POST" action="">
            <div class="input-wrap">
                <input
                    type="text"
                    name="username"
                    placeholder="Enter your name…"
                    maxlength="50"
                    autocomplete="off"
                    autofocus
                    required
                >
            </div>
            <button type="submit">Greet me ✨</button>
        </form>

        <div class="dots">
            <span></span><span></span><span></span>
        </div>

    <?php else: ?>

        <div class="greeting-box">
            <span class="greeting-emoji"><?= $emoji ?></span>
            <p class="greeting-time"><?= $timeGreeting ?></p>
            <p class="greeting-name">Hello, <span><?= $name ?>!</span></p>
            <p class="greeting-msg">
                Wonderful to have you here.<br>
                Hope your day is going beautifully.
            </p>
        </div>

        <a class="try-again" href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">← Try another name</a>

    <?php endif; ?>

</div>

</body>
</html>