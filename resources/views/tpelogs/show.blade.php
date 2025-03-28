@extends('layouts.app')

@section('content')
<div class="container mt-1">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4>View Workout Log</h4>
            <a href="{{ route('tpelogs.index') }}" class="text-white text-decoration-none">✖ Close</a>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3 no-print">
                <button onclick="window.print()" class="btn btn-warning">
                    <i class="fas fa-print me-1"></i> Print / Save as PDF
                </button>
            </div>

            <div id="print-area">
                @include('tpelogs.show_fields')
            </div>

            <button onclick="window.print()" class="btn btn-warning mt-3 no-print">Print / Save as PDF</button>
        </div>
    </div>
</div>
@endsection

<style>
@media print {
    body, html {
        margin: 0 !important;
        padding: 0 !important;
        width: 100%;
        height: 100%;
    }

    body * {
        visibility: hidden;
    }

    #print-area, #print-area * {
        visibility: visible;
    }

    #print-area {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 0;
        background: white;
        z-index: 9999;
    }

    .container,
    .card,
    .card-body,
    .card-header {
        all: unset;
        display: block;
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12pt;
    }

    th, td {
        border: 1px solid #000;
        padding: 10px;
        text-align: left;
    }

    .no-print, .sidebar, nav, .navbar, footer {
        display: none !important;
    }
}
</style>




