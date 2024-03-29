@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="@lang('headings.common.dashboard')">
        <breadcrumb-item href="{{ route('home') }}" active>
            @lang('headings.common.home')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
