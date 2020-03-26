@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.financial_schedule.index')">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.financial_schedule.index')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="col-sm-12">
                <div class="card">
                    <div class="col-sm-2 mt-3 ml-3">
                        <a href="{{ route('bills.create') }}">
                            <button class="btn btn-secondary mb-2">{{__('buttons.common.create')}}</button>
                        </a>
                    </div>
                    <my-calendar></my-calendar>
                </div>
            </div>
        </div>
    </div>
@endsection