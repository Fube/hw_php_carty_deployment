@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <ul>
            <li><a class="rounded-lg bg-blue-300 my-5 block text-center px-20" href="{{ route('admin/insert') }}">Insert</a></li>
            <li><a class="rounded-lg bg-blue-300 my-5 block text-center px-20" href="{{ route('admin/update') }}">Update</a></li>
        </ul>
    </div>
@endsection