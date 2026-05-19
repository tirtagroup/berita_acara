<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;
    // public $header, $pendidikan_det, $pengalaman_det, $organisasi_det, $skill_det, $sosmed_det, $keluarga;
    public $header;
        
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($header)
    {
        // $this->data = $data;
        $this->header = $header;
        // $this->pendidikan_det = $pendidikan_det;
        // $this->pengalaman_det = $pengalaman_det;
        // $this->organisasi_det = $organisasi_det;
        // $this->skill_det = $skill_det;
        // $this->sosmed_det = $sosmed_det;
        // $this->keluarga = $keluarga;
    }
    // dd($data);die;
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Berita Acara')->view('berita_acara.email_ba_salah_isi')->with('header', $this->header);
        // ->with('header', $this->header, 'pendidikan_det', $this->pendidikan_det, 'pengalaman_det', $this->pengalaman_det, 'organisasi_det', $this->organisasi_det, 'skill_det', $this->skill_det, 'sosmed_det', $this->sosmed_det, 'keluarga', $this->keluarga );
        
    }
}