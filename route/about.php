<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Ovo&family=Syne:wght@400..800&display=swap" rel="stylesheet">

<body class="absolute top-0 h-screen w-screen overflow-hidden p-8" style="background-color:#050505;">
    <div class="absolute top-0 left-0 h-screen w-screen z-[-10] pointer-events-none" style="background: radial-gradient(ellipse 80% 80% at 50% -20%, rgba(59,130,246,0.95) 0%, rgba(59,130,246,0.7) 30%, rgba(59,130,246,0.28) 55%, rgba(0,0,0,0) 85%); background-repeat:no-repeat; background-size:140% 140%;"></div>
    <nav class="w-full h-[70px] flex justify-center items-center gap-10">
        <div class="flex justify-center items-center gap-10 h-10 w-fit px-10 py-2 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md shadow-sm">
            <section class="font-[syne] text-white cursor-pointer hover:text-white/70 transition-colors">
                <a href="home.php">Home</a>
            </section>
            <section class="font-[syne] text-white cursor-pointer hover:text-white/70 transition-colors">
                <a href="about.php">About</a>
            </section>
            <section class="font-[syne] text-white cursor-pointer hover:text-white/70 transition-colors">
                <a href="admin.php">Admin</a>
            </section>
            <section class="font-[syne] text-white cursor-pointer hover:text-white/70 transition-colors">
                <a href="contact.php">Contact</a>
            </section>
        </div>
    </nav>
    <main class="w-full h-full flex flex-col items-center p-8 relative z-10">

        <h1 class="font-[syne] text-[60px] md:text-[80px] text-white tracking-tighter mb-10">About Me</h1>

        <section class="w-full max-w-4xl bg-white/5 border border-white/10 rounded-3xl p-10 md:p-14 backdrop-blur-xl shadow-2xl flex flex-col gap-8">
            <h2 class="font-[ovo] text-4xl text-white/90 tracking-wide">Hello. I am Jacob.</h2>

            <p class="font-[mulish] text-white/70 text-lg md:text-xl leading-relaxed font-light">
                I am an aspiring Embedded AI Engineer passionate about bridging the gap between hardware and artificial intelligence.
                I focus on building efficient, intelligent systems that interact seamlessly with the physical world, bringing smart capabilities to the edge.
            </p>

            <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <h3 class="font-[syne] text-white text-lg mb-3">Core Expertise</h3>
                    <h3 class="font-[mulish] text-white/50   text-sm leading-loose">
                        <p class="hover:text-white transition-colors"> Edge Computing</p>
                        <p class="hover:text-white transition-colors">Microcontrollers (MCU)</p>
                        <p class="hover:text-white transition-colors">Machine Learning Deployment</p>
                        <p class="hover:text-white transition-colors">IoT Integration</p>
                    </h3>
                </div>
                <div>
                    <h3 class="font-[syne] text-white text-lg mb-3">Connect</h3>
                    <p class="font-[mulish] text-white/50 text-sm mb-4">
                        Interested in collaborating on intelligent hardware projects?
                    </p>
                    <a href="contact.php" class="font-[mulish] text-blue-400 hover:text-blue-300 transition-colors text-sm uppercase tracking-widest">Reach Out &rarr;</a>
                </div>
            </div>
        </section>

    </main>

</body>

</html>