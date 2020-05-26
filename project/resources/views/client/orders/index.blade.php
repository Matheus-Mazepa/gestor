@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.orders.index')">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.orders.index')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <data-list
                    data-source="{{ route('client.pagination.orders') }}"
                    delete-message="@lang('phrases.common.delete')"
                    url-create="{{ route('client.orders.create') }}"
                    l label-create="@lang('buttons.common.create_new')"
            ></data-list>
        </div>
    </div>
@endsection

@section('custom-template')
    <template id="data-list" slot-scope="modelScope">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <div class="card-header mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <a v-if="urlCreate" :href="urlCreate">
                                        <button class="btn btn-secondary mb-2">@{{labelCreate}}</button>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <input type="text"
                                           v-model="query"
                                           class="form-control"
                                           placeholder="Buscar ...">
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        @include('client.orders._partials._head')
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in items" :key="index">
                                        @include('client.orders._partials._body')
                                        <td>@include('shared.partials._buttons_actions')</td>
                                    </tr>
                                    </tbody>
                                </table>
                                @include('shared.partials._pagination')
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </template>
@endsection
