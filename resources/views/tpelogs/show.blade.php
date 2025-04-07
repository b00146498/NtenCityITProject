@extends('layouts.app')

@section('content')
<div class="container mt-1 print-no-margin">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between no-print">
            <h4>View Workout Log</h4>
            <a href="{{ route('tpelogs.index') }}" class="text-white text-decoration-none">✖ Close</a>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3 no-print">
                <button onclick="window.print()" class="btn btn-warning">
                    <i class="fas fa-print me-1"></i> Print / Save as PDF
                </button>
            </div>

            <!-- ✅ Print area only -->
            <div id="print-area">
                @include('tpelogs.show_fields')
            </div>

            <div class="d-flex justify-content-end mt-3 no-print">
                <a href="{!! route('tpelogs.index') !!}" class="btn btn-outline-dark px-4 py-2">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
@media print {
    @page {
        size: A4 portrait;
        margin: 10mm;
    }

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
<<<<<<< HEAD
        padding: 10px;
=======
        margin: 0;
        padding: 0;
>>>>>>> abd2327c01dee8f7b3c7ffa470c3abd42669ff7a
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
<<<<<<< HEAD
        font-size: 10pt;
=======
        font-size: 12pt;
>>>>>>> abd2327c01dee8f7b3c7ffa470c3abd42669ff7a
    }

    th, td {
        border: 1px solid #000;
<<<<<<< HEAD
        padding: 6px;
        text-align: left;
    }

    h4, h5 {
        font-size: 14pt;
        margin: 5px 0;
    }

    .no-print, .sidebar, nav, .navbar, footer {
        display: none !important;
    }

    .print-no-margin {
        margin: 0 !important;
        padding: 0 !important;
    }
}
</style>
=======
        padding: 10px;
        text-align: left;
    }

    .no-print, .sidebar, nav, .navbar, footer {
        display: none !important;
    }
}
</style>




>>>>>>> abd2327c01dee8f7b3c7ffa470c3abd42669ff7a
