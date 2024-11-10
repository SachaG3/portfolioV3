<section class="py-10 lg:m-2" id="competence" itemscope itemtype="https://schema.org/ItemList">
    <h2 class="text-3xl font-bold text-center mt-2 mb-4" tabindex="0" itemprop="name">Mes compétences</h2>
    @foreach ($skills as $skill)
        <div class="py-12 sm:py-16" itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList">
            <div class="mx-auto max-w-7xl px-6 lg:px-8" tabindex="0">
                <h3 class="text-center text-lg font-semibold leading-8" itemprop="name">{{ $skill->name }}</h3>
                <div
                    class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                    @foreach ($skill->icons as $index => $icon)
                        <div
                            class="@if ($index == 4) col-span-2 col-start-2 max-h-12 w-full object-contain sm:col-start-auto lg:col-span-1 @elseif ($index == 3) col-span-2 max-h-12 w-full object-contain lg:col-span-1 sm:col-start-2 @else col-span-2 max-h-12 w-full object-contain lg:col-span-1 @endif flex justify-center items-center tooltip"
                            data-tip="{{ $icon->name }}" aria-label="{{ $icon->name }}" itemprop="itemListElement"
                            itemscope itemtype="https://schema.org/Thing">
                            {!! $icon->svg !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</section>
