<!-- resources/views/bentoCreator/steps/step1.blade.php -->
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
    <div class="form-group">
        <label for="lien" class="block text-sm font-medium text-gray-700">Lien</label>
        <input type="text" name="lien" id="lien" class="input input-bordered w-full">
    </div>
</div>
