@extends('layouts.app')

@section('title', 'Topup List')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <livewire:transfer-chart/>
                    </div>
                </div>
            </div>
        </div>
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
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
@livewireChartsScripts
@endsection




