@extends('layouts.admin-app-main')

@section('content')
    <div class="container-fluid">
        <h1>Model Usage Analysis</h1>
        <div id="modelUsageAccordion">
            @foreach ($usages as $model => $usageDetails)
                <div class="card">
                    <div
                        class="card-header {{ is_array($usageDetails) ? 'bg-info text-white' : 'bg-danger text-white' }}"
                        data-toggle="collapse"
                        data-target="#collapse-model-{{ Str::slug($model) }}">
                        <h5 class="mb-0">
                            {{ $model }}
                        </h5>
                    </div>

                    <div id="collapse-model-{{ Str::slug($model) }}" class="collapse">
                        <div class="card-body">
                            @if (is_array($usageDetails))
                                @foreach ($usageDetails as $detail)
                                    <div class="usage-details mb-3">
                                        <strong>Fichier:</strong> <code>{{ $detail['file'] }}</code>
                                        <br>
                                        <strong>Ligne:</strong> <span
                                            class="badge badge-primary">{{ $detail['line'] }}</span>
                                        <br>
                                        <pre class="bg-light p-2">{{ $detail['content'] }}</pre>
                                        <hr>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-danger">{{ $usageDetails }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Fermer tous les éléments de l'accordéon par défaut
            $('#modelUsageAccordion .collapse').collapse('hide');

            $('.card-header').on('click', function () {
                const target = $(this).data('target');
                $(target).collapse('toggle');
            });
        });
    </script>
@endsection
