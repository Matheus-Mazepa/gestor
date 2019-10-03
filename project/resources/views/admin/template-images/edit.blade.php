@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.template_images.index')"
                url-back="{{ route('admin.template_images.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.template_images.edit')
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
                          action="{{ route('admin.template_images.edit', $templateImages->id) }}">

                        <button class="btn btn-warning" type="submit">
                            @lang('buttons.common.edit')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
