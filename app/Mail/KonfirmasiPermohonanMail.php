<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KonfirmasiPermohonanMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($permohonan, $catatanEmail, $path)
	{
		$this->permohonan = $permohonan;
		$this->catatanEmail = $catatanEmail;
		$this->path = $path;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('Konfirmasi Permohonan '.$this->permohonan->nama_yayasan)
					->view('mail.konfirmasi_permohonan', [
						'permohonan'	=> $this->permohonan,
						'catatanEmail'	=> $this->catatanEmail,
					])
					->attach($this->path);
	}
}
