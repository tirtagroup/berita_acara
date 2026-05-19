  @section('title', ' Print')

  @section('vendor-style')
  @endsection
  @section('vendor-script')
  @endsection
  @section('page-script')
  <img width="90" height="50" src="{{ asset('upload/logohgs.jpg') }}" style="margin-bottom:-20px;">
  <center><h3>Berita Acara Laka</h3> </center>
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
                          </tr>

                          <tr>
                            <td>Jenis Laka</td><td>: {{   $laka_h->ms_jenis_laka }}</td>
                            <td>Faktor</td><td>: {{   $laka_h->ms_faktor_laka }}</td>
                          </tr>
                          <tr>
                            <td>Klasifikasi</td><td>: {{   $laka_h->ms_klasifikasi_laka }}</td>
                            <td>Dampak</td><td>: {{   $laka_h->ms_dampak_laka }}</td>
                          </tr>

                          <tr>
                            <td>BA Type</td><td>: {{   $main_ba_new->Ms_BA_type_Code }}</td>
                            <td>Location</td><td>: {{   $main_ba_new->rec_areacode }}</td>
                          </tr>
                          <tr>
                            <td>Kategori</td><td>: {{   $main_ba_new->Ms_BA_type_Code }}</td>
                            <td>Type</td><td>: {{   $laka_h->type_laka }}</td>
                          </tr>
                          <tr>
                            <td>Tanggal BA</td><td>: {{   date_format(date_create($main_ba_new->created_at),"d/m/Y") }}  </td>
                            <td>Fatality</td><td>: {{   $laka_h->fatality }}</td>
                          </tr>
                          <tr>
                            <td>SPK</td><td>: {{   $laka_h->spk }} </td>
                            <td >No. Armada&nbsp</td><td>: {{   $laka_h->no_armada }} </td>
                          </tr>
                          <tr>
                            <td>Tgl Kejadian</td><td>: {{   date_format(date_create($laka_h->date_laka),"d/m/Y") }} </td>
                            <td >Jam Keluar</td><td>: {{   $laka_h->jam_keluar }} </td>
                          </tr>
                          <tr>
                            <td>Loc. Kejadian</td><td>: {{   $laka_h->lokasi_kejadian }} </td>
                            <td >Jam Kejadian</td><td>: {{   $laka_h->jam_kejadian }} </td>
                          </tr>
                          <td>Rute</td><td>: {{   $laka_h->rute }} </td>
                          <td >Dispatcher</td><td>: {{   $laka_h->dispatcher }} </td>
                          <tr>
                            <td>Speed</td><td>: {{   $laka_h->speed }} </td>
                            <td >Bengkel Terakhir</td><td>: {{   $laka_h->bengkel_terakhir }} </td>
                          </tr>
                         </tbody>   
                      </table>
                      <br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">{{$ba_kronologi->kronlogi}}</div>
                      {{--  <textarea readonly name="" id="" cols="100" rows="5">{{$ba_kronologi->kronlogi}}</textarea>  --}}
                      <br>
                      <br>
            <table class="table table-bordered mt-4" style="width: 100%;" >
                <thead>
                    <tr>
                        <th style="width: 5%;"> No. </th>
                        <th style="width: 10%;">Jabatan</th>
                        <th style="width: 15%;">Nama</th>
                        <th style="width: 5%;">Usia</th>
                        <th style="width: 15%;">Penguji</th>
                        <th style="width: 10%;">Avg. Income</th>
                        <th style="width: 10%;">Istirahat Last</th>
                    </tr>
                </thead>
                <tbody>
                      <?php $no=1;?>
                    @foreach($laka_d as $row)
                        <tr>
                          <td>{{ $no }}</td>
                          <td>{{$row->posisi }}</td>
                          <td>{{$row->nama }}</td>
                          <td>{{$row->usia }}</td>
                          <td>{{$row->penguji }}</td>
                          <td>Rp.{{$row->avg_income }}</td>
                          <td>{{$row->istirahat_last }}</td>
                        </tr>
                        <?php $no++ ;?>
                    @endforeach
                </tbody>
            </table>
            <br>
            <br>
           <table>
            <tr>
                  <td>
                    <th></th>
                    <th></th>
                    <th></th>
                  </td>
            </tr>
          </table>
          <br>
          <table>
            <tr>
                  <td>
                    <th></th>
                    <th></th>
                    <th></th>
                  </td>
            </tr>
          </table>
          <br>
          <br>
          <br>
          <table>
            <tr>
                  <th>
                    <td >Operator</td>
                    {{--  <td><u>Liana T. A.</u></td>
                    <td><u>Robby A/ Dwi Arif</u></th>
                    <td><u>Tri Hartati</u></th>
                    <td><u>Cliff Rogers M.</u></th>
                    <td><u>Charless W.</u>  --}}
                    </th>
                  </td>
            </tr>
          </table>
          <table>
            <tr>
                  <th>
                    <td>{{   $main_ba_new->User_Code }}</td>
                    {{--  <td>Jr. Manager ITGeneral MgrMgr. Finance  General MgrBOD</td>  --}}
                  </th>
            </tr>
          </table>
          <br>
          <br>
          <table>
            <th>
              <p>Print Date : <span>{{ $datetime }}</span></p> 
            </th>
          </table>

    </div>

