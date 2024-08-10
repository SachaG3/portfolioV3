<!-- resources/views/bentoCreator/steps/step4.blade.php -->
<div id="participants-container" class="space-y-4 p-6 bg-gray-50 rounded-lg shadow">
    <h2 class="text-2xl font-semibold">Participants</h2>
    <div class="participant mb-3" data-index="0">
        <div class="form-group">
            <label for="participants[0][nom]" class="block text-sm font-medium text-gray-700">Nom du participant</label>
            <input type="text" name="participants[0][nom]" class="input input-bordered w-full" required>
        </div>
        <div class="form-group">
            <label for="participants[0][avatar]" class="block text-sm font-medium text-gray-700">Avatar</label>
            <input type="text" name="participants[0][avatar]" class="input input-bordered w-full">
        </div>
    </div>
    <div class="flex justify-center">
        <button type="button" class="btn btn-secondary" onclick="addParticipant()"><i class="fas fa-plus"></i> Ajouter
            un participant
        </button>
    </div>
</div>

<script>
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
</script>
