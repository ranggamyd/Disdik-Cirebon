<?php

namespace App\MyClass;

use App\Models\Iuran;
use App\Models\Pengeluaran;
use App\Models\Pemasukan;

class Laporan
{
	public static function laporanData($tahun, $bulan)
	{
		$tglAwal = date('Y-m-01', strtotime("$tahun-$bulan-01"));
		$tglAkhir = date('Y-m-t', strtotime("$tahun-$bulan-01"));
		$tglAkhirBulanLalu = \Carbon\Carbon::createFromFormat('Y-m-d', $tglAwal)->addMonths(-1)->format('Y-m-t');

		$results = [
			'saldo_awal'		=> 0, 
			'iuran' 			=> [],
			'pemasukan'			=> [],
			'pengeluaran_dengan_kategori' => [],
			'pengeluaran_tanpa_kategori' => [],
			'total_pemasukan'	=> 0,
			'total_pengeluaran' => 0,
			'saldo_akhir' 		=> 0,
			'tgl_awal'			=> \Carbon\Carbon::createFromFormat('Y-m-d', $tglAwal),
			'tgl_akhir'			=> \Carbon\Carbon::createFromFormat('Y-m-d', $tglAkhir),
			'tgl_akhir_bulan_lalu' => \Carbon\Carbon::createFromFormat('Y-m-d', $tglAkhirBulanLalu),
		];


		// Saldo Awal
		$totalPengeluaranSebelumnya = 0;
		$totalPemasukanSebelumnya = 0;
		$pengeluaran = Pengeluaran::whereDate('tgl', '<', $tglAwal)
								  ->get();
		foreach($pengeluaran as $p) {
			$totalPengeluaranSebelumnya += $p->nominal;
		}

		$iuran = Iuran::whereDate('tgl_bayar', '<', $tglAwal)
					  ->get();
		foreach($iuran as $i) {
			$totalPemasukanSebelumnya += $i->nominal;
		}

		$pemasukan = Pemasukan::whereDate('tgl', '<', $tglAwal)
							  ->get();
		foreach($pemasukan as $p) {
			$totalPemasukanSebelumnya += $p->nominal;
		}

		$results['saldo_awal'] = $totalPemasukanSebelumnya - $totalPengeluaranSebelumnya;


		// Iuran
		$iuran = Iuran::whereBetween('tgl_bayar', [ $tglAwal, $tglAkhir ])
					  ->orderBy('tgl_bayar', 'asc')
					  ->get();
		foreach($iuran as $i) {
			$key = date('Y-m', strtotime($i->tgl_bayar));
			if(array_key_exists($key, $results['iuran'])) {
				$results['iuran'][$key]['nominal'] += $i->nominal;
			} else {
				$results['iuran'][$key] = [
					'label'		=> \Carbon\Carbon::createFromFormat('Y-m-d', $i->tgl_bayar)->isoFormat('MMMM Y'),
					'nominal'	=> $i->nominal,
				];
			}
			$results['total_pemasukan'] += $i->nominal;
		}


		// Pemasukan
		$pemasukan = Pemasukan::whereBetween('tgl', [$tglAwal, $tglAkhir])->get();

		foreach($pemasukan as $p) {
			$results['pemasukan'][] = $p;
			$results['total_pemasukan'] += $p->nominal;
		}


		// Pengeluaran Dengan Kategori
		$pengeluaran = Pengeluaran::has('kategoriPengeluaran')
								  ->with([ 'kategoriPengeluaran' ])
								  ->whereBetween('tgl', [ $tglAwal, $tglAkhir ])
								  ->get();

		foreach($pengeluaran as $p) {
			$key = $p->id_kategori_pengeluaran;
			if(array_key_exists($key, $results['pengeluaran_dengan_kategori'])) {
				$results['pengeluaran_dengan_kategori'][$key]['data'][] = $p;
			} else {
				$results['pengeluaran_dengan_kategori'][$key] = [
					'label'	=> $p->kategoriPengeluaran->nama_kategori_pengeluaran,
					'data'	=> [ $p ],
				];
			}

			$results['total_pengeluaran'] += $p->nominal;
		}

		// Pengeluaran Tanpa Kategori
		$pengeluaran = Pengeluaran::doesntHave('kategoriPengeluaran')
								  ->whereBetween('tgl', [ $tglAwal, $tglAkhir ])
								  ->get();

		foreach($pengeluaran as $p) {
			$results['pengeluaran_tanpa_kategori'][] = $p;
			$results['total_pengeluaran'] += $p->nominal;
		}

		$results['saldo_akhir'] = $results['saldo_awal'] + $results['total_pemasukan'] - $results['total_pengeluaran'];

		return $results;
	}

	public static function saldoTerakhir()
	{
		$laporan = self::laporanData(date('Y'), date('n'));
		return $laporan['saldo_akhir'];
	}



	/**
	 * 
	 * 	Report
	 * 
	 * */
	public static function laporanKeuanganGeneratePdfReport($request)
	{
		$bulan = $request->bulan;
		$namaBulan = \App\MyClass\Date::monthName($bulan);
		$tahun = $request->tahun;
		$filename = "Laporan_Keuangan_".$namaBulan.' '.$tahun;

		$pdf = \PDF::loadView('admin.report.report_laporan_keuangan', [
			'laporan'	=> self::laporanData($tahun, $bulan),
			'periode'	=> $namaBulan.' '.$tahun,
			'tahun'		=> $tahun,
			'bulan'		=> $bulan,
		])->setPaper('A4', 'portrait');
		$filename .= '.pdf';

		return (object) [
			'pdf'		=> $pdf,
			'filename'	=> $filename,
		];
	}


	public static function laporanKeuanganStreamPdfReport($request)
	{
		$result = self::laporanKeuanganGeneratePdfReport($request);

		return $result->pdf->stream($result->filename);
	}


	public static function laporanKeuanganDownloadPdfReport($request)
	{
		$result = self::laporanKeuanganGeneratePdfReport($request);

		return $result->pdf->download($result->filename);
	}


	public static function laporanKeuanganDownloadExcelReport($request)
	{
		$bulan = $request->bulan;
		$tahun = $request->tahun;
		$namaBulan = \App\MyClass\Date::monthName($bulan);
		$filename = "Laporan_Keuangan_".$namaBulan.' '.$tahun.'.xlsx';
		$laporan = self::laporanData($tahun, $bulan);
		$periode = $namaBulan.' '.$tahun;

		$headerStyle = [ 'font-style'=>'bold', 'halign'=>'center', 'border'=>'left,right,top,bottom', 'border-color' => '#000', 'border-style' => 'thin', 'widths'=> [ 300, 300, 300, 300 ], 'valign' => 'center' ];
		$bodyStyle = [ 'border'=>'left,right,top,bottom', 'border-color' => '#000', 'border-style' => 'thin' ];

		$writer = new \App\MyClass\XLSXWriter();

		$writer->writeSheetHeader('Sheet1', [
			'LAPORAN PENERIMAAN DAN PENGELUARAN DANA'	=> 'string',
		], [
			'widths'=> [40,30,30],
			'font-style'=>'bold', 'halign'=>'center', 'valign' => 'center', 'height'=> 5, 'wrap_text' => true
		]);
		$writer->markMergedCell('Sheet1', $start_row=0, $start_col=0, $end_row=0, $end_col=2);

		$writer->writeSheetRow('Sheet1', [
			'HIMPANA CABANG CIREBON'
		], [
			'halign'=>'center', 'valign' => 'center',
		]);
		$writer->markMergedCell('Sheet1', $start_row=1, $start_col=0, $end_row=1, $end_col=2);

		$writer->writeSheetRow('Sheet1', [
			strtoupper($laporan['tgl_awal']->isoFormat('MMMM Y'))
		], [
			'halign'=>'center', 'valign' => 'center',
		]);
		$writer->markMergedCell('Sheet1', $start_row=2, $start_col=0, $end_row=2, $end_col=2);

		$writer->writeSheetRow('Sheet1', []);

		$writer->writeSheetRow('Sheet1', [
			'KETERANGAN',
			'JUMLAH',
			'',
		], $headerStyle);
		$writer->markMergedCell('Sheet1', $start_row=4, $start_col=1, $end_row=4, $end_col=2);

		$writer->writeSheetRow('Sheet1', [
			'',
			'PENERIMAAN',
			'PENGELUARAN',
		], $headerStyle);
		$writer->markMergedCell('Sheet1', $start_row=4, $start_col=0, $end_row=5, $end_col=0);

		$writer->writeSheetRow('Sheet1', ['', '', ''], $bodyStyle);


		// Saldo
		$writer->writeSheetRow('Sheet1', [
			'SALDO BULAN SEBELUMNYA ('.$laporan['tgl_akhir_bulan_lalu']->isoFormat('MMMM Y').')',
			$laporan['saldo_awal'],
			''
		], $bodyStyle);

		$writer->writeSheetRow('Sheet1', ['', '', ''], $bodyStyle);

		$writer->writeSheetRow('Sheet1', [
			'Penerimaan Iuran Bulan :',
			'',
			'',
		], $bodyStyle);


		// Iuran
		foreach($laporan['iuran'] as $i) {
			$writer->writeSheetRow('Sheet1', [
				'- '.$i['label'],
				$i['nominal'],
				'',
			], $bodyStyle);
		}
		$writer->writeSheetRow('Sheet1', ['', '', ''], $bodyStyle);


		// Pemasukan
		foreach($laporan['pemasukan'] as $p) {
			$writer->writeSheetRow('Sheet1', [
				$p->keterangan,
				$p->nominal,
				'',
			], $bodyStyle);
			$writer->writeSheetRow('Sheet1', ['', '', ''], $bodyStyle);
		}


		// Pengeluaran Dengan Kategori
		foreach($laporan['pengeluaran_dengan_kategori'] as $p) {
			$writer->writeSheetRow('Sheet1', [
				$p['label'],
				'',
				'',
			], $bodyStyle);
			foreach($p['data'] as $d) {
				$writer->writeSheetRow('Sheet1', [
					$d->keterangan,
					'',
					$d->nominal,
				], $bodyStyle);
			}
			$writer->writeSheetRow('Sheet1', ['', '', ''], $bodyStyle);
		}


		// Pengeluaran Tanpa Kategori
		foreach($laporan['pengeluaran_tanpa_kategori'] as $p) {
			$writer->writeSheetRow('Sheet1', [
				$p->keterangan,
				'',
				$p->nominal,
			], $bodyStyle);
			$writer->writeSheetRow('Sheet1', ['', '', ''], $bodyStyle);
		}

		$writer->writeSheetRow('Sheet1', [
			'',
			$laporan['saldo_awal'] + $laporan['total_pemasukan'],
			$laporan['total_pengeluaran'],
		], $bodyStyle);

		$writer->writeSheetRow('Sheet1', [
			'SALDO PER '.\Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-t', strtotime("$tahun-$bulan-01")))->isoFormat('D MMMM Y'),
			'',
			$laporan['saldo_akhir'],
		], $bodyStyle);

		$path = \Helper::tempPath($filename);
		$writer->writeToFile($path);

		return $path;
	}
}