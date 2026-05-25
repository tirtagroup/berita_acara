@extends('layouts/layoutMaster')

@section('title', 'Print & Sign Berita Acara - ' . ($ba->Tr_BA_Main_Code ?? 'N/A'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y" style="max-width: 900px;">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12 text-center mb-3">
      <h3 class="mb-1">BERITA ACARA (BA)</h3>
      <h5 class="text-muted">Incident & Event Report</h5>
    </div>
  </div>

  <!-- Main Content Area (printable) -->
  <div id="printable-area" class="card">
    <div class="card-body">
      <!-- Identitas BA -->
      <div class="row mb-4">
        <div class="col-md-6">
          <dl class="row mb-2">
            <dt class="col-sm-5"><strong>BA Code:</strong></dt>
            <dd class="col-sm-7">{{ $ba->Tr_BA_Main_Code ?? '—' }}</dd>
            
            <dt class="col-sm-5"><strong>Date:</strong></dt>
            <dd class="col-sm-7">{{ $ba->Date_BA ? \Carbon\Carbon::parse($ba->Date_BA)->format('d/m/Y') : '—' }}</dd>
            
            <dt class="col-sm-5"><strong>Type/Context:</strong></dt>
            <dd class="col-sm-7">
              <span class="badge bg-primary">{{ $ba->Ms_BA_type_Code ?? 'GENERAL' }}</span>
            </dd>
          </dl>
        </div>
        <div class="col-md-6">
          <dl class="row mb-2">
            <dt class="col-sm-5"><strong>Creator:</strong></dt>
            <dd class="col-sm-7">{{ $ba->Ms_Emp_Code ?? '—' }}</dd>
            
            <dt class="col-sm-5"><strong>Company:</strong></dt>
            <dd class="col-sm-7">{{ $ba->Ms_Company ?? '—' }}</dd>
            
            <dt class="col-sm-5"><strong>Location:</strong></dt>
            <dd class="col-sm-7">{{ $ba->Ms_Location ?? '—' }}</dd>
          </dl>
        </div>
      </div>

      <hr class="my-4" />

      <!-- Main Content -->
      <div class="mb-4">
        <h6 class="fw-bold mb-2">Incident Description</h6>
        <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9; min-height: 100px;">
          {!! nl2br(e($ba->ba_deskripsi ?? '—')) !!}
        </div>
      </div>

      <!-- Findings / Cases -->
      @if(!empty($ba->ba_temuan))
      <div class="mb-4">
        <h6 class="fw-bold mb-2">Findings / Issues Found</h6>
        <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9;">
          {!! nl2br(e($ba->ba_temuan)) !!}
        </div>
      </div>
      @endif

      <!-- Recommendations -->
      @if(!empty($ba->ba_rekomendasi))
      <div class="mb-4">
        <h6 class="fw-bold mb-2">Recommendations</h6>
        <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9;">
          {!! nl2br(e($ba->ba_rekomendasi)) !!}
        </div>
      </div>
      @endif

      <hr class="my-4" />

      <!-- Signature Section -->
      <div class="row mt-5">
        <h6 class="fw-bold mb-4 col-12">Approval & Signature</h6>

        <!-- Supervisor (SPV) -->
        <div class="col-md-6 mb-5">
          <div style="border: 1px solid #999; padding: 15px; text-align: center; min-height: 120px;">
            <div style="margin-bottom: 60px; font-weight: bold; color: #ccc;">Signature Area</div>
            <p class="mb-0"><strong>Supervisor</strong></p>
            <p class="text-muted small">Name & Date</p>
          </div>
        </div>

        <!-- Head of Division (HOD) -->
        <div class="col-md-6 mb-5">
          <div style="border: 1px solid #999; padding: 15px; text-align: center; min-height: 120px;">
            <div style="margin-bottom: 60px; font-weight: bold; color: #ccc;">Signature Area</div>
            <p class="mb-0"><strong>Head of Division (HOD)</strong></p>
            <p class="text-muted small">Name & Date</p>
          </div>
        </div>

        <!-- Manager / Coordinator -->
        <div class="col-md-6 mb-5">
          <div style="border: 1px solid #999; padding: 15px; text-align: center; min-height: 120px;">
            <div style="margin-bottom: 60px; font-weight: bold; color: #ccc;">Signature Area</div>
            <p class="mb-0"><strong>Manager / Coordinator</strong></p>
            <p class="text-muted small">Name & Date</p>
          </div>
        </div>

        <!-- BOD / Top Management -->
        <div class="col-md-6 mb-5">
          <div style="border: 1px solid #999; padding: 15px; text-align: center; min-height: 120px;">
            <div style="margin-bottom: 60px; font-weight: bold; color: #ccc;">Signature Area</div>
            <p class="mb-0"><strong>BOD / General Manager</strong></p>
            <p class="text-muted small">Name & Date</p>
          </div>
        </div>
      </div>

      <hr class="my-4" />

      <!-- Notes -->
      <div class="alert alert-info small">
        <strong>Instruction:</strong> Print this form, collect signatures from Supervisor → Head of Division → Manager → BOD in order. 
        Once all signatures are obtained, scan and upload the signed document for record-keeping.
      </div>

    </div>
  </div>

  <!-- Action Buttons -->
  <div class="row mt-4 mb-5">
    <div class="col-12">
      <button type="button" class="btn btn-primary" onclick="window.print()">
        <i class="bx bx-printer"></i> Print Form
      </button>
      <a href="{{ route('berita-acara-v2.list') }}" class="btn btn-secondary">
        <i class="bx bx-arrow-back"></i> Back to List
      </a>
    </div>
  </div>

</div>

<style media="print">
  body { margin: 0; padding: 10mm; background: white; }
  .btn, .alert { display: none; }
  .container-xxl { max-width: 100%; margin: 0; padding: 0; }
  .card { border: none; box-shadow: none; }
  .card-body { padding: 0; }
  #printable-area { page-break-inside: avoid; }
</style>

@endsection
