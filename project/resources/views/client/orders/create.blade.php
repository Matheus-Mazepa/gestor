@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.orders.create')" url-back="{{ route('client.orders.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.orders.create')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('client.orders.store') }}">
                        @include('client.orders._partials._form')
                        <button class="btn btn-success" type="submit">
                            @lang('buttons.common.save')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
