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
          {!! nl2br(e($ba->BA_Desc ?? '—')) !!}
        </div>
      </div>

      <!-- Kronologi -->
      @php
        $kronologi = DB::table('tr_ba_kronologi')->where('tr_ba_main_code', $ba->Tr_BA_Main_Code)->orderBy('id')->get();
      @endphp
      @if($kronologi->count() > 0)
      <div class="mb-4">
        <h6 class="fw-bold mb-2">Kronologi Kejadian / Timeline</h6>
        <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9;">
          @foreach($kronologi as $idx => $item)
            <p class="mb-2"><strong>{{ $idx + 1 }}.</strong> {!! nl2br(e($item->kronlogi)) !!}</p>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Findings / Issues (Temuan) -->
      @if(!empty($ba->ba_temuan))
      <div class="mb-4">
        <h6 class="fw-bold mb-2">Temuan / Issues Found</h6>
        <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9;">
          {!! nl2br(e($ba->ba_temuan)) !!}
        </div>
      </div>
      @endif

      <!-- Recommendations (Rekomendasi) -->
      @if(!empty($ba->ba_rekomendasi))
      <div class="mb-4">
        <h6 class="fw-bold mb-2">Rekomendasi / Action Items</h6>
        <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9;">
          {!! nl2br(e($ba->ba_rekomendasi)) !!}
        </div>
      </div>
      @endif

      <!-- Kategori & Opsi -->
      @php
        $categories = DB::table('tr_ba_kategori_d as d')
          ->join('ms_ba_kategori as k', 'd.kategori_id', '=', 'k.id')
          ->leftJoin('ms_ba_kategori_opsi as o', 'd.opsi_id', '=', 'o.id')
          ->where('d.tr_ba_main_code', $ba->Tr_BA_Main_Code)
          ->select('k.nama', 'o.deskripsi')
          ->get();
      @endphp
      @if($categories->count() > 0)
      <div class="mb-4">
        <h6 class="fw-bold mb-2">Kategori & Opsi</h6>
        <div style="border: 1px solid #ddd; padding: 12px; background: #f9f9f9;">
          @foreach($categories->groupBy('nama') as $kategori => $items)
            <p class="mb-2"><strong>• {{ $kategori }}</strong></p>
            @foreach($items as $item)
              @if($item->deskripsi)
                <p class="mb-1" style="margin-left: 20px;">→ {{ $item->deskripsi }}</p>
              @endif
            @endforeach
          @endforeach
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
