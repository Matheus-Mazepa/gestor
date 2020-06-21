@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.companies.users.create') {{$company->name}}" url-back="{{ route('admin.users.index', $company->id) }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item href="{{ route('admin.companies.index') }}">
            @lang('headings.companies.index')
        </breadcrumb-item>

        <breadcrumb-item href="{{ route('admin.users.index', $company->id) }}">
            @lang('headings.companies.users.index')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.companies.users.create') {{$company->name}}
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('admin.users.store',  $company->id) }}">
                        @include('admin.users_admin._partials._form')
                        <button class="btn btn-success" type="submit">
                            @lang('buttons.common.save')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
