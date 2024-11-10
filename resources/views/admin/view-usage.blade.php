@extends('layouts.admin-app-main')

@section('content')
    <div class="container-fluid ">
        <h1 class="">View Usage Analysis</h1>
        <div id="viewUsageAccordion" class="pb-5">
            @php
                $groupedUsages = [];
                foreach ($usages as $view => $usageDetails) {
                    $pathParts = explode('.', $view);
                    $folder = count($pathParts) > 1 ? $pathParts[0] : 'root';
                    $groupedUsages[$folder][] = [
                        'view' => $view,
                        'usageDetails' => $usageDetails
                    ];
                }
            @endphp

            @foreach ($groupedUsages as $folder => $views)
                <div class="card">
                    <div class="card-header bg-info text-white" data-toggle="collapse"
                         data-target="#collapse-folder-{{ $folder }}">
                        <h5 class="mb-0">
                            {{ ucfirst($folder) }}
                        </h5>
                    </div>

                    <div id="collapse-folder-{{ $folder }}" class="collapse show">
                        <div class="card-body">
                            @foreach ($views as $viewData)
                                <div class="card">
                                    <div class="card-header view-usage" id="heading-{{ Str::slug($viewData['view']) }}"
                                         data-toggle="collapse"
                                         data-target="#collapse-{{ Str::slug($viewData['view']) }}">
                                        <h5 class="mb-0">
                                            <span
                                                class="badge {{ $viewData['usageDetails'] == 'Non utilisée' ? 'badge-danger' : 'badge-success' }}">
                                                {{ $viewData['view'] }}
                                            </span>
                                        </h5>
                                    </div>

                                    <div id="collapse-{{ Str::slug($viewData['view']) }}" class="collapse ">
                                        <div class="card-body">
                                            @if ($viewData['usageDetails'] == "Non utilisée")
                                                <p class="text-danger">Cette vue n'est pas utilisée.</p>
                                            @else
                                                @foreach ($viewData['usageDetails'] as $detail)
                                                    <div class="usage-details mb-3">
                                                        <strong>Type:</strong> {{ ucfirst($detail['type']) }} <br>
                                                        <strong>Fichier:</strong> <code>{{ $detail['file'] }}</code>
                                                        <br>
                                                        <strong>Ligne:</strong> <span
                                                            class="badge badge-primary">{{ $detail['line'] }}</span>
                                                        <br>
                                                        <pre class="bg-light p-2">{{ $detail['content'] }}</pre>
                                                        <hr>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.view-usage').on('click', function () {
                $(this).next('.collapse').collapse('toggle');
            });

            $('.card-header').on('click', function () {
                const target = $(this).data('target');
                $(target).collapse('toggle');
            });
        });
    </script>
@endsection

