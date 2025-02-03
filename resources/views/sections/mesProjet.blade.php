<style>

    @media (min-width: 1024px) {
        .owl-stage-outer {
            overflow: visible !important;
        }
    }

    #projets {
        overflow-x: hidden;
        overflow-y: hidden;
        max-width: 100vw;
    }
</style>

<div id="projets" class="py-10 container mx-auto text-center" itemscope itemtype="https://schema.org/ItemList">
    <h2 class="text-3xl font-bold text-center pb-10" tabindex="0" itemprop="name">Mes Projets</h2>
    <p class="mb-12 text-lg" itemprop="description">Voici quelques-uns des projets sur lesquels j'ai travaillé
        récemment.</p>
    <div class="owl-carousel owl-theme jsp-jpp">
        @foreach($projects as $project)
            <div class="item pb-10" itemprop="itemListElement" itemscope itemtype="https://schema.org/CreativeWork">
                <div class="card w-96 bg-base-100 shadow-xl">
                    @if($project->cards->isNotEmpty() && $project->cards->first()->image)
                        <figure class="relative">
                            <div
                                class="badge badge-primary badge-outline absolute top-2 right-2">@foreach($project->technologies as $technology)
                                    <span itemprop="keywords">{{ $technology->nom }}</span>@if(!$loop->last)
                                        /
                                    @endif
                                @endforeach</div>
                            <img src="{{ asset($project->cards->first()->image) }}" alt="{{ $project->titre }}"
                                 loading="lazy" itemprop="image"/>
                        </figure>
                    @endif
                    <div class="card-body">
                        <h3 class="card-title" itemprop="headline">{{ $project->titre }}</h3>
                        <p itemprop="text">{{ $project->cards->first()->contenu }}</p>
                        <div class="card-actions justify-end">
                            <button class="btn btn-primary" onclick="openModal({{ $project->id }})" itemprop="url">En
                                voir plus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
