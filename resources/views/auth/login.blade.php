@extends('layouts.app')

@section('content')    
    <login csrf_token="{{ @csrf_token() }}"></login>
@endsection
