<!-- resources/views/bentoCreator/steps/step7.blade.php -->
<div id="galleries-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
    <h2 class="text-2xl font-semibold">Galeries</h2>
    <div class="gallery mb-3" data-index="0">
        <div class="form-group">
            <label for="galleries[0][titre]" class="block text-sm font-medium text-gray-700">Titre de la galerie</label>
            <input type="text" name="galleries[0][titre]" class="input input-bordered w-full" required>
        </div>
        <div class="gallery-images-container" data-gallery-index="0">
            <h3 class="text-xl font-semibold mt-4">Images de la galerie</h3>
            <div class="gallery-image mb-3" data-index="0">
                <div class="form-group">
                    <label for="galleries[0][images][0][url]" class="block text-sm font-medium text-gray-700">URL de
                        l'image</label>
                    <input type="text" name="galleries[0][images][0][url]" class="input input-bordered w-full" required>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-4">
            <button type="button" class="btn btn-secondary" onclick="addGalleryImage(0)"><i class="fas fa-plus"></i>
                Ajouter une image à la galerie
            </button>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="button" class="btn btn-secondary" onclick="addGallery()"><i class="fas fa-plus"></i> Ajouter une
            galerie
        </button>
    </div>
</div>

<script>
    function addGallery() {
        const container = $('#galleries-container');
        const index = container.children('.gallery').length;
        const galleryHTML = `
        <div class="gallery mb-3 dynamic-element" data-index="${index}">
            <div class="form-group">
                <label for="galleries[${index}][titre]" class="block text-sm font-medium text-gray-700">Titre de la galerie</label>
                <input type="text" name="galleries[${index}][titre]" class="input input-bordered w-full" required>
            </div>
            <div class="gallery-images-container" data-gallery-index="${index}">
                <h3 class="text-xl font-semibold mt-4">Images de la galerie</h3>
                <div class="gallery-image mb-3" data-index="0">
                    <div class="form-group">
                        <label for="galleries[${index}][images][0][url]" class="block text-sm font-medium text-gray-700">URL de l'image</label>
                        <input type="text" name="galleries[${index}][images][0][url]" class="input input-bordered w-full" required>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-4">
                <button type="button" class="btn btn-secondary" onclick="addGalleryImage(${index})"><i class="fas fa-plus"></i> Ajouter une image à la galerie</button>
            </div>
        </div>
    `;
        container.append(galleryHTML);
        setTimeout(() => {
            container.find('.dynamic-element').last().addClass('show');
        }, 10);
    }

    function addGalleryImage(galleryIndex) {
        const container = $(`.gallery[data-index="${galleryIndex}"] .gallery-images-container`);
        const index = container.children('.gallery-image').length;
        const imageHTML = `
        <div class="gallery-image mb-3 dynamic-element" data-index="${index}">
            <div class="form-group">
                <label for="galleries[${galleryIndex}][images][${index}][url]" class="block text-sm font-medium text-gray-700">URL de l'image</label>
                <input type="text" name="galleries[${galleryIndex}][images][${index}][url]" class="input input-bordered w-full" required>
            </div>
        </div>
    `;
        container.append(imageHTML);
        setTimeout(() => {
            container.find('.dynamic-element').last().addClass('show');
        }, 10);
    }
</script>
