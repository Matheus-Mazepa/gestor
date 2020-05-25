@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.categories.create')" url-back="{{ route('client.categories.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.categories.create')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('client.categories.store') }}">
                        @include('client.categories._partials._form')
                        <button class="btn btn-success" type="submit">
                            @lang('buttons.common.save')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
