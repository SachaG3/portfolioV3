<!-- resources/views/bentoCreator/steps/step6.blade.php -->
<div id="project-images-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
    <h2 class="text-2xl font-semibold">Images du projet</h2>
    <div class="project-image mb-3" data-index="0">
        <div class="form-group">
            <label for="project_images[0][file]" class="block text-sm font-medium text-gray-700">Sélectionner une
                image</label>
            <input type="file" name="project_images[0][file]" class="input input-bordered w-full" required>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="button" class="btn btn-secondary" onclick="addProjectImage()"><i class="fas fa-plus"></i> Ajouter
            une image
        </button>
    </div>
</div>

<script>
    function addProjectImage() {
        const container = $('#project-images-container');
        const index = container.children('.project-image').length;
        const imageHTML = `
            <div class="project-image mb-3 dynamic-element" data-index="${index}">
                <div class="form-group">
                    <label for="project_images[${index}][file]" class="block text-sm font-medium text-gray-700">Sélectionner une image</label>
                    <input type="file" name="project_images[${index}][file]" class="input input-bordered w-full" required>
                </div>
            </div>
        `;
        container.append(imageHTML);
        setTimeout(() => {
            container.find('.dynamic-element').last().addClass('show');
        }, 10);
    }
</script>
