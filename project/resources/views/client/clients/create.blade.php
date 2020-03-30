@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.clients.create')" url-back="{{ route('client.clients.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.clients.create')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('client.clients.store') }}">
                        @csrf
                        {{$errors}}

                        <client-form
                            :old='@json(old())'
                            :errors-bag='@json($errors)'
                        ></client-form>
                        <button class="btn btn-success" type="submit">
                            @lang('buttons.common.save')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
