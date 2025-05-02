@foreach($courriers as $courrier)
    <tr>
        <td>{{ $courrier->reference }}</td>
        <td>{{ $courrier->created_at->format('d-m-Y') }}</td>
        <td><span class="status {{ $courrier->status }}">{{ ucfirst($courrier->status) }}</span></td>
    </tr>
@endforeach

@if ($courriers->hasPages())
    <div class="pagination">
        {{ $courriers->links() }}
    </div>
@endif
