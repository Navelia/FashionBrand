@foreach($dimensions as $dimension)
    <option value="{{ $dimension->id }}" stock="{{ $dimension->stock }}" dimension="{{ strtoupper($dimension->dimension) }}">{{ strtoupper($dimension->dimension) }} (Stok: {{ $dimension->stock }})</option>
@endforeach