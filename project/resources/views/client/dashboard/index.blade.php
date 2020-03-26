@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.common.dashboard')">
        <breadcrumb-item href="{{ route('home') }}" active>
            @lang('headings.common.home')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('admin.dashboard._partials._tabs')
            @can('dashboard view')
                <general
                        top-users-url="{{ route('ajax.admin.dashboards.get-top-users') }}"
                        templates-most-used-url="{{ route('ajax.admin.dashboards.get-template-most-used')}}"
                        users-per-month-url="{{ route('ajax.admin.dashboards.get-users-per-month')}}"
                        users-has-users-groups-url="{{ route('admin.dashboards.pagination.users-and-user-groups') }}"
                ></general>
            @endcan
        </div>
    </div>
@endsection
