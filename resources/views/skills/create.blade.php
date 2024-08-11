@include("includes/admin-header")
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-6">Ajouter une compétence</h1>

    @if(session('success'))
        <div class="bg-green-700 border border-green-800 text-green-200 px-4 py-3 rounded relative" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('skills.store') }}" method="POST" class="bg-gray-700 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Nom de la compétence:</label>
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

<script>
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
