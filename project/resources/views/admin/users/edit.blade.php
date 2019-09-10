@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.users.admins.edit')" url-back="{{ route('admin.users.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.users.admins.edit')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @method('PUT')
                        @include('admin.users.partials._form')
                        <button class="btn btn-primary" type="submit">
                            @lang('buttons.common.save_editions')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
