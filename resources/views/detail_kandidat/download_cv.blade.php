@if($cv == '')
    <img width="90" height="120" src="upload/nophoto.jpg">
  @else
    <embed width="90" height="120 " src="{{ asset($cv->file_cv) }}" >
  @endif