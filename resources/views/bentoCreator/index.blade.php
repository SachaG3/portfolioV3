<!-- resources/views/bentoCreator/create.blade.php -->
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
</head>
@include('includes.header')
<div class="container mx-auto p-8 bg-white shadow-lg rounded-lg max-w-4xl">
    <h1 class="text-3xl font-bold mb-6 text-center">Créer un nouveau projet</h1>

    <form id="project-form" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data"
          class="space-y-6">
        @csrf

        <!-- Include steps -->
        @include('bentoCreator.steps.step1')
        @include('bentoCreator.steps.step2')
        @include('bentoCreator.steps.step3')
        @include('bentoCreator.steps.step4')
        @include('bentoCreator.steps.step5')
        @include('bentoCreator.steps.step6')
        @include('bentoCreator.steps.step7')

        <!-- Soumettre le formulaire -->
        <div class="flex justify-center mt-6">
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Créer le projet</button>
        </div>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
