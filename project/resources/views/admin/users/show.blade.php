@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.users.admins.show')" url-back="{{ route('admin.users.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.users.admins.show')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{$user->name}} <br>
                    {{$user->email}}
                </div>
            </div>
        </div>
    </div>
@endsection
