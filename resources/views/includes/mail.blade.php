<style>
    .larger-input {
        padding: 0.50rem;
        font-size: 1.1rem;
    }
    .larger-area{
        padding: 1rem;
        font-size: 1.1rem;
    }
</style>
<section class="isolate py-10 px-6 sm:py-32 lg:px-8" id="contacter" itemscope itemtype="https://schema.org/ContactPage">
    <div class="mx-auto max-w-2xl text-center">
        <h2 class="text-3xl font-bold text-center" itemprop="headline">Me contacter</h2>
        <p class="mt-2 text-lg leading-8" itemprop="description">Si vous souhaitez me contacter pour obtenir
            des renseignements, vous pouvez le faire en utilisant ce formulaire.</p>
    </div>
    <form action="{{route("mail")}}" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20" itemprop="potentialAction"
          itemscope itemtype="https://schema.org/ContactAction">
        @csrf
        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
            <div>
                <label for="first-name" class="block text-sm font-semibold leading-6">Prénom</label>
                <input type="text" name="first-name" id="first-name" autocomplete="given-name"
                       class="larger-input mt-2.5 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-base-300 dark:text-white"
                       itemprop="name">
            </div>
            <div>
                <label for="last-name" class="block text-sm font-semibold leading-6">Nom de famille</label>
                <input type="text" name="last-name" id="last-name" autocomplete="family-name"
                       class="larger-input mt-2.5 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-base-300 dark:text-white"
                       itemprop="familyName">
            </div>
            <div class="sm:col-span-2">
                <label for="email" class="block text-sm font-semibold leading-6">Email</label>
                <input type="email" name="email" id="email" autocomplete="email"
                       class="larger-input mt-2.5 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-base-300 dark:text-white"
                       itemprop="email">
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="block text-sm font-semibold leading-6">Message</label>
                <textarea name="message" id="message" rows="4"
                          class="larger-area mt-2.5 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-base-300 dark:text-white"
                          itemprop="text"></textarea>
            </div>
        </div>
        <div class="mt-10">
            <button type="submit"
                    class="block w-full btn btn-primary">
                Envoyer
            </button>
        </div>
    </form>
</section>
