<div class="bg-white d-flex justify-content-between align-items-center p-3 mb-5 rounded-3">
    <strong class="handwriting text-center fs-1">{{ $title }}</strong>

    @isset($createRoute)
        <a href="{{ $createRoute }}" class="text-decoration-none">
            <button class="btn btn-success" type="button">
                + New Project
            </button>
        </a>
    @endisset
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 admin-resource-table">
            <thead class="table-head-font">
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
