@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.products.edit')" url-back="{{ route('client.products.index') }}">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item href="{{ route('client.products.index') }}">
            @lang('headings.products.index')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.products.edit')
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
                          action="{{ route('client.products.update', $product->id) }}">

                        @method('PUT')
                        @include('client.products._partials._form')

                        <button class="btn btn-warning" type="submit">
                            @lang('buttons.common.save_editions')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
