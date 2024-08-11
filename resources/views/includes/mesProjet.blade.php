<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
<style>
    @media (min-width: 1024px) {
        .owl-stage-outer {
            overflow: visible !important;
        }
    }

    #projets {
        overflow-x: hidden; /* Assurez-vous que cette règle est appliquée */
        max-width: 100vw; /* Empêche le débordement au-delà de la largeur de l'écran */
    }
</style>

<!-- resources/views/projects/index.blade.php -->
<div id="projets" class="container mx-auto text-center" itemscope itemtype="https://schema.org/ItemList">
    <h2 class="text-3xl font-bold text-center pb-10" tabindex="0" itemprop="name">Mes Projets</h2>
    <p class="mb-12 text-lg" itemprop="description">Voici quelques-uns des projets sur lesquels j'ai travaillé
        récemment.</p>
    <div class="owl-carousel owl-theme jsp-jpp">
        @foreach($projects as $project)
            <div class="item pb-10" itemprop="itemListElement" itemscope itemtype="https://schema.org/CreativeWork">
                <div class="card w-96 bg-base-100 shadow-xl">
                    @if($project->cards->isNotEmpty() && $project->cards->first()->image)
                        <figure>
                            <img src="{{ asset($project->cards->first()->image) }}" alt="{{ $project->titre }}"
                                 loading="lazy" itemprop="image"/>
                        </figure>
                    @endif
                    <div class="card-body">
                        <h3 class="card-title" itemprop="headline">{{ $project->titre }}</h3>
                        <p itemprop="text">{{ $project->cards->first()->contenu }}</p>
                        @if($project->technologies->isNotEmpty())
                            <p>Technologies :
                                @foreach($project->technologies as $technology)
                                    <span itemprop="keywords">{{ $technology->nom }}</span>@if(!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                        @endif
                        <div class="card-actions justify-end">
                            <button class="btn btn-primary" onclick="openModal({{ $project->id }})" itemprop="url">En
                                voir plus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="item pb-10" itemprop="itemListElement" itemscope itemtype="https://schema.org/CreativeWork">
            <div class="card w-96 bg-base-100 shadow-xl">
                <figure><img src="/img/gite_maisons.webp" alt="Gite de la Chouette" loading="lazy" itemprop="image"/>
                </figure>
                <div class="card-body">
                    <h3 class="card-title" itemprop="headline">Gite de la Chouette</h3>
                    <p itemprop="text">Site web réalisé pour un gîte à Maisons avec WordPress.</p>
                    <p>Technologies : <span itemprop="keywords">WordPress</span></p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" onclick="openModal()" itemprop="url">En voir plus</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="item pb-10" itemprop="itemListElement" itemscope itemtype="https://schema.org/CreativeWork">
            <div class="card w-96 bg-base-100 shadow-xl">
                <figure><img src="/img/firstPortfolio.webp" alt="Portfolio" loading="lazy" itemprop="image"/></figure>
                <div class="card-body">
                    <h3 class="card-title" itemprop="headline">Portfolio</h3>
                    <p itemprop="text">Portfolio réalisé comme projet de premier semestre avec HTML/CSS.</p>
                    <p>Technologies : <span itemprop="keywords">HTML, CSS, PHP, YAML</span></p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" onclick="openModal(46)" itemprop="url">En voir plus</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="item pb-10" itemprop="itemListElement" itemscope itemtype="https://schema.org/CreativeWork">
            <div class="card w-96 bg-base-100 shadow-xl">
                <figure><img src="/img/Ariane.webp" alt="Ariane" loading="lazy" itemprop="image"/></figure>
                <div class="card-body">
                    <h3 class="card-title" itemprop="headline">Ariane</h3>
                    <p itemprop="text">Site réalisé dans le cadre du premier semestre en licence avec HTML/CSS.</p>
                    <p>Technologies : <span itemprop="keywords">HTML, CSS</span></p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" onclick="openModal(2)" itemprop="url">En voir plus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            loop: true,
            nav: false,
            autoplay: true,
            autoplayTimeout: 9000,
            items: 1,
            center: true,
            margin: 420,

            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });
    });
</script>
