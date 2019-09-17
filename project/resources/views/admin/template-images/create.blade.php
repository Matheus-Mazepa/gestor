@extends('layouts.app')

@section('header')
    <link href="{{ mix('assets/css/editor.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <breadcrumb header="@lang('headings.template_images.index')"
                url-back="{{ route('admin.template_images.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.template_images.create')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal"
                          method="POST"
                          action="{{ route('admin.template_images.create') }}">
                        @include('admin.template-images.partials._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ mix('assets/js/editor.js') }}"></script>
@endsection
