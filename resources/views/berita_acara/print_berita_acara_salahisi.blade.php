@section('title', ' Print')

@section('vendor-style')
@endsection
@section('vendor-script')
@endsection
@section('page-script')
<img width="90" height="50" src="{{ asset('upload/logohgs.jpg') }}" style="margin-bottom:-20px;">
<center><h3>Berita Acara Kejadian</h3> </center>
<hr/>
<br>
  <table style="width: 100%;">
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
      <td>Code</td><td>: {{   $main_ba_new->Tr_BA_Main_Code }} </td>
      <td>Perusahaan</td><td>: {{   $main_ba_new->rec_comcode }}</td>
      {{--  <td>Operator   </td><td>: {{   $main_ba_new->Ms_Emp_Code }} </td>  --}}
    </tr>
    <tr>
      <td>Kategori</td><td>: {{   $main_ba_new->Ms_BA_type_Code }}</td>
      <td>Kasus</td><td>: {{   $main_ba_new->Ms_Kasus }}</td>
    </tr>
    <tr>
      <td>Tanggal BA</td><td>: {{   date_format(date_create($main_ba_new->created_at),"d/m/Y") }} </td>
      <td>Tanggal Peristiwa</td><td>: {{   date_format(date_create($main_ba_new->Date_BA),"d/m/Y") }} </td>
    </tr>
    <tr>
      <td>User Input</td><td>: {{   $main_ba_new->Ms_Pelapor_Code }} </td>
      <td>Divisi yang Input</td><td>: {{   $main_ba_new->Ms_Pelapor_Div }} </td>
    </tr>
    <tr>
      <td>Pelaku</td><td>: {{   $main_ba_new->Ms_Emp_Code }} </td>
      <td>Divisi Pelaku : {{   $main_ba_new->Ms_Emp_Div }} </td>
    </tr>
    <tr>
      <td>Lokasi</td><td>: {{   $main_ba_new->rec_areacode }}</td>
      <td >Detail Kasus</td><td>: {{   $main_ba_new->MS_Detail_Kasus }}</td>
    </tr>  
    <tr>
      <td><strong>Fraud ?</strong></td><td>: 
        @if($main_ba_new->CekFraud == '1')
        Iya
        @else
        Tidak
        @endif 
      </td>
      <td></td><td></td>
    </tr>
    </tbody>
</table>
<br>
                      <h4>Kronologi:</h4>
                      <!--<textarea readonly name="" id="" cols="100" rows="5"></textarea>-->
                      <divid="outputText">
                        @if(isset($ba_kronologi->kronlogi))  
                        {{$ba_kronologi->kronlogi}}  
                        @endif  
                      </div>


          <table>
            <tr>
                  <!--<th>-->
                  <!--  <td>{{   $main_ba_new->Ms_Pelapor_Div }}</td>-->
                  <!--  <td>Jr. Manager ITGeneral MgrMgr. Finance  General MgrBOD</td>-->
                  <!--</th>-->
            </tr>
          </table>
          <br>

                      <center>
                        <h3>
                           Dokumen
                         </h3>
                       </center>

                       <table class="table table-bordered mt-4" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                  <td>
                                    @if($dok1 == '')
                                    
                                    @else
                                    <img width="250" height="130" src="{{ asset($dok1->file_path) }}">
                                    @endif
                                  </td>
                                  <td>
                                    @if($dok2 == '')
                                    
                                    @else
                                    <img width="250" height="130" src="{{ asset($dok2->file_path2) }}">
                                    @endif
                                  </td>
                            </tr>      
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-bordered mt-4" style="width: 100%;">
                      <thead>
                          <tr>
                              <th style="width: 5%;"> No. </th>
                              <th style="width: 30%;">PIC</th>
                              <th style="width: 30%;">Divisi</th>
                              <th style="width: 20%;"></th>
                          </tr>
                      </thead>
                      <tbody>
                              <tr>
                                <td>&nbsp; &nbsp; 1</td>
                                <td>{{   $main_ba_new->Ms_Emp_Code }}</td>
                                <td>{{   $main_ba_new->Ms_Emp_Div }}</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 2</td>
                                <td>{{   $main_ba_new->Ms_Pelapor_Code }}</td>
                                <td>{{   $main_ba_new->Ms_Pelapor_Div }}</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 3</td>
                                <td>Tri Hartati</td>
                                <td>Manager Finance</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 4</td>
                                <td>Dwi Arif W</td>
                                <td>Manager Operasional</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 5</td>
                                <td>Cliff Rogers </td>
                                <td>General Manager</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 6</td>
                                <td>Liana Tresna A </td>
                                <td>IT</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 7</td>
                                <td>Charles W </td>
                                <td>BOD</td>
                                <td>.......</td>
                              </tr>
                      </tbody>
                  </table>

                <div class="card-body">
          <br>
          <br>
          <table>
            <th>
              <p>Print Date : <span>{{ $datetime }}</span></p> 
            </th>
          </table>

        </div>
    </div>
