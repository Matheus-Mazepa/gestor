@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.users.clients.edit')" url-back="{{ route('client.bills.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.bills.edit')
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
                          action="{{ route('users.update', $user->id) }}">

                        @method('PUT')
                        @include('client.users._partials._form')

                        <button class="btn btn-warning" type="submit">
                            @lang('buttons.common.save_editions')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
