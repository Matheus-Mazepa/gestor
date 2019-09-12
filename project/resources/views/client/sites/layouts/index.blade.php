@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.layouts.index')">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.layouts.index')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h1 class="card-header text-uppercase text-center">
                    @lang('headings.layouts.index')
                </h1>

                <div class="card-body">
                    <cards-layout :layouts="{{ $layouts }}"></cards-layout>
                </div>
            </div>
        </div>
    </div>
@endsection
