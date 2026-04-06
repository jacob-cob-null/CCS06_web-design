<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Ovo&family=Syne:wght@400..800&display=swap" rel="stylesheet">

<body class="absolute top-0 h-screen w-screen overflow-hidden p-8" style="background-color:#050505;">
    <div class="absolute top-0 left-0 h-screen w-screen z-[-10] pointer-events-none" style="background: radial-gradient(ellipse 80% 80% at 50% -20%, rgba(59,130,246,0.95) 0%, rgba(59,130,246,0.7) 30%, rgba(59,130,246,0.28) 55%, rgba(0,0,0,0) 85%); background-repeat:no-repeat; background-size:140% 140%;"></div>
    <nav class="w-full h-[70px] flex justify-center items-center gap-10">
        <div class="flex justify-center items-center gap-10 h-10 w-fit px-10 py-2 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md shadow-sm">
            <section class="font-[syne] text-white cursor-pointer">
                <a href="about.php">About</a>
            </section>
            <section class="font-[syne] text-white cursor-pointer">
                <a href="admin.php">Admin</a>
            </section>
            <section class="font-[syne] text-white cursor-pointer">
                <a href="contact.php">Contact</a>
            </section>
        </div>
    </nav>
    <main class="w-full h-full flex p-15 justify-center items-start">
        <section class="w-[600px] h-[600px] rounded-2xl flex flex-col relative">
            <div class="absolute top-6 left-4 text-[60px] font-[ovo] text-white tracking-tight">Meet</div>
            <h1 class="font-[syne] text-[240px] tracking-tighter text-white">Jacob</h1>
            <h2 class="absolute bottom-70 text-[30px] self-end font-[ovo] text-white/60 tracking-tight">Aspiring Embedded AI Engineer</h2>
        </section>

    </main>

</body>

</html>