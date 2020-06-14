@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.clients.edit')" url-back="{{ route('client.clients.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.clients.edit')
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
                          action="{{ route('client.clients.update', $client->id) }}">

                        @method('PUT')
                        <client-form
                                :old='@json(old())'
                                :client='@json($client)'
                                :errors-bag='@json($errors)'
                        ></client-form>
                        <button class="btn btn-warning" type="submit">
                            @lang('buttons.common.save_editions')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
