<!-- resources/views/bentoCreator/steps/step5.blade.php -->
<div id="colors-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
    <h2 class="text-2xl font-semibold">Couleurs</h2>
    <div class="color mb-3" data-index="0">
        <div class="form-group">
            <label for="colors[0][code]" class="block text-sm font-medium text-gray-700">Code de couleur</label>
            <input type="text" name="colors[0][code]" class="input input-bordered w-full" required>
        </div>
        <div class="form-group">
            <label for="colors[0][description]" class="block text-sm font-medium text-gray-700">Description</label>
            <input type="text" name="colors[0][description]" class="input input-bordered w-full">
        </div>
    </div>
    <div class="flex justify-center">
        <button type="button" class="btn btn-secondary" onclick="addColor()"><i class="fas fa-plus"></i> Ajouter une
            couleur
        </button>
    </div>
</div>

<script>
    function addColor() {
        const container = $('#colors-container');
        const index = container.children('.color').length;
        const colorHTML = `
        <div class="color mb-3 dynamic-element" data-index="${index}">
            <div class="form-group">
                <label for="colors[${index}][code]" class="block text-sm font-medium text-gray-700">Code de couleur</label>
                <input type="text" name="colors[${index}][code]" class="input input-bordered w-full" required>
            </div>
            <div class="form-group">
                <label for="colors[${index}][description]" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" name="colors[${index}][description]" class="input input-bordered w-full">
            </div>
        </div>
    `;
        container.append(colorHTML);
        setTimeout(() => {
            container.find('.dynamic-element').last().addClass('show');
        }, 10);
    }
</script>
