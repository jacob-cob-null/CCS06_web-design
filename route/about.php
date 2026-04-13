<?php
// CONTROLLER
require_once '../db/data_loader.php';
$content = loadSiteContent();
$personalInfo = $content['personalInfo'] ?? [];
$siteContent = $content['siteContent']['about'] ?? [];
$navItems = $content['siteContent']['navigation'] ?? [];

$pageTitle = $siteContent['title'] ?? '';
$fullName = $personalInfo['fullName'] ?? '';
$aboutHeading = $siteContent['heading'] ?? '';
$bioTitle = $siteContent['bioTitle'] ?? '';
$biography = $personalInfo['biography'] ?? '';
$skillsHeading = $siteContent['skillsHeading'] ?? '';
$skills = $personalInfo['skills'] ?? [];
$educationHeading = $siteContent['educationHeading'] ?? '';
$education = $personalInfo['education'] ?? [];
$ctaHeading = $siteContent['ctaHeading'] ?? '';
$ctaText = $siteContent['ctaText'] ?? '';
$footerPrefix = $siteContent['footerPrefix'] ?? '';
$activeNavKey = 'about';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Mulish:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(10px);
        }

        .delay-100 {
            animation-delay: 100ms;
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

    <main class="w-full flex flex-col items-center px-6 md:px-12 pb-16 fade-in delay-100 max-w-5xl mx-auto relative z-10">
        <h1 class="text-4xl md:text-5xl text-blue-400 font-bold mb-10 mt-6 tracking-tight w-full" style="font-family: 'Mulish', sans-serif;">
            <?php echo $aboutHeading; ?>
        </h1>

        <div class="w-full bg-white/[0.03] border border-white/10 rounded-3xl p-10 md:p-14 backdrop-blur-xl shadow-2xl flex flex-col gap-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Left: Bio -->
                <div class="flex flex-col gap-6">
                    <h2 class="text-2xl text-white font-semibold tracking-tight" style="font-family: 'Mulish', sans-serif;">
                        <?php echo $bioTitle; ?>
                    </h2>
                    <p class="text-white/60 text-base md:text-lg leading-relaxed font-light">
                        <?php echo $biography; ?>
                    </p>
                </div>

                <!-- Right: Skills & Education -->
                <div class="flex flex-col gap-12">
                    <!-- Skills -->
                    <div>
                        <h3 class="text-blue-300 text-lg mb-4 font-semibold" style="font-family: 'Mulish', sans-serif;">
                            <?php echo $skillsHeading; ?>
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($skills as $skill): ?>
                                <span class="px-4 py-2 bg-blue-900/40 border border-blue-500/20 rounded-full text-blue-100 text-xs font-medium">
                                    <?php echo $skill; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Education -->
                    <div>
                        <h3 class="text-blue-300 text-lg mb-4 font-semibold" style="font-family: 'Mulish', sans-serif;">
                            <?php echo $educationHeading; ?>
                        </h3>
                        <div class="flex flex-col gap-6">
                            <?php foreach ($education as $edu): ?>
                                <div class="flex flex-col gap-1">
                                    <h4 class="text-white font-medium text-sm">
                                        <?php echo $edu['degree']; ?>
                                    </h4>
                                    <div class="flex justify-between text-white/50 text-sm font-light">
                                        <span><?php echo $edu['school']; ?></span>
                                        <span><?php echo $edu['year']; ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer-like CTA -->
            <div class="w-full flex flex-col md:flex-row justify-between items-center gap-6 border-t border-white/10 pt-10">
                <p class="text-blue-200/40 text-sm font-medium tracking-tight">
                    <?php echo htmlspecialchars($footerPrefix); ?> <?php echo date("Y") . " " . htmlspecialchars($fullName); ?>
                </p>
                <div class="flex items-center gap-4">
                    <span class="text-white/60 text-sm"><?php echo $ctaHeading; ?></span>
                    <a href="contact.php" class="text-blue-400 hover:text-white transition-colors text-sm font-medium underline underline-offset-4">
                        <?php echo $ctaText; ?>
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>