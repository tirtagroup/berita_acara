@extends('layouts/layoutMaster')

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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Form Asassment Basic</h4>


  @if (session('success'))
  <div class="alert alert-primary">
    {{ session('success') }}
  </div>
  @endif

<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
  <title>
    Basic Hrd
  </title>
</head>

<div class="row">
  <div class="col">
    <div class="nav-align-top mb-3">
      <ul class="nav nav-tabs" role="tablist">
      </ul>
      <div class="card">
       
        @php
        $test = 0;
            foreach($tr_emp_assesment as $row){
                $test++;
            }
        @endphp


          <div class="row g-3 p-3">
            @foreach($tr_emp_assesment as $row)
                    @if($row->Ms_record_asses == "Supervisor")
            
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Code</label>
                    <input type="text" name="Tr_Emp_Asses_Code" id="collapsible-fullname" class="form-control" value="{{ $row->Tr_Emp_Asses_Code }}" readonly />
                </div>
                @php
                  $code_emp_spv = $row->Tr_Emp_Asses_Code;
                  
                @endphp
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Date</label>
                  <input class="form-control"  type="date" name="Ass_date" value="@php $dateconv = strtotime($row->Date_Asses); echo date('Y-m-d', $dateconv);  @endphp" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Assesor</label>
                    <input type="hidden" name="Ms_Emp_Assessor_Code" id="collapsible-fullname" class="form-control" value="{{ $row->name }}" readonly required/>
                    <input type="text" class="form-control" value="{{ $row->name  }}" readonly/>
                  </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Divisi Assesor</label>
                    <input type="hidden" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $row->Ms_Emp_Div  }}" readonly required/>
                    <input type="text" class="form-control" value="{{ $row->ms_divisi  }}" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Nama Staff</label>
                    {{-- <select class="js-states form-control" id="single" name="Ms_Emp_Code" >
                        @foreach ($employee as $staff)
                        <option value="{{$staff->emp_name}}">
                            {{$staff->emp_name}}</option>
                        @endforeach
                    </select> --}}
                    <input type="hidden" name="Ms_Emp_Code" id="collapsible-fullname" class="form-control" value="{{ $row->Ms_Emp_Code  }}"    readonly/>
                    <input type="text" class="form-control" value="{{ $row->emp_name  }}" readonly/>
                  </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Divisi Staff</label>
                    <input type="text" name="Ms_Emp_Div" id="collapsible-fullname" class="form-control" value="{{ $row->Ms_Emp_Div  }}"    readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Ms Type Assasment</label>
                    <input type="text" name="Ms_type_asses"  class="form-control" value="{{ $row->Ms_type_asses  }}" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Jabatan</label>
                    <input type="text" name="Ms_record_asses" class="form-control" value="{{ $row->Ms_record_asses  }}" readonly/>
                </div>    
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Last Assesor</label>
                    <input type="text" name="" class="form-control" value="{{ $row->name  }}" readonly/>
                </div> 
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Total BA</label>
                    <input type="text" name="" class="form-control" value="{{ $totalBa  }}" readonly/>
                </div> 
               @endif  
               
                @php
                  $data_Ms_Emp_Code = $row->Ms_Emp_Code;
                  $data_Ms_Emp_Div = $row->Ms_Emp_Div;
                  $Tr_Emp_Asses_Code = $row->Tr_Emp_Asses_Code;
                @endphp

            @endforeach 
        </div>
    <div class="p-3">
      <br>
      <br><center><h2>Rating Supervisor</h2></center>

@foreach($tr_emp_assesment as $row)
    @if($row->Ms_record_asses == "Supervisor")
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Trust</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($row->Trust_value == $i){ echo "checked";}else{ echo "disabled='disabled'";} ?> />
              
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" value="{{ $row->trust_comment }}" readonly>             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Drive</label>
          <div class="col-sm-5">         
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="drive" <?php if($row->drive_value == $i){ echo "checked";}else{ echo "disabled='disabled'";}  ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="drive_comment" value="{{ $row->drive_comment }}" readonly>             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Inisiative</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="inisiative" <?php if($row->inisiative_value == $i){ echo "checked";}else{ echo "disabled='disabled'";}  ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="inisiatif_comment" value="{{ $row->inisiatif_comment }}" readonly>             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Reliable</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="Reliable" <?php if($row->Reliable_value == $i){ echo "checked";}else{ echo "disabled='disabled'";}  ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="reliable_comment" value="{{ $row->reliable_comment }}" readonly>             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Result</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="resluts" <?php if($row->reslut == $i){ echo "checked";}else{ echo "disabled='disabled'";}  ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="result_comment" value="{{ $row->result_comment }}" readonly>             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Total Nilai</label>
          <div class="col-sm-5">
            <span  style="margin-left: .5rem;">{{ $row->Trust_value+$row->drive_value+$row->inisiative_value+$row->Reliable_value+$row->reslut }}</span>
          </div>
          <div class="col-sm-5">         
          </div>             
        </div>
      </div>
    @endif
      @endforeach    
    </div>



<br>



    </div>



    <br>
    <div class="accordion" id="collapsibleSection">
      <div class="card accordion-item">
        <div>
    
        <div>
                <div class="content je">
                  <div class="pure-g ">
                    <div class="pure-u-1-24 ">
                    </div>
                    <div class="pure-u-11-12">
                <div class="">
                  <div class="pure-g">
                    <div class="pure-u-1-2">
    
            <div class="container">
    
            <!--    <div class="col-md-12">-->
            <!--    <label class="form-label" for="collapsible-fullname">Target</label>-->
            <!--    <input type="text" name="note_asses" placeholder="Enter Note" id="collapsible-fullname" class="form-control" />-->
            <!--  </div>-->
            <!--</div>  -->
    <br>
                <label class="form-label" for="collapsible-fullname">Target</label>
            <div >
                @foreach($tr_emp_asses_note as $row)
                <input name="dynamic_input[]" class="form-control" type="text" value ="{{ $row->note }}" readonly />
                @endforeach 
              <!-- Existing input element goes here -->
              <div class="input-row">
              </div>
            </div>

                <div class="col-md-6">
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
            <div class="accordion-body">
                    <div class="content je">
                      <div class="pure-g ">
                        <div class="pure-u-1-24 ">
                        </div>
                        <div class="pure-u-11-12">
                    <div class="">
                      <div class="pure-g">
                        <div class="pure-u-1-2">
                          <br>
    
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <!-- </div>
          </div>
        </div>	 -->

    
    
    
       </div>
    </div>
    <br>

    @if ($test > 1)

    <form action="/asasmen_basics_update" method="POST" enctype="multipart/form-data">
        @csrf
        
      <div class="card">
       
          <div class="row g-3 p-3">
            @foreach($tr_emp_assesment as $row)
            @if($row->Ms_record_asses == "HRD")
                <input type="hidden" name="Tr_Emp_Asses_Code" id="collapsible-fullname" class="form-control" value="{{ $row->Tr_Emp_Asses_Code }}" readonly />
                <input type="hidden" name="Ass_date" value="{{$row->Date_Asses}}" class="form-control" readonly/>
                <input type="hidden" name="Ms_Emp_Assessor_Code" id="collapsible-fullname" class="form-control" value="{{ $row->Ms_Emp_Assessor_Code  }}" readonly/>
                <input type="hidden" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $row->Ms_Emp_Div  }}" readonly/>
                <input type="hidden" name="Ms_Emp_Code" id="collapsible-fullname" class="form-control" value="{{ $row->Ms_Emp_Code  }}" readonly/>
                <input type="hidden" name="Ms_Emp_Div" id="collapsible-fullname" class="form-control" value="{{ $row->Ms_Emp_Div  }}" readonly/>
                <input type="hidden" name="Ms_type_asses" id="collapsible-fullname" class="form-control" value="{{ $row->Ms_type_asses  }}" readonly/>
                <input type="hidden" name="Ms_record_asses" id="collapsible-fullname" class="form-control" value="{{ $row->Ms_record_asses  }}" readonly/>
            @endif
            @endforeach        
        </div>
    <div class="p-3">
      <br>
      <br><center><h2>Rating Hrd</h2></center>

@foreach($tr_emp_assesment as $row)
    @if($row->Ms_record_asses == "HRD")


    {{ $row->Ms_record_asses  }}
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Trust</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="trust_value_{{ $i }}" name="trust_value" value="{{ $i }}"  data-type="trust" onclick="updateTotal()" <?php if($row->Trust_value == $i){ echo "checked";} ?> />
              
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="trust_comment" value="{{ $row->trust_comment }}">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Drive</label>
          <div class="col-sm-5">         
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="drive_value_{{ $i }}" name="drive_value" value="{{ $i }}"  data-type="drive" onclick="updateTotal()" <?php if($row->drive_value == $i){ echo "checked";} ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="drive_comment" value="{{ $row->drive_comment }}">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Inisiative</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="inisiative_value_{{ $i }}" name="inisiative_value" value="{{ $i }}"  data-type="inisiative" onclick="updateTotal()" <?php if($row->inisiative_value == $i){ echo "checked";} ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="inisiatif_comment" value="{{ $row->inisiatif_comment }}">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Reliable</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="Reliable_value_{{ $i }}" name="Reliable_value" value="{{ $i }}"  data-type="Reliable" onclick="updateTotal()" <?php if($row->Reliable_value == $i){ echo "checked";} ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="reliable_comment" value="{{ $row->reliable_comment }}">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Result</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="result_{{ $i }}" name="result" value="{{ $i }}"  data-type="resluts" onclick="updateTotal()" <?php if($row->reslut == $i){ echo "checked";} ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="result_comment" value="{{ $row->result_comment }}">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Total Nilai</label>
          <div class="col-sm-5">
            <span id="total-score" style="margin-left: .5rem;">0</span>
          </div>
          <div class="col-sm-5">         
          </div>             
        </div>
      </div>
      @endif
      @endforeach    
    </div>



<br>



    </div>
    <br>
    <div class="accordion" id="collapsibleSection">
      <div class="card accordion-item">
        <h2 class="accordion-header" id="headingDeliveryOptions">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryOptions" aria-expanded="false" aria-controls="collapseDeliveryOptions">Isi Pesan Disini</button>
        </h2>
        <div id="collapseDeliveryOptions" class="accordion-collapse collapse" aria-labelledby="headingDeliveryOptions" data-bs-parent="#collapsibleSection">
    
        <div class="accordion-body">
                <div class="content je">
                  <div class="pure-g ">
                    <div class="pure-u-1-24 ">
                    </div>
                    <div class="pure-u-11-12">
                <div class="">
                  <div class="pure-g">
                    <div class="pure-u-1-2">
    
            <div class="container">
    
              {{--  <div class="col-md-12">
                <label class="form-label" for="collapsible-fullname">Note</label>
                <input type="text" name="note_asses" placeholder="Enter Note" id="collapsible-fullname" class="form-control" />
              </div>
            </div>  --}}
    
    
            <div id="dynamic-container">

                @foreach($tr_emp_asses_note_hrd as $row)
                <input name="dynamic_input[]" class="form-control" type="text" value ="{{ $row->note }}"/>
                @endforeach 
              <!-- Existing input element goes here -->
              <div class="input-row">
              </div>
            </div>
            {{--  <button type="button" onclick="addRow()">Add Input</button>  --}}
            <button type="button" onclick="addRow()" style="color: green;" class="add-icon">
              <i class="fas fa-plus"></i>
            </button>
                <div class="col-md-6">
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
       
            <div class="accordion-body">
                    <div class="content je">
                      <div class="pure-g ">
                        <div class="pure-u-1-24 ">
                        </div>
                        <div class="pure-u-11-12">
                    <div class="">
                      <div class="pure-g">
                        <div class="pure-u-1-2">
                          <br>
    
    
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <!-- </div>
          </div>
        </div>	 -->
          <div class="mt-1">
    
            <!--<a href="/print_asasmen/"class="btn btn-primary me-sm-3 me-1">Submit</a>-->
            <input type="submit" value="Update" class="btn btn-primary me-sm-3 me-1">
            <button type="reset" class="btn btn-label-secondary">Cancel</button>
      
          </div>
    
    
    
       </div>
    </div>
    </form> 


@else

    
<form action="/asasmen/asasmen_save_basics_hrd" method="POST" enctype="multipart/form-data">
    @csrf    

  <div class="card">
   
      <div class="row g-3 p-3">
                <input type="hidden" name="Tr_Emp_Asses_Code_spv" id="collapsible-fullname" class="form-control" value="{{ $code_emp_spv }}" />
                <input type="hidden" name="Tr_Emp_Asses_Code" id="collapsible-fullname" class="form-control" value="{{ $Tr_Emp_Asses_Code }}" />
                
                <input type="hidden" name="Ms_Emp_Assessor_Code" class="form-control" value="{{ $user->name }}"/>
                <input type="hidden" name="Ms_Emp_Code" class="form-control" value="{{  $data_Ms_Emp_Code }}"/>
                <input class="form-control"  type="hidden" name="Ass_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly/>
                <input type="hidden" name="" id="collapsible-fullname" class="form-control" value="{{ $user->username  }}" />
                <input type="hidden" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $user->ms_divisi  }}" />
                <input type="hidden" name="Ms_Emp_Div" id="collapsible-fullname" class="form-control" value="{{ $data_Ms_Emp_Div }}" />
                <input type="hidden" name="Ms_type_asses" id="collapsible-fullname" class="form-control" value="Basic 2" />
                <input type="hidden" name="Ms_record_asses" id="collapsible-fullname" class="form-control" value="HRD" />
    </div>






<div class="p-3">
  <br>
  <br><center><h2>Rating Create Hrd</h2></center>


  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Trust</label>
      <div class="col-sm-5">
        @for($i = 1; $i <= 5; $i++)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="trust_value_{{ $i }}" name="trust_value" value="{{ $i }}"  data-type="trust" onclick="updateTotal()">
          <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
        </div>
        @endfor
      </div>
      <div class="col-sm-5">
        <input type="text" class="form-control" placeholder="Enter Comment" name="trust_comment">             
      </div>             
    </div>
  </div>
  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Drive</label>
      <div class="col-sm-5">         
        @for($i = 1; $i <= 5; $i++)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="drive_value_{{ $i }}" name="drive_value" value="{{ $i }}"  data-type="drive" onclick="updateTotal()">
          <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
        </div>
        @endfor
      </div>
      <div class="col-sm-5">
        <input type="text" class="form-control" placeholder="Enter Comment" name="drive_comment">             
      </div>             
    </div>
  </div>
  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Inisiative</label>
      <div class="col-sm-5">
        @for($i = 1; $i <= 5; $i++)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="inisiative_value_{{ $i }}" name="inisiative_value" value="{{ $i }}"  data-type="inisiative" onclick="updateTotal()">
          <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
        </div>
        @endfor
      </div>
      <div class="col-sm-5">
        <input type="text" class="form-control" placeholder="Enter Comment" name="inisiatif_comment">             
      </div>             
    </div>
  </div>
  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Reliable</label>
      <div class="col-sm-5">
        @for($i = 1; $i <= 5; $i++)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="Reliable_value_{{ $i }}" name="Reliable_value" value="{{ $i }}"  data-type="Reliable" onclick="updateTotal()">
          <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
        </div>
        @endfor
      </div>
      <div class="col-sm-5">
        <input type="text" class="form-control" placeholder="Enter Comment" name="reliable_comment">             
      </div>             
    </div>
  </div>
  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Result</label>
      <div class="col-sm-5">
        @for($i = 1; $i <= 5; $i++)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="result_{{ $i }}" name="result" value="{{ $i }}"  data-type="resluts" onclick="updateTotal()">
          <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
        </div>
        @endfor
      </div>
      <div class="col-sm-5">
        <input type="text" class="form-control" placeholder="Enter Comment" name="result_comment">             
      </div>             
    </div>
  </div>
  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Total Nilai</label>
      <div class="col-sm-5">
        <span id="total-score" style="margin-left: .5rem;">0</span>
      </div>
      <div class="col-sm-5">         
      </div>             
    </div>
  </div>
</div>



<br>



</div>
<br>
<div class="accordion" id="collapsibleSection">
  <div class="card accordion-item">
    <h2 class="accordion-header" id="headingDeliveryOptions">
      <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryOptions" aria-expanded="false" aria-controls="collapseDeliveryOptions">Isi Pesan Disini</button>
    </h2>
    <div id="collapseDeliveryOptions" class="accordion-collapse collapse" aria-labelledby="headingDeliveryOptions" data-bs-parent="#collapsibleSection">

    <div class="accordion-body">
            <div class="content je">
              <div class="pure-g ">
                <div class="pure-u-1-24 ">
                </div>
                <div class="pure-u-11-12">
            <div class="">
              <div class="pure-g">
                <div class="pure-u-1-2">

        <div class="container">

          {{--  <div class="col-md-12">
            <label class="form-label" for="collapsible-fullname">Note</label>
            <input type="text" name="note_asses" placeholder="Enter Note" id="collapsible-fullname" class="form-control" />
          </div>
        </div>  --}}


        <div id="dynamic-container">
          <!-- Existing input element goes here -->
          <div class="input-row">
          </div>
        </div>
        {{--  <button type="button" onclick="addRow()">Add Input</button>  --}}
        <button type="button" onclick="addRow()" style="color: green;" class="add-icon">
          <i class="fas fa-plus"></i>
        </button>
            <div class="col-md-6">
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
   
        <div class="accordion-body">
                <div class="content je">
                  <div class="pure-g ">
                    <div class="pure-u-1-24 ">
                    </div>
                    <div class="pure-u-11-12">
                <div class="">
                  <div class="pure-g">
                    <div class="pure-u-1-2">
                      <br>


                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- </div>
      </div>
    </div>	 -->
      <div class="mt-1">

        <!--<a href="/print_asasmen/"class="btn btn-primary me-sm-3 me-1">Submit</a>-->
        <input type="submit" value="Submit" class="btn btn-primary me-sm-3 me-1">
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
  
      </div>



   </div>
</div>
</form>  

@endif


  </div>  
</div> 
</div> 

      <style>

            .je tr.button-row, .je tr.button-row button {
              background: #1f8dd6;
              color:white;
              font-size:100%;
            }

            .je .button-td {
              text-align: center;
              border: solid;
              border-width: 1px;
              border-color: gray;
            }

            .je table thead {
              /* border-bottom: solid; */
              /* border-width: 1px; */
              /* border-color: #909090; */
            }

            .new-row-btn,.new-row-btn:hover {
              width:900px;
              border:none;
              background:none;
              font-weight:bold;
            }
            .option-font
            {
                font-size: 16px;
            }
            .add-icon, .remove-icon {
              cursor: pointer;
              margin-left: 5px;
              padding: 0;
              background: none;
              border: none;
            }

      </style>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <!-- Select2 -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
      <script>
        $("#single").select2({
            placeholder: "Select Employee",
            allowClear: true
        });
        $("#multiple").select2({
            placeholder: "Select Employee",
            allowClear: true
        });




        $(document).ready(function () {

$("#repeatDivBtn").click(function () {

  $newid = $(this).data("increment");
  $repeatDiv = $("#repeatDiv").wrap('<div/>').parent().html();
  $('#repeatDiv').unwrap();
  $($repeatDiv).insertAfter($(".repeatDiv").last());
  $(".repeatDiv").last().attr('id',   "repeatDiv" + '_' + $newid);
  $("#repeatDiv" + '_' + $newid).append('<div class="input-group-append"><button type="button" class="btn btn-danger removeDivBtn" data-id="repeatDiv'+'_'+ $newid+'">Remove</button></div>');
  $newid++;
  $(this).data("increment", $newid);

});


$(document).on('click', '.removeDivBtn', function () {

  $divId = $(this).data("id");
  $("#"+$divId).remove();
  $inc = $("#repeatDivBtn").data("increment");
  $("#repeatDivBtn").data("increment", $inc-1);

});

});



















      </script>

      <script>
       // Fungsi untuk mengupdate total nilai
      function updateTotal() {
        // Inisialisasi total nilai
        let totalValue = 0;

        // Mendapatkan nilai terpilih untuk masing-masing grup
        const trustValue = parseInt($('input[name="trust_value"]:checked').val()) || 0;
        const driveValue = parseInt($('input[name="drive_value"]:checked').val()) || 0;
        const inisiatValue = parseInt($('input[name="inisiative_value"]:checked').val()) || 0;
        const reliableValue = parseInt($('input[name="Reliable_value"]:checked').val()) || 0;
        const resultValue = parseInt($('input[name="result"]:checked').val()) || 0;

        // Menghitung total nilai
        totalValue = trustValue + driveValue + inisiatValue + reliableValue + resultValue;

        // Menampilkan total nilai
        $('#total-score').text(totalValue);

        // Menetapkan warna total berdasarkan kondisi
        if (totalValue > 10) {
          $('#total-score').css('color', 'red');
        } else {
          $('#total-score').css('color', 'red'); // atau warna lain sesuai kebutuhan
        }
      }
    </script>

    <script>
      function addRow() {
        var container = document.getElementById("dynamic-container");
        var newRow = document.createElement("div");
        newRow.className = "input-row";
        newRow.innerHTML =
          '<span class="remove-icon" onclick="removeRow(this)"> <i class="fas fa-trash-alt" style="color: red;"></i></span>' +
          '<input name="dynamic_input[]" class="form-control" type="text"/>';
        container.appendChild(newRow);
      }

      function removeRow(button) {
        var row = button.parentNode;
        row.parentNode.removeChild(row);
      }
    </script>




@endsection
