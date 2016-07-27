@extends('admin.layouts.errorpage')
@section('errorMsg')
{{isset($exception) && $exception->getMessage() ? $exception->getMessage() : '请稍候再试'}}
@endsection