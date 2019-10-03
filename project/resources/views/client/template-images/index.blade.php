@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.template_images.index')">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.template_images.index')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <data-list data-source="{{ route('client.pagination.template_images') }}"></data-list>
        </div>
    </div>
@endsection

@section('custom-template')
    <template id="data-list" slot-scope="modelScope">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="btnGroupAddon2">
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </div>
                                    <input
                                            type="text"
                                            id="search"
                                            v-model="query"
                                            class="form-control"
                                            placeholder="Buscar ..."
                                            aria-describedby="btnGroupAddon2">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    @include('client.template-images.partials._head')
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in items" :key="index">
                                    @include('client.template-images.partials._body')
                                    <td>
                                        @include('client.template-images.partials.buttons-actions')
                                        @include('shared.partials._buttons_actions')
                                    </td>
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
