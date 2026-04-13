<?php
// CONTROLLER
require_once '../db/db_conn.php';
require_once '../db/data_loader.php';
$content = loadSiteContent();
$siteContent = $content['siteContent']['admin'] ?? [];
$navItems = $content['siteContent']['navigation'] ?? [];
session_start();

// Simple security check
$admin_pass = $content['auth']['adminPassword'] ?? '';
if (!isset($_SESSION['authenticated'])) {
    if (isset($_POST['password']) && $_POST['password'] === $admin_pass) {
        $_SESSION['authenticated'] = true;
    }
}

$pageTitle = $siteContent['title'] ?? '';
$adminHeading = $siteContent['heading'] ?? '';
$loginHeading = $siteContent['loginHeading'] ?? '';
$loginPrompt = $siteContent['loginPrompt'] ?? '';
$loginButton = $siteContent['loginButton'] ?? '';
$logoutText = $siteContent['logoutText'] ?? '';
$emptyState = $siteContent['emptyState'] ?? '';
$deleteButton = $siteContent['deleteButton'] ?? '';
$deletePrompt = $siteContent['deletePrompt'] ?? '';
$passwordHint = $siteContent['passwordHint'] ?? '';
$activeNavKey = 'admin';


// Handle Deletion
if (isset($_GET['delete']) && isset($_SESSION['authenticated'])) {
    $id = (int)$_GET['delete'];
    $stmt = mysqli_prepare($conn, "DELETE FROM contacts WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: admin.php");
    exit;
}

// Fetch Records
$records = [];
if (isset($_SESSION['authenticated'])) {
    $result = mysqli_query($conn, "SELECT * FROM contacts ORDER BY submitted_at DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}
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

    <main class="w-full flex flex-col items-center px-6 md:px-12 py-12 max-w-4xl mx-auto fade-in relative z-10">
        <?php if (!isset($_SESSION['authenticated'])): ?>
            <!-- Login View -->
            <div class="w-full max-w-sm mt-10 bg-white/[0.03] border border-white/10 p-10 rounded-3xl backdrop-blur-xl shadow-2xl">
                <h1 class="text-3xl text-blue-400 mb-6 text-center font-bold tracking-tight" style="font-family: 'Mulish', sans-serif;"><?php echo $loginHeading; ?></h1>
                <form action="admin.php" method="POST" class="flex flex-col gap-4">
                    <p class="text-white/60 text-sm text-center mb-2"><?php echo $loginPrompt; ?></p>
                    <input type="password" name="password" required class="bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/80 transition-colors text-center text-sm shadow-inner focus:bg-white/[0.05]">
                    <button type="submit" class="bg-blue-600/20 text-blue-300 font-medium py-3 rounded-xl hover:bg-blue-600/30 hover:text-white transition-colors text-sm border border-blue-500/30 mt-2 uppercase tracking-widest"><?php echo htmlspecialchars($loginButton); ?></button>
                    <p class="text-white/30 text-xs text-center mt-2"><?php echo htmlspecialchars($passwordHint); ?></p>
                </form>
            </div>
        <?php else: ?>
            <!-- Records Table View -->
            <div class="w-full">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4 border-b border-white/10 pb-6">
                    <div>
                        <h1 class="text-3xl md:text-5xl text-blue-400 font-bold tracking-tight" style="font-family: 'Mulish', sans-serif;">
                            <?php echo $adminHeading; ?>
                        </h1>
                    </div>
                    <a href="?logout=1" class="text-white/60 hover:text-white transition-colors text-sm font-medium underline underline-offset-4">
                        <?php echo $logoutText; ?>
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <?php if (empty($records)): ?>
                        <div class="w-full py-16 text-center border border-white/10 rounded-3xl bg-white/[0.03] backdrop-blur-xl">
                            <p class="text-white/50 text-sm"><?php echo htmlspecialchars($emptyState); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($records as $record): ?>
                        <div class="border border-white/10 p-8 rounded-3xl bg-white/[0.03] backdrop-blur-xl flex flex-col md:flex-row justify-between gap-6 hover:bg-white/[0.05] hover:border-blue-500/30 transition-all shadow-lg">
                            <div class="flex flex-col gap-4 flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6">
                                    <h3 class="text-white text-xl font-bold" style="font-family: 'Mulish', sans-serif;"><?php echo htmlspecialchars($record['name']); ?></h3>
                                    <span class="text-white/50 text-xs uppercase tracking-wider bg-black/30 px-3 py-1 rounded-full border border-white/5">
                                        <?php echo date('M j, Y, g:i a', strtotime($record['submitted_at'])); ?>
                                    </span>
                                </div>
                                <p class="text-blue-300 text-sm font-medium"><?php echo htmlspecialchars($record['email']); ?></p>
                                <div class="bg-black/30 p-5 rounded-xl border border-white/5 mt-2">
                                    <p class="text-white/80 leading-relaxed text-sm font-light">
                                        <?php echo nl2br(htmlspecialchars($record['message'])); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col justify-start pt-2 min-w-[120px]">
                                <a href="?delete=<?php echo $record['id']; ?>" onclick='return confirm(<?php echo json_encode($deletePrompt); ?>)' class="w-full py-3 px-4 bg-red-500/10 text-red-400 border border-red-500/30 rounded-xl text-xs text-center font-bold uppercase tracking-widest hover:bg-red-500/20 hover:text-red-300 transition-colors">
                                    <?php echo htmlspecialchars($deleteButton); ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>