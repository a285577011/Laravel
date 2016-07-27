@extends('admin.layouts.errorpage')
@section('errorMsg')
{{isset($exception) && $exception->getMessage() ? $exception->getMessage() : '禁止访问'}}
@endsection