@extends('layouts/layoutMaster')

@section('title', 'Print & Sign PICA - ' . ($pica->Tr_Pica_Emp_h_Code ?? 'N/A'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y" style="max-width: 900px;">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12 text-center mb-3">
      <h3 class="mb-1">PICA FORM</h3>
      <h5 class="text-muted">Problem Identification, Corrective & Preventive Action</h5>
    </div>
  </div>

  <!-- Main Content Area (printable) -->
  <div id="printable-area" class="card">
    <div class="card-body">
      <!-- Identitas PICA -->
      <div class="row mb-4">
        <div class="col-md-6">
          <dl class="row mb-2">
            <dt class="col-sm-5"><strong>PICA Code:</strong></dt>
            <dd class="col-sm-7">{{ $pica->Tr_Pica_Emp_h_Code }}</dd>
            
            <dt class="col-sm-5"><strong>Date:</strong></dt>
            <dd class="col-sm-7">{{ $pica->Date_PICA ? \Carbon\Carbon::parse($pica->Date_PICA)->format('d/m/Y') : '—' }}</dd>
            
            <dt class="col-sm-5"><strong>Status:</strong></dt>
            <dd class="col-sm-7">
              <span class="badge bg-primary">{{ $pica->Status_PICA ?? 'UNKNOWN' }}</span>
            </dd>
          </dl>
        </div>
        <div class="col-md-6">
          <dl class="row mb-2">
            <dt class="col-sm-5"><strong>PIC (Pelaku):</strong></dt>
            <dd class="col-sm-7">{{ $pica->Emp_Code ?? '—' }}</dd>
            
            <dt class="col-sm-5"><strong>Konteks:</strong></dt>
            <dd class="col-sm-7">{{ $pica->konteks_kode ?? '—' }}</dd>
            
            <dt class="col-sm-5"><strong>BA Link:</strong></dt>
            <dd class="col-sm-7">{{ $pica->NoBA ?? '—' }}</dd>
          </dl>
        </div>
      </div>

      <hr class="my-4" />

      <!-- Problem Statement -->
      <div class="mb-4">
        <h6 class="fw-bold mb-2">1. Problem Identification</h6>
        <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9; min-height: 80px;">
          {{ $pica->Problem_Note ?? '—' }}
        </div>
      </div>

      <!-- When & Where -->
      <div class="row mb-4">
        <div class="col-md-6">
          <h6 class="fw-bold mb-2">2. When Did It Happen?</h6>
          <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9; min-height: 60px;">
            {{ $pica->Kapan_Terjadi ? \Carbon\Carbon::parse($pica->Kapan_Terjadi)->format('d/m/Y') : '—' }}
          </div>
        </div>
        <div class="col-md-6">
          <h6 class="fw-bold mb-2">3. Where Did It Happen?</h6>
          <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9; min-height: 60px;">
            {{ $pica->Ms_Location ?? '—' }}
          </div>
        </div>
      </div>

      <!-- Additional Info -->
      <div class="row mb-4">
        <div class="col-md-6">
          <h6 class="fw-bold mb-2">Company</h6>
          <div style="border: 1px solid #ddd; padding: 8px; background: #f9f9f9;">
            {{ $pica->Ms_Company ?? '—' }}
          </div>
        </div>
      </div>

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

        <!-- Manager -->
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
        <strong>Instruction:</strong> Print this form, get signatures from Supervisor → HOD → Manager → BOD in sequence. 
        Store the signed copy and upload the scanned image when available.
      </div>

    </div>
  </div>

  <!-- Action Buttons -->
  <div class="row mt-4 mb-5">
    <div class="col-12">
      <button type="button" class="btn btn-primary" onclick="window.print()">
        <i class="bx bx-printer"></i> Print Form
      </button>
      <a href="{{ route('pica-v2.list') }}" class="btn btn-secondary">
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
