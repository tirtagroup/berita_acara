<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="bg-image">

  <nav class="navbar">
    @if (Auth::check())
      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class='bx bx-power-off me-2'></i>
        {{--  <span class="align-middle white-text">Logout</span>  --}}
        {{--  <div class="logo">Logoout</div>  --}}
      </a>
    <form method="POST" id="logout-form" action="{{ route('logout') }}">
      @csrf
    </form>
    @endif
    <ul class="nav-links" id="navLinks">
       @if ($user->role == 'Koordinator')
        <li><a href="/input_berita_acara">BA Kejadian</a></li>
        <li><a href="/request_revisi">BA Request Revisi</a></li>
        <li><a href="/create_pica">PICA</a></li>
        <li><a href="/ba_laka">BA Laka</a></li>
        <li><a href="/validasi_koord">Approval Koord.</a></li>
        <li><a href="/list_request_koord">List Request</a></li>

      @else
        <li><a href="/input_berita_acara">BA Kejadian</a></li>
        <li><a href="/request_revisi">BA Revisi</a></li>
        <li><a href="/create_pica">PICA</a></li>
        <li><a href="/ba_laka">BA Laka</a></li>
      @endif

      @if (Auth::check())
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class='bx bx-power-off me-2'></i>
          <span class="align-middle white-text">Logout</span>
          {{--  <div class="logo">Logoout</div>  --}}
        </a>
      <form method="POST" id="logout-form" action="{{ route('logout') }}">
        @csrf
      </form>
      @endif
    </ul>
  </nav>

  <div id="rotate-words">
   <div class="bg-text">Selamat Datang Di Halaman Berita Acara Dan Request Revisi</div>
    <div class="bg-text">Harap Untuk Bisa Membedakan Berita Acara Yang Bersifat Laporan/Kejadian, </div>
    <div class="bg-text">Dan Berita Acara Request Revisi Yang Sifatnya Meminta Perubahan Data Perusahaan</div>
    <div class="bg-text">Jika Mengalami Kendala, Bisa Hubungi Atasan masing-masing, Atau Ke Team IT HGS</div>
    </div>
</body>



<style>
  @import url('https://fonts.googleapis.com/css?family=Oswald:700');
  @import url('https://fonts.googleapis.com/css?family=Rubik');

  body {
    //background: rgb(91,52,5);
    //background: linear-gradient(0deg, rgba(91,52,5,1) 0%, rgba(222,212,91,0.9471989479385504) 100%);
    background-image: url('upload/drivers.jpg');
    background-size:100%;
    background-repeat:no-repeat;
    background-attachment:fixed;
    color:#fff;
    text-align:center;
    
     
  }

  #rotate-words {
    max-width:400px;
    margin:auto;
    padding:20% 0;
    font-size:2.2em;
    text-transform:uppercase;
    font-family: 'Oswald', sans-serif;
  }

  #rotate-words span {
    display:block;
    height:50px;
    font-size:.7em;
    text-transform:lowercase;
    opacity:.8;
    font-family: 'Rubik', sans-serif;
  }

  #rotate-words div {
   position:absolute;
   opacity:0;
   overflow:hidden;
   left:10vw;
   width:80vw;
   line-height:1.2em;
   animation: rotate-word 32s linear infinite 0s;
  }

  @keyframes rotate-word {
      0% { opacity: 0;  transform: translateX(0);filter:blur(10px);transform:scale(1.2)}
      3% { opacity: 1;  transform: translateX(0);filter:blur(0px);transform:scale(.9)}
      12% { opacity: 1; transform: translateX(0);filter:blur(0px);transform:scale(1)}
      16% { opacity: 0; transform: translateX(0);filter:blur(10px);transform:scale(1.2)}
      80% { opacity: 0}
      100% { opacity: 0}
  }

  #rotate-words div:nth-child(2) { animation-delay: 4s}
  #rotate-words div:nth-child(3) { animation-delay: 8s}
  #rotate-words div:nth-child(4) { animation-delay: 12s}
  #rotate-words div:nth-child(5) { animation-delay: 16s}
  #rotate-words div:nth-child(6) { animation-delay: 20s}
  #rotate-words div:nth-child(7) { animation-delay: 24s}
  #rotate-words div:nth-child(8) { animation-delay: 28s}

  @keyframes author {
      0% { opacity: 0;  transform: translateY(100px);filter:blur(10px);transform: scaleY(2)}
      20% { opacity:0; transform: translateY(200px);filter:blur(10px); transform: scaleY(2)}
      30% { opacity:1; transform: translateY(0);filter:blur(0px);transform: scaleY(1)}
      90% { opacity:1; transform: translateY(0);filter:blur(0px);transform: scaleY(.9)}
      100% { opacity:0; transform: translateY(0);filter:blur(10px);transform: scale(2)}
  }

  .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: rgb(80, 79, 82);
    color: white;
  }

  .logo {
    font-size: 1.5rem;
  }

  .nav-links {
    list-style: none;
    display: flex;
  }

  .nav-links li {
    margin-right: 20px;
  }

  .nav-links a {
    text-decoration: none;
    color: white;
  }
  
  .bg-text {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  font-weight: bold;
  border: 3px solid #f1f1f1;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2;
  width: 80%;
  padding: 20px;
  text-align: center;
}

</style>
</html>

