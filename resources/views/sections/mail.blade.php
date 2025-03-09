<style>
    .larger-input {
        padding: 0.50rem;
        font-size: 1.1rem;
    }

    .larger-area {
        padding: 1rem;
        font-size: 1.1rem;
    }

    .modal-box-custom {
        border-radius: 1rem;
        backdrop-filter: blur(8px);
    }

    .pas-bouger {
        overflow: hidden !important;
    }

    /* Animation d'ouverture */
    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>


<div id="mail-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="modal-box modal-box-custom relative p-6 bg-base-200 overflow-auto">
        <button class="btn btn-sm btn-circle absolute right-4 top-4" onclick="closeMailModal()">✕</button>

        <section class="py-6 px-4 sm:py-8 lg:px-6" id="contacter" itemscope itemtype="https://schema.org/ContactPage">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold " itemprop="headline">Me contacter</h2>
                <p class="mt-2 text-lg " itemprop="description">
                    Si vous souhaitez me contacter pour obtenir des renseignements, utilisez ce formulaire.
                </p>
            </div>
            <form action="{{ route('mail') }}" method="POST" class="mx-auto mt-3 max-w-xl" itemprop="potentialAction"
                  itemscope itemtype="https://schema.org/ContactAction">
                @csrf
                <div class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2">
                    <div>
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name"
                               class="input input-bordered larger-input mt-2 w-full" itemprop="name"
                               placeholder="Prénom">
                    </div>
                    <div>
                        <input type="text" name="last-name" id="last-name" autocomplete="family-name"
                               class="input input-bordered larger-input mt-2 w-full" itemprop="familyName"
                               placeholder="Nom de famille">
                    </div>
                    <div class="sm:col-span-2">
                        <input type="email" name="email" id="email" autocomplete="email"
                               class="input input-bordered larger-input mt-2 w-full" itemprop="email"
                               placeholder="Email">
                    </div>
                    <div class="sm:col-span-2">
                        <textarea name="message" id="message" rows="4"
                                  class="textarea textarea-bordered larger-area mt-2 w-full" itemprop="text"
                                  placeholder="Message"></textarea>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="btn btn-primary w-full">Envoyer</button>
                </div>
            </form>
        </section>
    </div>
</div>

<script>
    function openMailModal() {
        var modal = document.getElementById('mail-modal');
        modal.classList.remove('hidden');

        // On ajoute l'animation en retirant puis réappliquant la classe fade-in pour relancer l'animation
        var modalBox = modal.querySelector('.modal-box');
        modalBox.classList.remove('fade-in');
        void modalBox.offsetWidth; // déclenche le reflow
        modalBox.classList.add('fade-in');

        document.getElementById('accueil').classList.add('pas-bouger');
    }

    function closeMailModal() {
        document.getElementById('mail-modal').classList.add('hidden');
        document.getElementById('accueil').classList.remove('pas-bouger');
    }

    document.getElementById('mail-modal').addEventListener('click', function (event) {
        if (event.target === this) closeMailModal();
    });
</script>
