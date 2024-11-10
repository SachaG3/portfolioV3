@include('includes.admin-header')

<div class="container-fluid">
    <h1 class="">Controller Method Usage Analysis</h1>
    <div id="controllerUsageAccordion">
        @foreach ($usages as $controller => $methods)
            <div class="card">
                <div class="card-header bg-info text-white" data-toggle="collapse"
                     data-target="#collapse-controller-{{ Str::slug($controller) }}">
                    <h5 class="mb-0">
                        {{ $controller }}
                    </h5>
                </div>

                <div id="collapse-controller-{{ Str::slug($controller) }}" class="collapse show">
                    <div class="card-body">
                        @foreach ($methods as $method => $usageDetails)
                            <div class="card">
                                <div class="card-header view-usage"
                                     id="heading-{{ Str::slug($controller) }}-{{ Str::slug($method) }}"
                                     data-toggle="collapse"
                                     data-target="#collapse-method-{{ Str::slug($controller) }}-{{ Str::slug($method) }}">
                                    <h5 class="mb-0">
                                            <span
                                                class="badge {{ is_array($usageDetails) ? 'badge-success' : 'badge-danger' }}">
                                                {{ $method }} ({{ is_array($usageDetails) ? count($usageDetails) : 0 }} utilisations)
                                            </span>
                                    </h5>
                                </div>

                                <div id="collapse-method-{{ Str::slug($controller) }}-{{ Str::slug($method) }}"
                                     class="collapse">
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
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('.card-header').on('click', function () {
            const target = $(this).data('target');
            $(target).collapse('toggle');
        });
    });
</script>
@include('includes.footer')
