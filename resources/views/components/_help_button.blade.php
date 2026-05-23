{{--
  Reusable help button — link ke /help/{slug} di tab baru.

  Usage:
    @include('components._help_button', ['slug' => 'ba-create'])
    @include('components._help_button', ['slug' => 'pica-meeting', 'label' => 'Panduan'])
    @include('components._help_button', ['slug' => 'ba-edit', 'iconOnly' => true])

  Variables:
    - $slug (required): kode doc di ms_doc_workflow
    - $label (optional): teks tombol, default "Bantuan"
    - $iconOnly (optional, default false): tampil hanya icon (circular)
--}}
@php
  $iconOnly = $iconOnly ?? false;
  $label    = $label ?? 'Bantuan';
@endphp

@if ($iconOnly)
  <a href="{{ route('help.show', ['kode' => $slug]) }}" target="_blank"
     class="btn btn-sm btn-icon btn-outline-info rounded-circle"
     title="Bantuan: lihat tutorial">
    <i class="bx bx-help-circle"></i>
  </a>
@else
  <a href="{{ route('help.show', ['kode' => $slug]) }}" target="_blank"
     class="btn btn-sm btn-outline-info"
     title="Bantuan: lihat tutorial">
    <i class="bx bx-help-circle"></i> {{ $label }}
  </a>
@endif
