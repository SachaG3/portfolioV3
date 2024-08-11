@include('includes/admin-header')
<!-- Bouton pour ouvrir le modal -->
<button
    class="open-modal-button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
    type="button">
    Ajouter une compétence
</button>

<section class=" lg:m-2" id="competence">
    <h2 class="text-3xl font-bold text-center mt-2 mb-4" tabindex="0">Mes compétences</h2>
    @foreach ($skills as $skill)
        <div class="py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-6 lg:px-8" tabindex="0">
                <h3 class="text-center text-lg font-semibold leading-8">{{ $skill->name }}</h3>
                <div class="mx-auto mt-10 grid grid-cols-4 gap-x-8 gap-y-10 sm:grid-cols-6 lg:grid-cols-5">
                    @foreach ($skill->icons as $index => $icon)
                        <a href="javascript:void(0);" onclick="toggleModal('modal-{{ $icon->id }}')">
                            <div
                                class="col-span-2 max-h-12 w-full object-contain lg:col-span-1 flex justify-center items-center tooltip"
                                data-tip="{{ $icon->name }}" aria-label="{{ $icon->name }}">
                                {!! $icon->svg !!}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modals pour chaque icon -->
    @foreach ($skills as $skill)
        @foreach ($skill->icons as $icon)
            <div id="modal-{{ $icon->id }}" class="modal hidden fixed z-50 inset-0 overflow-y-auto "
                 aria-labelledby="modal-title-{{ $icon->id }}" aria-modal="true" role="dialog">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Overlay du modal -->
                    <div class="fixed inset-0 bg-gray-800 bg-opacity-75 transition-opacity"></div>

                    <!-- Contenu du modal -->
                    <div
                        class="inline-block align-middle bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle  max-w-5xl sm:w-full"
                        style="width: 80vh">
                        <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="font-bold text-lg text-white" id="modal-title-{{ $icon->id }}">Modification
                                de {{ $icon->name }}</h3>
                            <form method="POST" action="{{ route('icons.update', $icon->id) }}" class="mt-5">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="name-{{ $icon->id }}"
                                           class="block text-sm font-medium text-gray-300">Nom:</label>
                                    <input type="text" id="name-{{ $icon->id }}" name="name"
                                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                           value="{{ $icon->name }}">
                                </div>

                                <div>
                                    <label for="svg-{{ $icon->id }}"
                                           class="block text-sm font-medium text-gray-300">SVG:</label>
                                    <textarea id="svg-{{ $icon->id }}" name="svg" rows="4"
                                              class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                              style="height: 45vh">{{ $icon->svg }}</textarea>
                                </div>

                                <div class="mt-5 sm:flex sm:flex-row-reverse">
                                    <button type="submit"
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Sauvegarder
                                    </button>
                                    <button type="button"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                            onclick="toggleModal('modal-{{ $icon->id }}')">Annuler
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

    <div id="addSkillModal" class="modal hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-800 bg-opacity-75 transition-opacity"></div> <!-- Overlay -->

            <div class="bg-gray-900 rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6"
                 style="height: 100vh; width: 100vh">
                <div class="container mx-auto px-4 py-8">
                    <h1 class="text-2xl font-bold text-center mb-6 text-white">Ajouter une compétence</h1>
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-700 border border-green-800 text-green-200 px-4 py-3 rounded relative"
                             role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('skills.store') }}" method="POST"
                          class="bg-gray-700 shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Nom de la
                                compétence:</label>
                            <input type="text" name="name" id="name" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-800 border-gray-600 placeholder-gray-500 text-white">
                        </div>

                        <h3 class="text-gray-300 text-sm font-bold mb-2">SVGs (entrer le contenu SVG comme texte)</h3>
                        <div id="svg-inputs">
                            <!-- Les champs SVG seront générés par le JavaScript ci-dessous -->
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Ajouter la compétence
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Close Button -->
                <div class="text-right">
                    <button onclick="toggleModal('addSkillModal')" class="text-white hover:text-gray-300">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function toggleModal(modalID) {
        const modal = document.getElementById(modalID);
        modal.classList.toggle('hidden');
    }

    document.querySelector('.open-modal-button').addEventListener('click', function () {
        toggleModal('addSkillModal');
    });

    function toggleModal(modalID) {
        const modal = document.getElementById(modalID);
        modal.classList.toggle('hidden');
    }

    const svgInputsContainer = document.getElementById('svg-inputs');

    function addSvgInput(index) {
        const div = document.createElement('div');
        div.classList.add('mb-4');
        div.innerHTML = `
            <div class="mb-2">
                <label for="svg_name${index}" class="block text-white-700 text-sm font-bold mb-2">Nom SVG ${index + 1} :</label>
                <input type="text" name="svg_names[]" id="svg_name${index}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label for="svg${index}" class="block text-gray-700 text-sm font-bold mb-2">SVG ${index + 1} :</label>
                <textarea name="svgs[]" id="svg${index}" rows="5" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" oninput="renderSvg(this.value, 'svg-preview${index}')"></textarea>
                <div id="svg-preview${index}" class="mt-2 border rounded p-2"></div>
            </div>
        `;
        svgInputsContainer.appendChild(div);
    }

    function renderSvg(svgContent, previewElementId) {
        const previewElement = document.getElementById(previewElementId);
        previewElement.innerHTML = svgContent;
    }

    for (let i = 0; i < 5; i++) {
        addSvgInput(i);
    }
</script>
@include("includes/footer")

