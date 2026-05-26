{{--
  Berita Acara V2 — Print template (standalone, mPDF-friendly).
  Compact layout, single A4 page bila konten ringkas.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>BA {{ $ba->Tr_BA_Main_Code ?? '' }}</title>
<style>
  * { box-sizing: border-box; }
  body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #000; margin: 0; }
  h1 { font-size: 14px; margin: 0 0 2px; text-align: center; }
  h2 { font-size: 10px; margin: 0 0 8px; text-align: center; color: #555; font-weight: normal; }
  .meta { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
  .meta td { padding: 2px 4px; vertical-align: top; font-size: 10px; }
  .meta td.lbl { width: 80px; color: #444; font-weight: bold; }
  .sect { margin-top: 6px; }
  .sect h3 { font-size: 10px; margin: 0 0 2px; padding: 2px 4px; background: #eee; border-left: 3px solid #555; }
  .sect .box { border: 1px solid #bbb; padding: 4px 6px; min-height: 18px; font-size: 10px; }
  .sigs { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; }
  .sigs th, .sigs td { border: 1px solid #999; padding: 4px 6px; vertical-align: middle; }
  .sigs th { background: #eee; text-align: left; }
  .sigs td.pic { width: 50%; }
  .small { font-size: 8.5px; color: #555; margin-top: 6px; }
  hr { border: 0; border-top: 1px solid #999; margin: 4px 0; }
</style>
</head>
<body>

<h1>BERITA ACARA (BA)</h1>

<table class="meta">
  <tr>
    <td class="lbl">BA Code</td>
    <td>: {{ $ba->Tr_BA_Main_Code ?? '—' }}</td>
    <td class="lbl">Creator</td>
    <td>: {{ $ba->emp_name ?? ($ba->Ms_Emp_Code ?? '—') }}</td>
  </tr>
  <tr>
    <td class="lbl">Date</td>
    <td>: {{ !empty($ba->Date_BA) ? \Carbon\Carbon::parse($ba->Date_BA)->format('d/m/Y') : '—' }}</td>
    <td class="lbl">Company</td>
    <td>: {{ $ba->company_name ?? ($ba->rec_comcode ?? '—') }}</td>
  </tr>
  <tr>
    <td class="lbl">Type</td>
    <td>: {{ $ba->Ms_BA_type_Code ?? '—' }}</td>
    <td class="lbl">Location</td>
    <td>: {{ $ba->lokasi_name ?? ($ba->rec_areacode ?? '—') }}</td>
  </tr>
</table>

<div class="sect">
  <h3>Incident Description</h3>
  <div class="box">{!! nl2br(e($ba->BA_Desc ?? '—')) !!}</div>
</div>

@if($kronologi->count() > 0)
<div class="sect">
  <h3>Kronologi / Timeline</h3>
  <div class="box">
    @foreach($kronologi as $idx => $item)
      <div>{{ $idx + 1 }}. {!! nl2br(e($item->kronlogi)) !!}</div>
    @endforeach
  </div>
</div>
@endif

@if(!empty($ba->ba_temuan))
<div class="sect">
  <h3>Temuan / Issues</h3>
  <div class="box">{!! nl2br(e($ba->ba_temuan)) !!}</div>
</div>
@endif

@if(!empty($ba->ba_rekomendasi))
<div class="sect">
  <h3>Rekomendasi / Action Items</h3>
  <div class="box">{!! nl2br(e($ba->ba_rekomendasi)) !!}</div>
</div>
@endif

@if($categories->count() > 0)
<div class="sect">
  <h3>Kategori &amp; Opsi</h3>
  <div class="box">
    @foreach($categories->groupBy('nama') as $kategori => $items)
      <div><b>• {{ $kategori }}</b>
        @foreach($items as $item)
          @if($item->deskripsi)
            <span> &nbsp;→ {{ $item->deskripsi }}</span>
          @endif
        @endforeach
      </div>
    @endforeach
  </div>
</div>
@endif

<table class="sigs">
  <thead>
    <tr>
      <th>PIC</th>
      <th>Divisi</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="pic">{{ $ba->emp_name ?? ($ba->Ms_Emp_Code ?? '—') }} <span style="color:#666">(Pelaku)</span></td>
      <td>{{ $ba->pelaku_divisi ?? '—' }}</td>
    </tr>
    <tr>
      <td class="pic">{{ $ba->pelapor_name ?? ($ba->Ms_Pelapor_Code ?? '—') }} <span style="color:#666">(Pelapor)</span></td>
      <td>{{ $ba->pelapor_divisi ?? '—' }}</td>
    </tr>
    <tr>
      <td class="pic">Tri Hartati</td>
      <td>Manager Finance</td>
    </tr>
    <tr>
      <td class="pic">Dwi Arief W / Yesy Tjandra</td>
      <td>Manager Operasional</td>
    </tr>
    <tr>
      <td class="pic">Cliff Rogers</td>
      <td>General Manager</td>
    </tr>
    <tr>
      <td class="pic">Diana L / Charles W</td>
      <td>BOD</td>
    </tr>
  </tbody>
</table>

</body>
</html>
