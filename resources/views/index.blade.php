@if(session('authenticated'))
    @include('includes/admin-header')
@else
    @include('includes/header')
@endif

@include('includes/bento')

@include('includes/accueil')

@include('includes/apropos')

@include('includes/cursus')

@include('includes.competence')

@include('includes.mesProjet')

@include('includes/mail')

@include('includes/footer')


