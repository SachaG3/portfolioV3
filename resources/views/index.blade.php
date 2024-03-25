@include('includes/header')

<body id="accueil">

@include('includes/accueil')

@include('includes/apropos')

@include('includes/cursus')

@include('includes.competence')

@include('includes/mail')

@include('includes/footer')


</body>
</html>

<script>
    const btn = document.getElementById('themeToggle');
    btn.addEventListener('click', function () {
        const theme = document.documentElement.getAttribute('data-theme');
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'light');
            btn.textContent = 'Passer au thème sombre';
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            btn.textContent = 'Passer au thème clair';
        }
    });
</script>


