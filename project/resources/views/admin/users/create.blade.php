@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="Criar usuário">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings._home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.users.create')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('admin.users.store') }}">
                        @include('admin.users.partials._form')
                        <button class="btn btn-primary" type="submit">@lang('links._create')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
