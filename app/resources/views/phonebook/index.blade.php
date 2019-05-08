@extends("layouts.app")
@section("content")

    <h1 class="tw-text-red">Entries</h1>
    
    @foreach ($entries as $entry)

        <p>{{ $entry }}</p>

    @endforeach

@endsection