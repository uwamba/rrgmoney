@extends('layouts.app')

@section('title', 'Topup List')

@section('content')
    <div class="container-fluid">

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <livewire:transfer-report searchable="name, email" exportable />
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    @livewireScripts

@endsection
