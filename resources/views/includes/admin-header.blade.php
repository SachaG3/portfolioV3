@php(header("X-Robots-Tag: noindex, nofollow"))
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">

    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portfolio - Sacha Guignard</title>

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&display=swap" rel="stylesheet" as="style">

    <link rel="icon" href="/img/icon.ico" type="image/x-icon" loading="lazy">

    <script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <meta name="google-site-verification" content="whNrt9m9dEdW_8jrmdtH_TY9u9XIZzBYy4ih6czMvCs"/>
</head>
<body id="accueil">

<!-- Navigation -->
<nav
    class="navbar bg-base-100 sticky top-0 z-50 w-full backdrop-blur flex-none transition-colors duration-500 lg:z-50 lg:border-b lg:border-slate-900/10 dark:border-slate-50/[0.06] supports-backdrop-blur:bg-white/95 bg-base-300/50 relative">
    <div class="flex-1">
        <a class="btn btn-ghost text-xl" href="/" aria-label="Accueil">Sacha Guignard</a>
    </div>

    <div class="flex-none">
        <!-- Bouton menu pour les écrans mobiles -->
        <button class="btn btn-square btn-ghost lg:hidden" aria-label="Ouvrir le menu" id="menu-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-menu">
                <title>Menu</title>
                <line x1="4" x2="20" y1="12" y2="12"/>
                <line x1="4" x2="20" y1="6" y2="6"/>
                <line x1="4" x2="20" y1="18" y2="18"/>
            </svg>
        </button>
    </div>
    <!-- Menu horizontal pour les écrans larges -->
    <ul class="menu menu-horizontal p-0 hidden lg:flex">
        <li>
            <select class="select" data-choose-theme aria-label="Choisir un thème">
                <option value="dim">Dark 🌑</option>
                <option value="nord">Light ☀️</option>
                <option value="retro">Retro️ 🎞️</option>
                <option value="bonbon">Bonbon 🍬</option>
            </select>
        </li>
        <li><a href="/skills" tabindex="0" aria-label="skills">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-star">
                    <title>Compétence</title>
                    <polygon
                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                Compétence</a></li>
        <li><a href="/bentoCreator" tabindex="0" aria-label="CreateBento">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-folder-git-2">
                    <title>Mes projets</title>
                    <path
                        d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5"/>
                    <circle cx="13" cy="12" r="2"/>
                    <path d="M18 19c-2.8 0-5-2.2-5-5v8"/>
                    <circle cx="20" cy="19" r="2"/>
                </svg>
                Mes projets</a></li>
        @if(session('authenticated'))
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-log-out">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" x2="9" y1="12" y2="12"/>
                    </svg>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endif

    </ul>
</nav>

<!-- Menu déroulant pour les écrans mobiles -->
<div id="mobile-dropdown-menu" class="fixed left-0 right-0 bg-base-300 w-full shadow-md hidden"
     style="top: 56px; z-index: 1000;">
    <ul class="menu menu-compact dropdown-content mt-3 p-2 rounded-box w-full">
        <li>
            <select class="select select-xs max-w-xs" data-choose-theme aria-label="Choisir un thème">
                <option value="dim">Dark 🌑</option>
                <option value="nord">Light ☀️</option>
                <option value="retro">Retro️ 🎞️</option>
                <option value="bonbon">Bonbon</option>
            </select>
        </li>
        <li><a href="#apropos" aria-label="A propos">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-user">
                    <title>A propos</title>
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                A propos</a></li>
        <li><a href="#competence" aria-label="Compétence">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-star">
                    <title>Compétence</title>
                    <polygon
                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                Compétence</a></li>
        <li><a href="#cursus" aria-label="Cursus">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-book-open">
                    <title>Cursus</title>
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
                Cursus</a></li>
        <li><a href="#projets" aria-label="Mes projets">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-folder-git-2">
                    <title>Mes projets</title>
                    <path
                        d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5"/>
                    <circle cx="13" cy="12" r="2"/>
                    <path d="M18 19c-2.8 0-5-2.2-5-5v8"/>
                    <circle cx="20" cy="19" r="2"/>
                </svg>
                Mes projets</a></li>
        <li><a href="#contacter" aria-label="Me contacter">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-mail">
                    <title>Me contacter</title>
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                Me contacter</a></li>
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var menuButton = document.getElementById('menu-button');
        var dropdownMenu = document.getElementById('mobile-dropdown-menu');
        menuButton.addEventListener('click', function () {
            dropdownMenu.classList.toggle('hidden');
        });
    });
</script>
</body>
</html>
