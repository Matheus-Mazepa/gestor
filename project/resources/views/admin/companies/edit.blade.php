@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.admin.edit')" url-back="{{ route('admin.companies.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item href="{{ route('admin.companies.index') }}">
            @lang('headings.companies.index')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.companies.edit')
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
                          action="{{ route('admin.companies.update', $company->id) }}">

                        @method('PUT')
                        @include('client.companies._partials._form')

                        <button class="btn btn-warning" type="submit">
                            @lang('buttons.common.save_editions')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
