<!-- resources/views/bentoCreator/steps/step3.blade.php -->
@php
    use App\Models\AvailableTechnology;
    $availableTechnologies = AvailableTechnology::all();
@endphp

<div id="technologies-container" class="space-y-4 p-6  rounded-lg shadow">
    <h2 class="text-2xl font-semibold">Technologies</h2>
    <div class="flex flex-wrap space-x-2">
        @foreach($availableTechnologies as $index => $technology)
            <label class="cursor-pointer flex flex-col items-center mb-4 relative">
                <input type="checkbox" name="technologies[0][nom][]" value="{{ $technology->nom }}" class="checkbox"
                       data-icon="{{ $technology->icone }}">
                <div class="max-h-12 w-full object-contain flex justify-center items-center tooltip"
                     data-tip="{{ $technology->nom }}" aria-label="{{ $technology->nom }}">
                    {!! $technology->icone !!}
                </div>
            </label>
        @endforeach
    </div>

    <div id="new-technology-form" class="hidden space-y-4 mt-4"></div>

    <div class="flex justify-center mt-4">
        <button type="button" class="btn btn-secondary" onclick="addNewTechnologyField()"><i
                class="fas fa-plus"></i> Ajouter une autre technologie
        </button>
    </div>
</div>

<script>
    function addNewTechnologyField() {
        const newTechnologyHTML = `
            <div class="new-technology-item space-y-2 mt-4">
                <div class="form-group">
                    <label for="new_technology_nom[]" class="block text-sm font-medium text-gray-700">Nom de la nouvelle technologie</label>
                    <input type="text" name="new_technology_nom[]" class="input input-bordered w-full mt-2" placeholder="Nom de la nouvelle technologie">
                </div>
                <div class="form-group">
                    <label for="new_technology_icone[]" class="block text-sm font-medium text-gray-700">Icône</label>
                    <input type="text" name="new_technology_icone[]" class="input input-bordered w-full mt-2" placeholder="Icône de la nouvelle technologie">
                </div>
            </div>
        `;
        $('#new-technology-form').removeClass('hidden').append(newTechnologyHTML);
    }

    $(document).ready(function () {
        $('.flex.flex-col.items-center.mb-4.relative').hover(
            function () {
                $(this).find('.tooltip-text').removeClass('hidden');
            },
            function () {
                $(this).find('.tooltip-text').addClass('hidden');
            }
        );
    });
</script>

