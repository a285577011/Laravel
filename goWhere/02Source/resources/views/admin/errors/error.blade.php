@extends('admin.layouts.errorpage')
@section('errorMsg')
{{isset($exception) && $exception->getMessage() ? $exception->getMessage() : 'something is wrong'}}
@endsection