<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .dynamic-element {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .dynamic-element.show {
        opacity: 1;
    }
</style>

@include('includes.admin-header')
<div class="container mx-auto p-8 bg-white shadow-lg rounded-lg max-w-4xl">
    <h1 class="text-3xl font-bold mb-6 text-center">Créer un nouveau projet</h1>

    <form id="project-form" action="{{ route('projects.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Informations sur le projet -->
        <div class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
            <h2 class="text-2xl font-semibold">Informations sur le projet</h2>
            <div class="form-group">
                <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" name="titre" id="titre" class="input input-bordered w-full" required>
            </div>
            <div class="form-group">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="textarea textarea-bordered w-full"></textarea>
            </div>
        </div>

        <!-- Cartes -->
        <div id="cards-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
            <h2 class="text-2xl font-semibold">Cartes</h2>
            <div class="card mb-3" data-index="0">
                <div class="form-group">
                    <label for="cards[0][type]" class="block text-sm font-medium text-gray-700">Type de carte</label>
                    <input type="text" name="cards[0][type]" class="input input-bordered w-full" required>
                </div>
                <div class="form-group">
                    <label for="cards[0][contenu]" class="block text-sm font-medium text-gray-700">Contenu</label>
                    <textarea name="cards[0][contenu]" class="textarea textarea-bordered w-full"></textarea>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" class="btn btn-secondary" onclick="addCard()"><i class="fas fa-plus"></i> Ajouter
                    une carte
                </button>
            </div>
        </div>

        <!-- Technology -->
        <div id="technologies-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
            <h2 class="text-2xl font-semibold">Technologies</h2>
            <div class="technology mb-3" data-index="0">
                <div class="form-group">
                    <label for="technologies[0][nom]" class="block text-sm font-medium text-gray-700">Nom de la
                        technologie</label>
                    <input type="text" name="technologies[0][nom]" class="input input-bordered w-full" required>
                </div>
                <div class="form-group">
                    <label for="technologies[0][icone]" class="block text-sm font-medium text-gray-700">Icône</label>
                    <input type="text" name="technologies[0][icone]" class="input input-bordered w-full">
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" class="btn btn-secondary" onclick="addTechnology()"><i class="fas fa-plus"></i>
                    Ajouter une technologie
                </button>
            </div>
        </div>

        <!-- Participants -->
        <div id="participants-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
            <h2 class="text-2xl font-semibold">Participants</h2>
            <div class="participant mb-3" data-index="0">
                <div class="form-group">
                    <label for="participants[0][nom]" class="block text-sm font-medium text-gray-700">Nom du
                        participant</label>
                    <input type="text" name="participants[0][nom]" class="input input-bordered w-full" required>
                </div>
                <div class="form-group">
                    <label for="participants[0][avatar]" class="block text-sm font-medium text-gray-700">Avatar</label>
                    <input type="text" name="participants[0][avatar]" class="input input-bordered w-full">
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" class="btn btn-secondary" onclick="addParticipant()"><i class="fas fa-plus"></i>
                    Ajouter un participant
                </button>
            </div>
        </div>

        <!-- Couleurs -->
        <div id="colors-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
            <h2 class="text-2xl font-semibold">Couleurs</h2>
            <div class="color mb-3" data-index="0">
                <div class="form-group">
                    <label for="colors[0][code]" class="block text-sm font-medium text-gray-700">Code de couleur</label>
                    <input type="text" name="colors[0][code]" class="input input-bordered w-full" required>
                </div>
                <div class="form-group">
                    <label for="colors[0][description]"
                           class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" name="colors[0][description]" class="input input-bordered w-full">
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" class="btn btn-secondary" onclick="addColor()"><i class="fas fa-plus"></i> Ajouter
                    une couleur
                </button>
            </div>
        </div>

        <!-- Images du projet -->
        <div id="project-images-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
            <h2 class="text-2xl font-semibold">Images du projet</h2>
            <div class="project-image mb-3" data-index="0">
                <div class="form-group">
                    <label for="project_images[0][url]" class="block text-sm font-medium text-gray-700">URL de
                        l'image</label>
                    <input type="text" name="project_images[0][url]" class="input input-bordered w-full" required>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" class="btn btn-secondary" onclick="addProjectImage()"><i class="fas fa-plus"></i>
                    Ajouter une image
                </button>
            </div>
        </div>

        <!-- Galerie -->
        <div id="galleries-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
            <h2 class="text-2xl font-semibold">Galeries</h2>
            <div class="gallery mb-3" data-index="0">
                <div class="form-group">
                    <label for="galleries[0][titre]" class="block text-sm font-medium text-gray-700">Titre de la
                        galerie</label>
                    <input type="text" name="galleries[0][titre]" class="input input-bordered w-full" required>
                </div>
                <div class="gallery-images-container" data-gallery-index="0">
                    <h3 class="text-xl font-semibold mt-4">Images de la galerie</h3>
                    <div class="gallery-image mb-3" data-index="0">
                        <div class="form-group">
                            <label for="galleries[0][images][0][url]" class="block text-sm font-medium text-gray-700">URL
                                de l'image</label>
                            <input type="text" name="galleries[0][images][0][url]" class="input input-bordered w-full"
                                   required>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-4">
                    <button type="button" class="btn btn-secondary" onclick="addGalleryImage(0)"><i
                            class="fas fa-plus"></i> Ajouter une image à la galerie
                    </button>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" class="btn btn-secondary" onclick="addGallery()"><i class="fas fa-plus"></i>
                    Ajouter une galerie
                </button>
            </div>
        </div>

        <!-- Soumettre le formulaire -->
        <div class="flex justify-center mt-6">
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Créer le projet</button>
        </div>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    function addCard() {
        const container = $('#cards-container');
        const index = container.children('.card').length;
        const cardHTML = `
                <div class="card mb-3 dynamic-element" data-index="${index}">
                    <div class="form-group">
                        <label for="cards[${index}][type]" class="block text-sm font-medium text-gray-700">Type de carte</label>
                        <input type="text" name="cards[${index}][type]" class="input input-bordered w-full" required>
                    </div>
                    <div class="form-group">
                        <label for="cards[${index}][contenu]" class="block text-sm font-medium text-gray-700">Contenu</label>
                        <textarea name="cards[${index}][contenu]" class="textarea textarea-bordered w-full"></textarea>
                    </div>
                </div>
            `;
        container.append(cardHTML);
        setTimeout(() => {
            container.find('.dynamic-element').last().addClass('show');
        }, 10);
    }

    function addTechnology() {
        const container = $('#technologies-container');
        const index = container.children('.technology').length;
        const technologyHTML = `
                <div class="technology mb-3 dynamic-element" data-index="${index}">
                    <div class="form-group">
                        <label for="technologies[${index}][nom]" class="block text-sm font-medium text-gray-700">Nom de la technologie</label>
                        <input type="text" name="technologies[${index}][nom]" class="input input-bordered w-full" required>
                    </div>
                    <div class="form-group">
                        <label for="technologies[${index}][icone]" class="block text-sm font-medium text-gray-700">Icône</label>
                        <input type="text" name="technologies[${index}][icone]" class="input input-bordered w-full">
                    </div>
                </div>
            `;
        container.append(technologyHTML);
        setTimeout(() => {
            container.find('.dynamic-element').last().addClass('show');
        }, 10);
    }

    function addParticipant() {
        const container = $('#participants-container');
        const index = container.children('.participant').length;
        const participantHTML = `
                <div class="participant mb-3 dynamic-element" data-index="${index}">
                    <div class="form-group">
                        <label for="participants[${index}][nom]" class="block text-sm font-medium text-gray-700">Nom du participant</label>
                        <input type="text" name="participants[${index}][nom]" class="input input-bordered w-full" required>
                    </div>
                    <div class="form-group">
                        <label for="participants[${index}][avatar]" class="block text-sm font-medium text-gray-700">Avatar</label>
                        <input type="text" name="participants[${index}][avatar]" class="input input-bordered w-full">
                    </div>
                </div>
            `;
        container.append(participantHTML);
        setTimeout(() => {
            container.find('.dynamic-element').last().addClass('show');
        }, 10);
    }

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

    function addProjectImage() {
        const container = $('#project-images-container');
        const index = container.children('.project-image').length;
        const imageHTML = `
                <div class="project-image mb-3 dynamic-element" data-index="${index}">
                    <div class="form-group">
                        <label for="project_images[${index}][url]" class="block text-sm font-medium text-gray-700">URL de l'image</label>
                        <input type="text" name="project_images[${index}][url]" class="input input-bordered w-full" required>
                    </div>
                </div>
            `;
        container.append(imageHTML);
        setTimeout(() => {
            container.find('.dynamic-element').last().addClass('show');
        }, 10);
    }

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

    $('#project-form').submit(function (event) {
        event.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            success: function (response) {
                alert('Projet créé avec succès.');
                window.location.href = '{{ route('projects.index') }}';
            },
            error: function (response) {
                alert('Erreur lors de la création du projet.');
            }
        });
    });
</script>
@include("includes/footer")
