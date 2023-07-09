@foreach($dimensions as $dimension)
    <option value="{{ $dimension }}">{{ strtoupper($dimension) }}</option>
@endforeach