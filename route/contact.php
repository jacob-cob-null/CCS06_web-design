<?php
// CONTROLLER
require_once '../db/db_conn.php';
require_once '../db/data_loader.php';

function verifyTurnstileToken($secretKey, $token, $remoteIp)
{
    if ($token === '' || $secretKey === '') {
        return false;
    }

    $payload = http_build_query([
        'secret' => $secretKey,
        'response' => $token,
        'remoteip' => $remoteIp,
    ]);

    $responseBody = '';

    if (function_exists('curl_init')) {
        $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $responseBody = curl_exec($ch);
        curl_close($ch);
    } else {
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => $payload,
                'timeout' => 10,
            ],
        ]);
        $responseBody = @file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, $context);
    }

    if (!$responseBody) {
        return false;
    }

    $decoded = json_decode($responseBody, true);
    return is_array($decoded) && !empty($decoded['success']);
}

$content = loadSiteContent();
$siteContent = $content['siteContent']['contact'] ?? [];
$navItems = $content['siteContent']['navigation'] ?? [];

$pageTitle = $siteContent['title'] ?? '';
$contactHeading = $siteContent['heading'] ?? '';
$contactSubheading = $siteContent['subheading'] ?? '';
$formLabels = $siteContent['labels'] ?? [];
$captchaContent = $siteContent['captcha'] ?? [];
$successMessage = $siteContent['successMessage'] ?? '';
$errorMessage = $siteContent['errorMessage'] ?? '';
$returnHomeText = $siteContent['returnHome'] ?? '';
$activeNavKey = 'contact';

$captchaHeading = $captchaContent['heading'] ?? 'Human Verification';
$captchaLabel = $captchaContent['label'] ?? 'Complete the captcha to continue';
$captchaErrorMessage = $captchaContent['errorMessage'] ?? 'Incorrect CAPTCHA. Please try again.';
$captchaSiteKey = $captchaContent['siteKey'] ?? '1x00000000000000000000AA';
$captchaSecretKey = $captchaContent['secretKey'] ?? '1x0000000000000000000000000000000AA';

$showThankYou = false;
$showError = false;
$showCaptchaError = false;

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $captchaToken = trim($_POST['cf-turnstile-response'] ?? '');
    $remoteIp = $_SERVER['REMOTE_ADDR'] ?? '';
    $captchaValid = verifyTurnstileToken($captchaSecretKey, $captchaToken, $remoteIp);

    if (!$captchaValid) {
        $showCaptchaError = true;
    } else {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

        if (mysqli_query($conn, $sql)) {
            $showThankYou = true;
        } else {
            $showError = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Mulish:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(10px);
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="absolute top-0 h-screen w-screen overflow-hidden text-white antialiased" style="background-color:#020617; font-family: 'Inter', sans-serif;">
    <div class="absolute top-0 left-0 h-screen w-screen z-[-10] pointer-events-none" style="background: radial-gradient(ellipse 80% 80% at 50% -20%, rgba(37,99,235,0.7) 0%, rgba(29,78,216,0.4) 30%, rgba(30,58,138,0.15) 55%, rgba(0,0,0,0) 85%);"></div>

    <nav class="w-full flex justify-center py-8 fade-in h-[100px] sticky top-0 z-50">
        <div class="flex gap-8 items-center px-8 py-3 rounded-full bg-white/5 border border-white/10 backdrop-blur-xl shadow-lg transition-all">
            <?php foreach ($navItems as $key => $item): ?>
                <a href="<?php echo htmlspecialchars($item['href'] ?? ''); ?>" class="text-sm font-medium transition-colors hover:text-white <?php echo $key === $activeNavKey ? 'text-blue-400' : 'text-white/60'; ?>">
                    <?php echo htmlspecialchars($item['label'] ?? ''); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>

    <main class="w-full flex flex-col items-center px-4 md:px-8 py-8 max-w-2xl mx-auto fade-in min-h-[calc(100vh-100px)] h-[calc(100vh-100px)] justify-center relative z-10">
        <h1 class="text-3xl md:text-4xl text-blue-400 font-bold mb-2 text-center tracking-tight" style="font-family: 'Mulish', sans-serif;">
            <?php echo $contactHeading; ?>
        </h1>
        <p class="text-white/60 text-xs md:text-sm text-center mb-6 font-light">
            <?php echo $contactSubheading; ?>
        </p>

        <?php if ($showThankYou): ?>
            <div class="w-full bg-white/[0.03] border border-blue-500/30 p-10 rounded-3xl backdrop-blur-xl text-center shadow-[0_0_30px_rgba(37,99,235,0.1)]">
                <h2 class="text-3xl text-blue-300 mb-6 font-semibold" style="font-family: 'Mulish', sans-serif;"><?php echo $successMessage; ?></h2>
                <a href="home.php" class="text-white/60 hover:text-white transition-colors text-sm font-medium underline underline-offset-4"><?php echo htmlspecialchars($returnHomeText); ?></a>
            </div>
        <?php else: ?>
            <?php if ($showError): ?>
                <p class="text-red-400 py-3 px-4 bg-red-900/20 border border-red-900/30 rounded-md text-sm mb-6 w-full text-center"><?php echo $errorMessage; ?></p>
            <?php endif; ?>

            <form id="contactForm" action="contact.php" method="POST" class="w-full flex flex-col gap-4 bg-white/[0.03] border border-white/10 p-6 md:p-8 rounded-3xl backdrop-blur-xl shadow-2xl">
                <div class="flex flex-col gap-1">
                    <label class="text-blue-200/80 text-xs font-semibold uppercase tracking-wider text-left">
                        <?php echo htmlspecialchars($formLabels['name'] ?? ''); ?>
                    </label>
                    <input type="text" name="name" required class="bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/80 transition-colors text-sm focus:bg-white/[0.05]">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-blue-200/80 text-xs font-semibold uppercase tracking-wider text-left">
                        <?php echo htmlspecialchars($formLabels['email'] ?? ''); ?>
                    </label>
                    <input type="email" name="email" required class="bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/80 transition-colors text-sm focus:bg-white/[0.05]">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-blue-200/80 text-xs font-semibold uppercase tracking-wider text-left">
                        <?php echo htmlspecialchars($formLabels['message'] ?? ''); ?>
                    </label>
                    <textarea name="message" rows="5" required class="bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/80 transition-colors text-sm resize-none focus:bg-white/[0.05]"></textarea>
                </div>

                <div class="bg-black/20 border border-white/10 rounded-xl px-3 py-3">
                    <p class="text-blue-200/80 text-xs font-semibold uppercase tracking-wider mb-2">
                        <?php echo htmlspecialchars($captchaHeading); ?>
                    </p>
                    <label class="text-white/70 text-sm block mb-3">
                        <?php echo htmlspecialchars($captchaLabel); ?>
                    </label>
                    <div id="contactTurnstile" class="cf-turnstile" data-sitekey="<?php echo htmlspecialchars($captchaSiteKey); ?>" data-theme="dark" data-execution="execute" data-callback="onTurnstileSuccess"></div>
                    <?php if ($showCaptchaError): ?>
                        <p class="text-red-400 text-xs mt-2"><?php echo htmlspecialchars($captchaErrorMessage); ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" class="mt-3 bg-blue-600/20 text-blue-300 font-medium text-sm py-3 rounded-xl border border-blue-500/30 hover:bg-blue-600/30 hover:text-white transition-colors tracking-widest uppercase">
                    <?php echo htmlspecialchars($formLabels['submit'] ?? ''); ?>
                </button>
            </form>
        <?php endif; ?>
    </main>

    <script>
        (function() {
            var form = document.getElementById('contactForm');
            var widgetSelector = '#contactTurnstile';
            var isSubmittingAfterCaptcha = false;

            if (!form) {
                return;
            }

            window.onTurnstileSuccess = function() {
                isSubmittingAfterCaptcha = true;
                form.requestSubmit();
            };

            form.addEventListener('submit', function(event) {
                if (isSubmittingAfterCaptcha) {
                    return;
                }

                var tokenInput = form.querySelector('input[name="cf-turnstile-response"]');
                var hasToken = tokenInput && tokenInput.value.trim() !== '';

                if (hasToken) {
                    return;
                }

                if (window.turnstile && typeof window.turnstile.execute === 'function') {
                    event.preventDefault();
                    window.turnstile.execute(widgetSelector);
                }
            });
        })();
    </script>
</body>

</html>