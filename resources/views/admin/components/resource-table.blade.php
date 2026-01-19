<div class="bg-white d-flex justify-content-between align-items-center p-3 mb-5 rounded-3">
    <strong class="handwriting text-center fs-1">{{ $title }}</strong>

    @isset($createRoute)
        <a href="{{ $createRoute }}" class="create-btn">
                {{ $action ?? '+ Nuovo' }}
        </a>
    @endisset
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 admin-resource-table">
            <thead class="precise-font">
                <tr>
                    {{ $head }}
                    <th>Azioni</th>
                </tr>
            </thead>

            <tbody class="precise-font">
                {{ $body }}
                @if (trim($body) === '')
                    <tr>
                        <td colspan="100%" class="text-center text-muted py-4">
                            Qui non c'è niente!
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
