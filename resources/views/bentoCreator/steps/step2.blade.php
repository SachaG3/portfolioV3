<!-- resources/views/bentoCreator/steps/step2.blade.php -->
<div id="cards-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
    <h2 class="text-2xl font-semibold">Carte</h2>
    <div class="card mb-3">
        <div class="form-group">
            <label for="card[type]" class="block text-sm font-medium text-gray-700">Type de carte</label>
            <input type="text" name="card[type]" class="input input-bordered w-full" required>
        </div>
        <div class="form-group">
            <label for="card[contenu]" class="block text-sm font-medium text-gray-700">Contenu</label>
            <textarea name="card[contenu]" class="textarea textarea-bordered w-full"></textarea>
        </div>
        <div class="form-group">
            <label for="card[image]" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" name="card[image]" class="input input-bordered w-full">
        </div>
    </div>
</div>
