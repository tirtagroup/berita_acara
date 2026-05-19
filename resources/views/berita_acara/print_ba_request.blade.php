  @section('title', ' Print')

  @section('vendor-style')
  @endsection
  @section('vendor-script')
  @endsection
  @section('page-script')
  <img width="90" height="50" src="{{ asset('upload/logohgs.jpg') }}" style="margin-bottom:-20px;">
 <center><h3>Request Revisi</h3> </center>
 <hr>
                      <p class="garise"></p>
                        <table  style="width: 100%;">
                          <thead>
                            <tr>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                            </tr>
                          </thead>
                          <tbody>            
                          <tr>
                            <td>Code </td><td>: {{   $main_ba_new->Tr_BA_Main_Code }} </td>
                            <td>Perusahaan </td><td>: {{   $main_ba_new->rec_comcode }}</td>
                            {{--  <td>Operator     : {{   $main_ba_new->Ms_Emp_Code }} </td>  --}}
                          </tr>
                          <tr> 
                            <td>Kategori </td><td>: {{   $main_ba_new->Ms_BA_type_Code }}</td>
                            <td>Jenis </td><td>: {{   $main_ba_new->Ms_Kasus }}</td>
                          </tr>
                          <tr>
                            <td>Tanggal BA </td><td>: {{ date_format(date_create($main_ba_new->created_at),"d/m/Y") }} </td>
                            <td>Tanggal Peristiwa </td><td>: {{ date_format(date_create($main_ba_new->Date_BA),"d/m/Y") }} </td>
                          </tr>
                          <tr>
                            <td>User Input </td><td>: {{   $main_ba_new->Ms_Pelapor_Code }} </td>
                            <td>Divisi </td><td>: {{   $main_ba_new->Ms_Pelapor_Div }} </td>
                          </tr>
                          <tr>
                            <td>Pelaku </td><td>: {{   $main_ba_new->Ms_Emp_Code }} </td>
                            <td>Divisi Pelaku  </td><td>: {{   $main_ba_new->Ms_Emp_Div }} </td>
                          </tr>
                          <tr>
                            <td>Kasus </td><td>: {{   $main_ba_new->MS_Detail_Kasus }}</td>
                            <td>Lokasi </td><td>: {{   $main_ba_new->rec_areacode }}</td>
                          </tr>
                          </tbody>
                      </table>
                      <br>
                      <h4>Kronologi:</h4>
                      {{-- <textarea readonly name="" id="" cols="100" rows="7">{{$ba_kronologi->kronlogi}}</textarea> --}}
                      <divid="outputText">
                        @if(isset($ba_kronologi->kronlogi) )
                          {{$ba_kronologi->kronlogi}}
                        @endif
                      </div>

          <div class="card-body">
            <br>
            <center><h3>Detail Transaksi</h3> </center>
            <table class="table table-bordered mt-4" style="width: 100%;" >
                <thead>
                    <tr>
                        <th style="width: 5%;"> No. </th>
                        <th style="width: 10%;">Code Doc.</th>
                        <th style="width: 10%;">Field Salah</th>
                        <th style="width: 10%;">Value Salah</th>
                        <th style="width: 10%;">Field Benar</th>
                        <th style="width: 10%;">Value Benar</th></tr>
                    </tr>
                </thead>
                <tbody>
                      <?php $no=1;?>
                    @foreach($detail as $row)
                        <tr>
                          <td> &nbsp; &nbsp; &nbsp;{{ $no }}</td>
                          <td>{{$row->code_doc }}</td>
                          <td>{{$row->field_salah }}</td>
                          <td>{{$row->value_salah }}</td>
                          <td>{{$row->field_benar }}</td>
                          <td>{{$row->value_benar }}</td>
                        </tr>
                        <?php $no++ ;?>
                    @endforeach
                </tbody>
            </table>
            <br>
            <br>
            <!--<center><h1>Menyetujui</h1> </center>-->
            <table class="table table-bordered mt-4"  style="width: 100%;">
              <thead>
                  <tr>
                    <tr>
                      <th style="width: 5%;"> No. </th>
                      <th  style="width: 15%;">PIC</th>
                      <th style="width: 15%;">Divisi</th>
                      <th style="width: 40%;">Note</th>
                      <th></th>
                  </tr>
                  </tr>
              </thead>
              <tbody>
                    <?php $no=1;?>
                  @foreach($tracking as $row)
                      <tr>
                        <td> &nbsp; &nbsp;{{ $no }}</td>
                        <td> {{$row->pic }}</td>
                        <td> {{$row->approval_ba_desc }}</td>
                        <td> {{$row->note }}</td>
                        <td>  .....  </td>
                      </tr>
                      <?php $no++ ;?>
                  @endforeach
              </tbody>
          </table>

          <table>

          <br>
          <br>
          <table>
            <th>
              <p>Print Date : <span>{{ $datetime }}</span></p> 
            </th>
          </table>

        </div>
    </div>