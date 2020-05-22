@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.users.show')" url-back="{{ route('client.products.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.products.show')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">
                                    @lang('labels.common.title')
                                </label>
                                <div class="input-group">
                                    <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            class="form-control"
                                            value="{{ $product->title ?? '' }}"
                                            disabled>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">
                                    @lang('labels.common.description')
                                </label>
                                <div class="input-group">
                                    <input
                                            type="email"
                                            name="email"
                                            id="email"
                                            class="form-control"
                                            value="{{ $product->description }}"
                                            disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
