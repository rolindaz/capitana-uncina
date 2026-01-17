<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>{{ $title }}</strong>

        @isset($createRoute)
            <a href="{{ $createRoute }}" class="btn btn-primary btn-sm">
                + Create
            </a>
        @endisset
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    {{ $head }}
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
                {{ $body }}
                @if (trim($body) === '')
                    <tr>
                        <td colspan="100%" class="text-center text-muted py-4">
                            No records found.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
