<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
<style>
    @media (min-width: 1024px) {
        .slick-list {
            overflow: visible;
        }
    }

</style>
<div class="container mx-auto text-center ">
    <h2 class="text-4xl font-bold mb-8">Mes Projets</h2>
    <p class="mb-12 text-lg">Voici quelques-uns des projets sur lesquels j'ai travaillé récemment.</p>
    <div class="your-class ">
        <div>
            <div class="card w-96 bg-base-100 shadow-xl">
                <figure><img src="/img/gite_maisons.webp" alt="Gite de la Chouette" loading="lazy"/></figure>
                <div class="card-body">
                    <h3 class="card-title">Gite de la Chouette</h3>
                    <p>Site web réalisé pour un gîte à Maisons avec WordPress.</p>
                    <p>Technologies : WordPress</p>
                    <div class="card-actions justify-end">
                        <a href="https://www.gitemaisons.fr" class="btn btn-primary">Voir le projet</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card w-96 bg-base-100 shadow-xl">
                <figure><img src="/img/firstPortfolio.webp" alt="Portfolio" loading="lazy"/></figure>
                <div class="card-body">
                    <h3 class="card-title">Portfolio</h3>
                    <p>Portfolio réalisé comme projet de premier semestre avec HTML/CSS.</p>
                    <p>Technologies : HTML, CSS, PHP, YAML</p>
                    <div class="card-actions justify-end">
                        <a href="https://www.beta01.sachaguignard.fr/portfolio" class="btn btn-primary">Voir le
                            projet</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card w-96 bg-base-100 shadow-xl">
                <figure><img src="/img/Ariane.webp" alt="Ariane" loading="lazy"/></figure>
                <div class="card-body">
                    <h3 class="card-title">Ariane</h3>
                    <p>Site réalisé dans le cadre du premier semestre en licence avec HTML/CSS.</p>
                    <p>Technologies : HTML, CSS</p>
                    <div class="card-actions justify-end">
                        <a href="https://ariane.sachaguignard.fr/accueil.html" class="btn btn-primary">Voir le
                            projet</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card w-96 bg-base-100 shadow-xl">
                <figure><img src="/img/normanbet.webp" alt="NormanBet" loading="lazy"/></figure>
                <div class="card-body">
                    <h3 class="card-title">NormanBet</h3>
                    <p>Site fait en cours pour simuler un site de paris pour les JO2024.</p>
                    <p>Technologies : Spring Java, Bootstrap</p>
                    <div class="card-actions justify-end">
                        <a href="https://srv2-vm-2116.sts-sio-caen.info/" class="btn btn-primary">Voir le projet</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>

<script type="text/javascript">
    window.addEventListener('scroll', function () {
        window.scrollTo(0, window.scrollY);
    });

    $(document).ready(function () {
        $('.your-class').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            lazyLoad: 'ondemand',
            centerMode: true,
            centerPadding: '',
            prevArrow: '',
            nextArrow: '',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true,
                        centerPadding: '10%'
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        centerPadding: '10%'
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 0,
                        centerMode: true,
                        dots: true,
                    }
                }
            ]
        });
    });
</script>
