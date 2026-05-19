<html>

{{--  @extends('layouts/layoutMaster')  --}}

@section('title', ' Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@endsection


@section('content')

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">

<title>
     Approve Koordinator
</title>
</head>

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<div id="card" class="container">


<center><h2>Approve Koordinator</h2></center>

<body>

        <form  action="/detail_validasi_koord/{{$main_ba_new->Tr_BA_Main_Code }}" method="post" enctype="multipart/form-data">
        @csrf
            <fieldset   class="other" id="myDIV">

    <a class="btn btn-info" href="/home_ba" role="button">Home</a>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Code</label>
                <input type="text" name = "ba_code" value="{{$main_ba_new->Tr_BA_Main_Code }}" id="collapsible-fullname" class="form-control" required readonly/>
            </div>
        </div>
        <br>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Date Input</label>
                <input type="text" value="{{$main_ba_new->created_at->format('d_m-Y') }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
              <label for="">Date Peristiwa</label>
              <input type="text" value="{{$main_ba_new->Date_BA}}" id="collapsible-fullname" class="form-control" readonly/>
          </div>
      </div>
         <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Company</label>
                <input type="text" value="{{$main_ba_new->rec_comcode }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
        </div>
        <br>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Lokasi</label>
                <input type="text" value="{{$main_ba_new->rec_areacode }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Operator *</label>
                <input type="text" value="{{$main_ba_new->rec_areacode }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
        </div>
        <br>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Divisi *</label>
                <input type="text" value="{{$main_ba_new->Ms_Emp_Div }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Kategori *</label>
                <input type="text" value="{{$main_ba_new->Ms_BA_type_Code }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Jenis *</label>
                <input type="text" value="{{$main_ba_new->Ms_Kasus }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Note *</label>
                <input type="text" name = "note" value="{{$main_ba_new->BA_Desc }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
        </div>
       </div>
       <center>
          <h3>
            kronologi
          </h3>
       </center>
       <div style="padding-left:10px; text-align: justify;" id="outputText">
           @if (isset($ba_kronologi->kronlogi))
            {{$ba_kronologi->kronlogi}}
           @endif
       </div>

       <br>
       <center>
        <h3>
            Detail
        </h3>
      </center>
      <br>
       <table class="table table-bordered mt-4" >
        <thead>
            <tr>
              <tr>
                <th >Code Doc.</th>
                <th>Field Salah</th>
                <th>Value Salah</th>
                <th>Field Benar</th>
                <th>Value Benar</th>
            </tr>
            </tr>
        </thead>
        <tbody>
             @foreach($detail as $row)
                <tr>
                  <td>{{$row->code_doc }}</td>
                  <td>{{$row->field_salah }}</td>
                  <td>{{$row->value_salah }}</td>
                  <td>{{$row->field_benar }}</td>
                  <td>{{$row->value_benar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <center>
      <h3>
          Dokumen
      </h3>
    </center>
  <br>
  <table class="table table-bordered mt-4" >
    <thead>
        <tr>
          <tr>
            <th >Dokumen Pendukung</th>
            <th>Dokumen Pendukung</th>
        </tr>
        </tr>
    </thead>
    <tbody>
              <td>
                @if($dok1 == '')
                <img width="100" height="130" src="{{ asset('nophoto.png') }}">
                @else
                <img width="250" height="130" src="{{ asset($dok1->file_path) }}">
                @endif
              </td>
              <td>
                @if($dok2 == '')
                <img width="100" height="130" src="{{ asset('nophoto.png') }}">
                @else
                <img width="250" height="130" src="{{ asset($dok2->file_path2) }}">
                @endif
              </td>
            </tr>
    </tbody>
</table>
<div class="col-md-12">
  <label class="form-label" for="collapsible-fullname">Approve By</label>
  <input type="text" name="username3" value="{{$user->username }}" id="collapsible-fullname" class="form-control" readonly required/>
</div>
<div class="col-md-12">
  <label class="form-label" for="collapsible-fullname">Note</label>
  <input type="text" name="note3" placeholder="Enter Note" id="collapsible-fullname" class="form-control" />
</div>
<br>
<div class="mt-1">
  <!--<button type="submit" class="btn btn-success me-sm-3 me-1">Approve</button>-->
  <!--<button type="reset" class="btn btn-danger me-sm-3 me-1">Deny-></button>-->
  
   <button type="submit" class="btn btn-success me-sm-3 me-1" name="keputusan" value="setuju">Approve</button>
  <button type="submit" class="btn btn-danger me-sm-3 me-1" name="keputusan" value="tidak_setuju">Deny-></button>
</div>
        </div>
        <br>

        <script>
                const fileUploader = document.getElementById('file');
                const feedback = document.getElementById('feedback');

                fileUploader.addEventListener('change', (event) => {
                const file = event.target.files[0];
                console.log('file', file);

                const size = file.size;
                console.log('size', size);
                let msg = '';

                if (size > 1024 * 1024) {
                    msg = `<span style="color:red;">Ukuran maksimal 1MB. kamu telah upload dengan ukuran ${returnFileSize(size)}</span>`;
                } else {
                    msg = `<span style="color:green;">  ${returnFileSize(size)} berhasil di upload. </span>`;
                }
                feedback.innerHTML = msg;
                });

                function returnFileSize(number) {
                if(number < 1024) {
                    return number + 'bytes';
                } else if(number >= 1024 && number < 1048576) {
                    return (number/1024).toFixed(2) + 'KB';
                } else if(number >= 1048576) {
                    return (number/1048576).toFixed(2) + 'MB';
                }
                }
            </script>

        <script>
                        function validasiEkstensi(){
                            var inputFile = document.getElementById('file');
                            var pathFile = inputFile.value;
                            var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
                            if(!ekstensiOk.exec(pathFile)){
                                alert('Silakan upload file dengan ekstensi .jpeg/.jpg/.png');
                                inputFile.value = '';
                                return false;
                            }else{
                                // Preview gambar
                                if (inputFile.files && inputFile.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        document.getElementById('preview').innerHTML = '<img src="'+e.target.result+'" style="height:500px"/>';
                                    };
                                    reader.readAsDataURL(inputFile.files[0]);
                                }
                            }
                        }
                        </script>

                    <script>
                        function validasiEkstensi2(){
                            var inputFile = document.getElementById('file2');
                            var pathFile = inputFile.value;
                            var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
                            if(!ekstensiOk.exec(pathFile)){
                                alert('Silakan upload file dengan ekstensi .jpeg/.jpg/.png');
                                inputFile.value = '';
                                return false;
                            }else{
                                // Preview gambar
                                if (inputFile.files && inputFile.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        document.getElementById('preview').innerHTML = '<img src="'+e.target.result+'" style="height:500px"/>';
                                    };
                                    reader.readAsDataURL(inputFile.files[0]);
                                }
                            }
                        }
                        </script>
        <script>
        function addRow() {
            var template = document.querySelector('#rowTemplate'),
            tbl = document.querySelector('#myTable'),
            td_slNo = template.content.querySelectorAll("tr")[0],
            tr_count = tbl.rows.length;
            td_slNo.textContent = tr_count;
            var clone = document.importNode(template.content, true);
            tbl.appendChild(clone);
        }
        </script>
        <script>
            function addRows() {
                var template = document.querySelector('#rowTemplates'),
                tbl = document.querySelector('#myTables'),
                td_slNo = template.content.querySelectorAll("td")[0],
                tr_count = tbl.rows.length;
                td_slNo.textContent = tr_count;
                var clone = document.importNode(template.content, true);
                tbl.appendChild(clone);
            }
            </script>
            <script>
                function addRowss() {
                    var template = document.querySelector('#rowTemplatess'),
                    tbl = document.querySelector('#myTabless'),
                    td_slNo = template.content.querySelectorAll("td")[0],
                    tr_count = tbl.rows.length;

                    td_slNo.textContent = tr_count;
                    var clone = document.importNode(template.content, true);
                    tbl.appendChild(clone);
                }
                </script>
                <script>
                    function addRowssosmed() {
                        var template = document.querySelector('#rowTemplatesosmed'),
                        tbl = document.querySelector('#myTables_sosmed'),
                        td_slNo = template.content.querySelectorAll("td")[0],
                        tr_count = tbl.rows.length;

                        td_slNo.textContent = tr_count;
                        var clone = document.importNode(template.content, true);
                        tbl.appendChild(clone);
                    }
                    </script>
                    <script>
                        function addRowskeluarga() {
                            var template = document.querySelector('#rowTemplateskeluarga'),
                            tbl = document.querySelector('#myTables_keluarga'),
                            td_slNo = template.content.querySelectorAll("td")[0],
                            tr_count = tbl.rows.length;

                            td_slNo.textContent = tr_count;
                            var clone = document.importNode(template.content, true);
                            tbl.appendChild(clone);
                        }
                        </script>

                    <script>
                        var rupiah = document.getElementById("rupiah");
                        rupiah.addEventListener("keyup", function(e) {
                        // tambahkan 'Rp.' pada saat form di ketik
                        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                        rupiah.value = formatRupiah(this.value, "Rp. ");
                        });

                        /* Fungsi formatRupiah */
                        function formatRupiah(angka, prefix) {
                        var number_string = angka.replace(/[^,\d]/g, "").toString(),
                            split = number_string.split(","),
                            sisa = split[0].length % 3,
                            rupiah = split[0].substr(0, sisa),
                            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                        // tambahkan titik jika yang di input sudah menjadi angka ribuan
                        if (ribuan) {
                            separator = sisa ? "." : "";
                            rupiah += separator + ribuan.join(".");
                        }

                        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
                        }

                    </script>

                    <script>
                      var rupiah2 = document.getElementById("rupiah2");
                      rupiah2.addEventListener("keyup", function(e) {
                      // tambahkan 'Rp.' pada saat form di ketik
                      // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                      rupiah2.value = formatRupiah(this.value, "Rp. ");
                      });

                      /* Fungsi formatRupiah */
                      function formatRupiah(angka, prefix) {
                      var number_string = angka.replace(/[^,\d]/g, "").toString(),
                          split = number_string.split(","),
                          sisa = split[0].length % 3,
                          rupiah2 = split[0].substr(0, sisa),
                          ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                      // tambahkan titik jika yang di input sudah menjadi angka ribuan
                      if (ribuan) {
                          separator = sisa ? "." : "";
                          rupiah2 += separator + ribuan.join(".");
                      }

                      rupiah2 = split[1] != undefined ? rupiah2 + "," + split[1] : rupiah2;
                      return prefix == undefined ? rupiah2 : rupiah2 ? "Rp. " + rupiah2 : "";
                      }

                  </script>

                  <script>
                    var rupiah3 = document.getElementById("rupiah3");
                    rupiah3.addEventListener("keyup", function(e) {
                    // tambahkan 'Rp.' pada saat form di ketik
                    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                    rupiah3.value = formatRupiah(this.value, "Rp. ");
                    });

                    /* Fungsi formatRupiah */
                    function formatRupiah(angka, prefix) {
                    var number_string = angka.replace(/[^,\d]/g, "").toString(),
                        split = number_string.split(","),
                        sisa = split[0].length % 3,
                        rupiah3 = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    // tambahkan titik jika yang di input sudah menjadi angka ribuan
                    if (ribuan) {
                        separator = sisa ? "." : "";
                        rupiah3 += separator + ribuan.join(".");
                    }

                    rupiah3 = split[1] != undefined ? rupiah3 + "," + split[1] : rupiah3;
                    return prefix == undefined ? rupiah3 : rupiah3 ? "Rp. " + rupiah3 : "";
                    }

                </script>

                <script>
                  var rupiah4 = document.getElementById("rupiah4");
                  rupiah4.addEventListener("keyup", function(e) {
                  // tambahkan 'Rp.' pada saat form di ketik
                  // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                  rupiah4.value = formatRupiah(this.value, "Rp. ");
                  });

                  /* Fungsi formatRupiah */
                  function formatRupiah(angka, prefix) {
                  var number_string = angka.replace(/[^,\d]/g, "").toString(),
                      split = number_string.split(","),
                      sisa = split[0].length % 3,
                      rupiah4 = split[0].substr(0, sisa),
                      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                  // tambahkan titik jika yang di input sudah menjadi angka ribuan
                  if (ribuan) {
                      separator = sisa ? "." : "";
                      rupiah4 += separator + ribuan.join(".");
                  }

                  rupiah4 = split[1] != undefined ? rupiah4 + "," + split[1] : rupiah4;
                  return prefix == undefined ? rupiah4 : rupiah4 ? "Rp. " + rupiah4 : "";
                  }

              </script>

                    <script >
                        // Jquery Dependency

                        $("input[data-type='currency']").on({
                            keyup: function() {
                            formatCurrency($(this));
                            },
                            blur: function() {
                            formatCurrency($(this), "blur");
                            }
                        });


                        function formatNumber(n) {
                        // format number 1000000 to 1,234,567
                        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                        }


                        function formatCurrency(input, blur) {
                        // appends $ to value, validates decimal side
                        // and puts cursor back in right position.

                        // get input value
                        var input_val = input.val();

                        // don't validate empty input
                        if (input_val === "") { return; }

                        // original length
                        var original_len = input_val.length;

                        // initial caret position
                        var caret_pos = input.prop("selectionStart");

                        // check for decimal
                        if (input_val.indexOf(".") >= 0) {

                            // get position of first decimal
                            // this prevents multiple decimals from
                            // being entered
                            var decimal_pos = input_val.indexOf(".");

                            // split number by decimal point
                            var left_side = input_val.substring(0, decimal_pos);
                            var right_side = input_val.substring(decimal_pos);

                            // add commas to left side of number
                            left_side = formatNumber(left_side);

                            // validate right side
                            right_side = formatNumber(right_side);

                            // On blur make sure 2 numbers after decimal
                            if (blur === "blur") {
                            right_side += "00";
                            }

                            // Limit decimal to only 2 digits
                            right_side = right_side.substring(0, 2);

                            // join number by .
                            input_val = "Rp" + left_side + "." + right_side;

                        } else {
                            // no decimal entered
                            // add commas to number
                            // remove all non-digits
                            input_val = formatNumber(input_val);
                            input_val = "Rp," + input_val;

                            // final formatting
                            if (blur === "blur") {
                            input_val += ".00";
                            }
                        }

                        // send updated string to input
                        input.val(input_val);

                        // put caret back in the right position
                        var updated_len = input_val.length;
                        caret_pos = updated_len - original_len + caret_pos;
                        input[0].setSelectionRange(caret_pos, caret_pos);
                        }
                    </script>
                    <script>
                        var span = $('<span>').css('display','inline-block')
                        .css('word-break','break-all').appendTo('body').css('visibility','hidden');
                        function initSpan(textarea){
                        span.text(textarea.text())
                            .width(textarea.width())
                            .css('font',textarea.css('font'));
                        }
                        $('textarea').on({
                            input: function(){
                            var text = $(this).val();
                            span.text(text);
                            $(this).height(text ? span.height() : '1.1em');
                            },
                            focus: function(){
                            initSpan($(this));
                            },
                            keypress: function(e){
                                if(e.which == 13) e.preventDefault();
                            }
                        });
                    </script>

                    {{--  <style>
                        h5
                        {
                            color: red;
                        }
                    </style>  --}}


                    <script>
                      function checkMe(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe2(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck2").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck2").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe3(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck3").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck3").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe4(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck4").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck4").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe5(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck5").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck5").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe6(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck6").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck6").style.display = "none";
                      }

                      }
                    </script>

  </body>
</html>


        {{--  @stop  --}}







