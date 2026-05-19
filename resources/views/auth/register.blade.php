<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Register - Pages | Register</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/favicon.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}" />
    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <!-- <span class="app-brand-logo demo">
                    <svg
                      width="25"
                      viewBox="0 0 25 42"
                      version="1.1"
                      xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink"
                    >
                      <defs>
                        <path
                          d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                          id="path-1"
                        ></path>
                        <path
                          d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                          id="path-3"
                        ></path>
                        <path
                          d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                          id="path-4"
                        ></path>
                        <path
                          d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                          id="path-5"
                        ></path>
                      </defs>
                      <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                          <g id="Icon" transform="translate(27.000000, 15.000000)">
                            <g id="Mask" transform="translate(0.000000, 8.000000)">
                              <mask id="mask-2" fill="white">
                                <use xlink:href="#path-1"></use>
                              </mask>
                              <use fill="#696cff" xlink:href="#path-1"></use>
                              <g id="Path-3" mask="url(#mask-2)">
                                <use fill="#696cff" xlink:href="#path-3"></use>
                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                              </g>
                              <g id="Path-4" mask="url(#mask-2)">
                                <use fill="#696cff" xlink:href="#path-4"></use>
                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                              </g>
                            </g>
                            <g
                              id="Triangle"
                              transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "
                            >
                              <use fill="#696cff" xlink:href="#path-5"></use>
                              <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                            </g>
                          </g>
                        </g>
                      </g>
                    </svg>
                  </span> -->
                  <span class="app-brand-text fs-1 text-body fw-bolder">REGISTER</span>
                </a>
              </div>
              <!-- /Logo -->
              {{--  <h4 class="mb-2">FORM REGISTER USER 🚀</h4>  --}}
              {{--  <p class="mb-4">Aplikasi Absensi</p>  --}}
              @if(session('message'))
                <div class="alert alert-success">
                  {{session('message')}}
                </div>
              @endif
              @if(session('error'))
                <div class="alert alert-danger">
                    <b>Opps!</b> {{session('error')}}
                </div>
              @endif
              <form id="formAuthentication" class="mb-3" action="{{route('actionregister')}}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  name="name"
                  placeholder="Enter your name"
                  autofocus
                  required=""
                />
              </div>
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    autofocus
                    required=""
                  />
                </div>
                <div class="mb-3">
                  <label for="username" class="form-label">Ms divisi</label>
                  <select name = 'ms_divisi'class="form-control">
                    <!--<option value="Accounting" style="weight:50px">Accounting</option>-->
                    <!--<option value="GA" style="weight:50px">GA</option>-->
                    <!--<option value="HR" style="weight:50px">HR</option>-->
                    <!--<option value="Finance" style="weight:50px">Finance</option>-->
                    <!--<option value="Cashier" style="weight:50px">Cashier</option>-->
                    <!--<option value="Gudang" style="weight:50px">Gudang</option>-->
                    <!--<option value="Fleet" style="weight:50px">Fleet</option>-->
                    <!--<option value="Operasional" style="weight:50px">Operasional</option>-->
                    <!--<option value="Sales" style="weight:50px">Sales</option>-->
                    <!--<option value="Software" style="weight:50px">Software</option>-->
                    <!--<option value="Security" style="weight:50px">Security</option>-->
                    <!--<option value="Audit" style="weight:50px">Audit</option>-->
                    <!--<option value="Motoris" style="weight:50px">Motoris</option>-->
                     <option value="Approval_External" style="weight:50px">Approval_External</option>
                    <option value="Approval_internal" style="weight:50px">Approval_internal</option>
                    <option value="Account Renable" style="weight:50px">Account Renable</option>
                    <option value="Audit" style="weight:50px">Audit</option>
                    <option value="Business Development" style="weight:50px">Business Development</option>
                    <option value="Cashier" style="weight:50px">Cashier</option>
                    <option value="Checker Plant" style="weight:50px">Checker Plant</option>
                    <option value="Coordinator" style="weight:50px">Coordinator</option>
                    <option value="Data Entry" style="weight:50px">Data Entry</option>
                    <option value="Direktur" style="weight:50px">Direktur</option>
                    <option value="Dispatcher" style="weight:50px">Dispatcher</option>
                    <option value="Driver" style="weight:50px">Driver</option>
                    <option value="General Manager" style="weight:50px">General Manager</option>
                    <option value="Gudang" style="weight:50px">Gudang</option>
                    <option value="helper" style="weight:50px">helper</option>
                    <option value="HR" style="weight:50px">HR</option>
                    <option value="IT Support" style="weight:50px">IT Support</option>
                    <option value="IT Jaringan" style="weight:50px">IT Jaringan</option>
                    <option value="Junior Mekanik" style="weight:50px">Junior Mekanik</option>
                    <option value="Kepala Gudang" style="weight:50px">Kepala Gudang</option>
                    <option value="Magang" style="weight:50px">Magang</option>
                    <option value="Manager" style="weight:50px">Manager</option>
                    <option value="Manager Finance" style="weight:50px">Manager Finance</option>
                    <option value="Mechanic" style="weight:50px">Mechanic</option>
                    <option value="Mechanic Group" style="weight:50px">Mechanic Group</option>
                    <option value="Mechanic Supervisor" style="weight:50px">Mechanic Supervisor</option>
                    <option value="Motoris" style="weight:50px">Motoris</option>
                    <option value="Operator" style="weight:50px">Operator</option>
                    <option value="Petrolman" style="weight:50px">Petrolman</option>
                    <option value="Pic Project" style="weight:50px">Pic Project</option>
                    <option value="IT Programmer" style="weight:50px">IT Programmer</option>
                    <option value="Purchasing" style="weight:50px">Purchasing</option>
                    <option value="Quality Control" style="weight:50px">Quality Control</option>
                    <option value="Sales" style="weight:50px">Sales</option>
                    <option value="Sales Taking Order" style="weight:50px">Sales Taking Order</option>
                    <option value="Security" style="weight:50px">Security</option>
                    <option value="Senior Mekanik" style="weight:50px">Senior Mekanik</option>
                    <option value="Service Officer" style="weight:50px">Service Officer</option>
                    <option value="Staff Finance" style="weight:50px">Staff Finance</option>
                    <option value="Staff Ga" style="weight:50px">Staff Ga</option>
                    <option value="Staff Senior Petrolman" style="weight:50px">Staff Senior Petrolman</option>
                    <option value="Supervisor" style="weight:50px">Supervisor</option>
                    <option value="Supervisor Fleet" style="weight:50px">Supervisor Fleet</option>
                    <option value="Umum" style="weight:50px">Umum</option>
                    <option value="SO Fleet" style="weight:50px">SO Fleet</option>
                    <option value="Petrollman" style="weight:50px">Petrollman</option>
                    <option value="Service Officer" style="weight:50px">Service Officer</option>
                    <option value="Koord. Service Officer" style="weight:50px">Koord. Service Officer</option>
                    <option value="Last Mile" style="weight:50px">Last Mile</option>
                    <option value="Leader Kitchen" style="weight:50px">Leader Kitchen</option>
                    <option value="Leader Front" style="weight:50px">Leader Front</option>
                    <option value="Waiter" style="weight:50px">Waiter</option>
                    <option value="Cook" style="weight:50px">Cook</option>
                    <option value="Cook Helper" style="weight:50px">Cook Helper</option>
                    <option value="Dishwasher" style="weight:50px">Dishwasher</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="ms_divisi" class="form-label">Sub Divisi</label>
                  <select name = 'sub_divisi'class="form-control">
                    <option value="Approval_External" style="weight:50px">Approval_External</option>
                    <option value="Approval_internal" style="weight:50px">Approval_internal</option>
                    <option value="Account Renable" style="weight:50px">Account Renable</option>
                    <option value="Audit" style="weight:50px">Audit</option>
                    <option value="Business Development" style="weight:50px">Business Development</option>
                    <option value="Cashier" style="weight:50px">Cashier</option>
                    <option value="Checker Plant" style="weight:50px">Checker Plant</option>
                    <option value="Coordinator" style="weight:50px">Coordinator</option>
                    <option value="Data Entry" style="weight:50px">Data Entry</option>
                    <option value="Direktur" style="weight:50px">Direktur</option>
                    <option value="Dispatcher" style="weight:50px">Dispatcher</option>
                    <option value="Driver" style="weight:50px">Driver</option>
                    <option value="General Manager" style="weight:50px">General Manager</option>
                    <option value="Gudang" style="weight:50px">Gudang</option>
                    <option value="helper" style="weight:50px">helper</option>
                    <option value="HR" style="weight:50px">HR</option>
                    <option value="IT Support" style="weight:50px">IT Support</option>
                    <option value="IT Jaringan" style="weight:50px">IT Jaringan</option>
                    <option value="Junior Mekanik" style="weight:50px">Junior Mekanik</option>
                    <option value="Kepala Gudang" style="weight:50px">Kepala Gudang</option>
                    <option value="Magang" style="weight:50px">Magang</option>
                    <option value="Manager" style="weight:50px">Manager</option>
                    <option value="Manager Finance" style="weight:50px">Manager Finance</option>
                    <option value="Mechanic" style="weight:50px">Mechanic</option>
                    <option value="Mechanic Group" style="weight:50px">Mechanic Group</option>
                    <option value="Mechanic Supervisor" style="weight:50px">Mechanic Supervisor</option>
                    <option value="Motoris" style="weight:50px">Motoris</option>
                    <option value="Operator" style="weight:50px">Operator</option>
                    <option value="Petrolman" style="weight:50px">Petrolman</option>
                    <option value="Pic Project" style="weight:50px">Pic Project</option>
                    <option value="IT Programmer" style="weight:50px">IT Programmer</option>
                    <option value="Purchasing" style="weight:50px">Purchasing</option>
                    <option value="Quality Control" style="weight:50px">Quality Control</option>
                    <option value="Sales" style="weight:50px">Sales</option>
                    <option value="Sales Taking Order" style="weight:50px">Sales Taking Order</option>
                    <option value="Security" style="weight:50px">Security</option>
                    <option value="Senior Mekanik" style="weight:50px">Senior Mekanik</option>
                    <option value="Service Officer" style="weight:50px">Service Officer</option>
                    <option value="Staff Finance" style="weight:50px">Staff Finance</option>
                    <option value="Staff Ga" style="weight:50px">Staff Ga</option>
                    <option value="Staff Senior Petrolman" style="weight:50px">Staff Senior Petrolman</option>
                    <option value="Supervisor" style="weight:50px">Supervisor</option>
                    <option value="Supervisor Fleet" style="weight:50px">Supervisor Fleet</option>
                    <option value="Umum" style="weight:50px">Umum</option>
                    <option value="SO Fleet" style="weight:50px">SO Fleet</option>
                    <option value="Petrollman" style="weight:50px">Petrollman</option>
                    <option value="Service Officer" style="weight:50px">Service Officer</option>
                    <option value="Koord. Service Officer" style="weight:50px">Koord. Service Officer</option>
                    <option value="Last Mile" style="weight:50px">Last Mile</option>
                    <option value="Leader Kitchen" style="weight:50px">Leader Kitchen</option>
                    <option value="Leader Front" style="weight:50px">Leader Front</option>
                    <option value="Waiter" style="weight:50px">Waiter</option>
                    <option value="Cook" style="weight:50px">Cook</option>
                    <option value="Cook Helper" style="weight:50px">Cook Helper</option>
                    <option value="Dishwasher" style="weight:50px">Dishwasher</option>

                  </select>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required="" />
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                      required = ""
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Company</label>
                    <select name = 'ms_company'class="form-control">
                      <option value="PT. Handal Guna Sarana" style="weight:50px">PT. Handal Guna Sarana </option>
                      <option value="PT. Tirta Gracia Utama" style="weight:50px">PT. Tirta Gracia Utama</option>
                      <option value="PT. Tirta Gracia Fiesta" style="weight:50px">PT. Tirta Gracia Fiesta</option>
                      <option value="PT. Tirta Utama Abadi" style="weight:50px">PT. Tirta Utama Abadi</option>
                    </select>
                   <!--<input type="text" class="form-control" id="email" name="ms_company" placeholder="Enter Company" required="" /> -->
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Cabang</label>
                    <select name = 'ms_branch'class="form-control">
                      <option value="HGS Pusat" style="weight:50px">HGS Pusat</option>
                      <option value="HGS Ciherang" style="weight:50px">HGS Ciherang</option>
                      <option value="HGS Subang" style="weight:50px">HGS Subang</option>
                      <option value="HGS Sentul" style="weight:50px">HGS Sentul</option>
                      <option value="HGS Bandung Agriaku" style="weight:50px">HGS Bandung Agriaku</option>
                      <option value="HGS Bandung Agrovass" style="weight:50px">HGS Bandung Agrovass</option>
                      <option value="HGS Cirebon Agriaku" style="weight:50px">HGS Cirebon Agriaku</option>
                      <option value="HGS Tasikmalaya Agriaku" style="weight:50px">HGS Tasikmalaya Agriaku</option>
                      <option value="HGS-CIPINANG-JAPFA" style="weight:50px">HGS-CIPINANG-JAPFA</option>
                      <option value="HGS-SMU-BOGOR" style="weight:50px">HGS-SMU-BOGOR</option>
                      <option value="TGU Pusat" style="weight:50px">TGU Pusat</option>
                      <option value="TGU Ciracas" style="weight:50px">TGU Ciracas</option>
                      <option value="TGU Ciracas Bukalapak" style="weight:50px">TGU Ciracas Bukalapak</option>
                      <option value="TGU Sunter Gudang Baru" style="weight:50px">TGU Sunter Gudang Baru</option>
                      <option value="TGU Tangerang" style="weight:50px">TGU Tangerang</option>
                      <option value="TGU Bandung BL" style="weight:50px">TGU Bandung BL</option>
                      <option value="TGF Pusat PH" style="weight:50px">TGF Pusat PH</option>
                      <option value="TGF Pokenbir" style="weight:50px">TGF Pokenbir</option>
                      <option value="TGF Ciracas" style="weight:50px">TGF Ciracas</option>
                      <option value="TGF Suka Itjip PH" style="weight:50px">TGF Suka Itjip PH</option>
                      <option value="TGF Ayam Apa Bebek" style="weight:50px">TGF Ayam Apa Bebek</option>
                      <option value="TGF Coffeelicious" style="weight:50px">TGF Coffeelicious</option>
                      <option value="TGF Chickenbir" style="weight:50px">TGF Chickenbir</option>
                      <option value="TGF Pokenrice PH" style="weight:50px">TGF Pokenrice PH</option>
                       <option value="TGF Pokenrice LMP" style="weight:50px">TGF Pokenrice LMP</option>

                    </select>
                    {{--  <input type="text" class="form-control" id="email" name="ms_branch" placeholder="Enter Cabang" required="" />  -  --}}
                </div>
                <div class="mb-3">
                  <label for="role" class="form-label">Role</label>
                  <input type="text" class="form-control" id="role" name="role" value="Guest" readonly />
                </div>

                <!-- <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                      I agree to
                      <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                  </div>
                </div> -->
                <button class="btn btn-primary d-grid w-100">Sign up</button>
              </form>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="{{ route('login') }}">
                  <span>Sign in instead</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- <div class="buy-now">
      <a
        href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Upgrade to Pro</a
      >
    </div> -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const togglePassword = document.querySelector('.form-password-toggle .input-group-text');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.querySelector('i').classList.toggle('bx-hide');
    });
  });
</script>

