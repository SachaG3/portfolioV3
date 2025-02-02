@if(session('authenticated'))
    @include('includes/admin-header')
@else
    @include('includes/header')
@endif

@include('sections.bento')

@include('sections.accueil')

@include('sections.apropos')

@include('sections.cursus')

@include('sections.competence')

@include('sections.mesProjet')

@include('sections.mail')

@include('includes/footer')


