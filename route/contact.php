<?php
// CONTROLLER
require_once '../db/db_conn.php';
$pageTitle = "Contact | Lance Jacob's Portfolio";
$navItems = [
    "Home" => "home.php",
    "About" => "about.php",
    "Contact" => "contact.php",
    "Admin" => "admin.php"
];

$contactHeading = "Get in Touch";
$contactSubheading = "Have a question or want to work together?";

$formLabels = [
    "name" => "Full Name",
    "email" => "Email Address",
    "message" => "Your Message",
    "submit" => "Send Message"
];

$successMessage = "Thank you! Your message has been sent successfully.";
$errorMessage = "Oops! Something went wrong. Please try again.";

$showThankYou = false;
$showError = false;

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        .fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; transform: translateY(10px); }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
    </style>
</head>

<body class="absolute top-0 h-screen w-screen overflow-hidden text-white antialiased" style="background-color:#020617; font-family: 'Inter', sans-serif;">
    <div class="absolute top-0 left-0 h-screen w-screen z-[-10] pointer-events-none" style="background: radial-gradient(ellipse 80% 80% at 50% -20%, rgba(37,99,235,0.7) 0%, rgba(29,78,216,0.4) 30%, rgba(30,58,138,0.15) 55%, rgba(0,0,0,0) 85%);"></div>

    <nav class="w-full flex justify-center py-8 fade-in h-[100px] sticky top-0 z-50">
        <div class="flex gap-8 items-center px-8 py-3 rounded-full bg-white/5 border border-white/10 backdrop-blur-xl shadow-lg transition-all">
            <?php foreach ($navItems as $name => $link): ?>
                <a href="<?php echo htmlspecialchars($link); ?>" class="text-sm font-medium transition-colors hover:text-white <?php echo $name === 'Contact' ? 'text-blue-400' : 'text-white/60'; ?>">
                    <?php echo htmlspecialchars($name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>

    <main class="w-full flex flex-col items-center px-6 md:px-12 py-12 max-w-2xl mx-auto fade-in h-[calc(100vh-100px)] overflow-y-auto relative z-10">
        <h1 class="text-4xl md:text-5xl text-blue-400 font-bold mb-4 text-center tracking-tight" style="font-family: 'Mulish', sans-serif;">
            <?php echo $contactHeading; ?>
        </h1>
        <p class="text-white/60 text-sm md:text-base text-center mb-10 font-light">
            <?php echo $contactSubheading; ?>
        </p>

        <?php if ($showThankYou): ?>
            <div class="w-full bg-white/[0.03] border border-blue-500/30 p-10 rounded-3xl backdrop-blur-xl text-center shadow-[0_0_30px_rgba(37,99,235,0.1)]">
                <h2 class="text-3xl text-blue-300 mb-6 font-semibold" style="font-family: 'Mulish', sans-serif;"><?php echo $successMessage; ?></h2>
                <a href="home.php" class="text-white/60 hover:text-white transition-colors text-sm font-medium underline underline-offset-4">Return Home</a>
            </div>
        <?php else: ?>
            <?php if ($showError): ?>
                <p class="text-red-400 py-3 px-4 bg-red-900/20 border border-red-900/30 rounded-md text-sm mb-6 w-full text-center"><?php echo $errorMessage; ?></p>
            <?php endif; ?>

            <form action="contact.php" method="POST" class="w-full flex flex-col gap-5 bg-white/[0.03] border border-white/10 p-10 rounded-3xl backdrop-blur-xl shadow-2xl">
                <div class="flex flex-col gap-2">
                    <label class="text-blue-200/80 text-xs font-semibold uppercase tracking-wider text-left">
                        <?php echo $formLabels['name']; ?>
                    </label>
                    <input type="text" name="name" required class="bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/80 transition-colors text-sm focus:bg-white/[0.05]">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-blue-200/80 text-xs font-semibold uppercase tracking-wider text-left">
                        <?php echo $formLabels['email']; ?>
                    </label>
                    <input type="email" name="email" required class="bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/80 transition-colors text-sm focus:bg-white/[0.05]">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-blue-200/80 text-xs font-semibold uppercase tracking-wider text-left">
                        <?php echo $formLabels['message']; ?>
                    </label>
                    <textarea name="message" rows="5" required class="bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/80 transition-colors text-sm resize-none focus:bg-white/[0.05]"></textarea>
                </div>

                <button type="submit" class="mt-4 bg-blue-600/20 text-blue-300 font-medium text-sm py-4 rounded-xl border border-blue-500/30 hover:bg-blue-600/30 hover:text-white transition-colors tracking-widest uppercase">
                    <?php echo $formLabels['submit']; ?>
                </button>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>