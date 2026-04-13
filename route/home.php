<?php
// CONTROLLER
require_once '../db/data_loader.php';
$content = loadSiteContent();
$personalInfo = $content['personalInfo'] ?? [];
$siteContent = $content['siteContent']['home'] ?? [];
$navItems = $content['siteContent']['navigation'] ?? [];

$pageTitle = $siteContent['title'] ?? '';
$heroGreeting = $siteContent['greeting'] ?? '';
$heroName     = $personalInfo['name'] ?? '';
$heroRole     = $personalInfo['role'] ?? '';
$primaryCta   = $siteContent['primaryCta'] ?? '';
$secondaryCta = $siteContent['secondaryCta'] ?? '';
$activeNavKey = 'home';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Mulish:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }

        .delay-100 {
            animation-delay: 100ms;
        }

        .delay-200 {
            animation-delay: 200ms;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="absolute top-0 min-h-screen w-screen overflow-x-hidden text-white antialiased" style="background-color:#020617; font-family: 'Inter', sans-serif;">
    <div class="fixed top-0 left-0 h-screen w-screen z-[-10] pointer-events-none" style="background: radial-gradient(ellipse 80% 80% at 50% -20%, rgba(37,99,235,0.7) 0%, rgba(29,78,216,0.4) 30%, rgba(30,58,138,0.15) 55%, rgba(0,0,0,0) 85%);"></div>

    <nav class="w-full flex justify-center py-8 fade-in h-[100px] sticky top-0 z-50">
        <div class="flex gap-8 items-center px-8 py-3 rounded-full bg-white/5 border border-white/10 backdrop-blur-xl shadow-lg transition-all">
            <?php foreach ($navItems as $key => $item): ?>
                <a href="<?php echo htmlspecialchars($item['href'] ?? ''); ?>" class="text-sm font-medium transition-colors hover:text-white <?php echo $key === $activeNavKey ? 'text-blue-400' : 'text-white/60'; ?>">
                    <?php echo htmlspecialchars($item['label'] ?? ''); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>

    <main class="flex flex-col justify-center items-center px-8 relative z-10 -mt-10" style="min-height: calc(100vh - 100px);">
        <div class="text-center max-w-3xl translate-y-4 fade-in delay-100">
            <p class="text-blue-400 text-lg md:text-xl font-light mb-2">
                <?php echo htmlspecialchars($heroGreeting); ?>
            </p>

            <h1 class="text-5xl md:text-8xl font-bold text-white mb-6 tracking-tight bg-clip-text text-transparent bg-gradient-to-br from-white to-gray-300" style="font-family: 'Mulish', sans-serif;">
                <?php echo htmlspecialchars($heroName); ?>
            </h1>

            <h2 class="text-lg md:text-2xl text-white/50 font-light mb-12">
                <?php echo htmlspecialchars($heroRole); ?>
            </h2>

            <div class="flex flex-col sm:flex-row justify-center gap-4 fade-in delay-200">
                <a href="about.php" class="px-8 py-3 rounded-full bg-blue-600/20 text-blue-300 border border-blue-500/30 hover:bg-blue-600/30 hover:text-white backdrop-blur-md font-medium transition-colors text-sm shadow-[0_0_15px_rgba(37,99,235,0.1)]">
                    <?php echo htmlspecialchars($primaryCta); ?>
                </a>
                <a href="contact.php" class="px-8 py-3 rounded-full text-white/60 hover:text-white border border-white/10 hover:border-white/20 hover:bg-white/5 font-medium transition-colors text-sm backdrop-blur-md">
                    <?php echo htmlspecialchars($secondaryCta); ?>
                </a>
            </div>
        </div>
    </main>
</body>

</html>