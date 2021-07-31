<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Produk;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;

class LaporanTransaksiProdukJadiController extends Controller
{
     public function index(Request $request)
    {
    	return view('pages.admin.laporan.produk_jadi.index');
    }

    public function cetakExcel(Request $request)
	{

		$tanggal_awal=date('Y-m-d', strtotime($request->tahun.'-'.$request->bulan.'-01'));
		$tanggal_akhir=date('Y-m-t', strtotime($request->tahun.'-'.$request->bulan.'-01'));

		$filter_tanggal = rangeDate($tanggal_awal, $tanggal_akhir);

		$transaksi = Pesanan::whereBetween('tanggal',[$tanggal_awal, $tanggal_akhir])
							->whereNotNull('produk_id')
							->where('status', 2)
							->selectRaw('
								(jumlah*harga) as total_harga,
								jumlah,
								harga,
								produk_id,
								tanggal
							')
							->get();

		$spreadsheet = new Spreadsheet();

		$styleTextCenter = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

		$styleTextRight = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
        ];

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->mergeCells("A2:F2");
        $sheet->mergeCells("A3:F3");
        $sheet->mergeCells("A4:F4");
        $sheet->mergeCells("A5:F5");

        $sheet->setCellValue('A2', 'REKAP TRANSAKSI PENDAPATAN DARI PRODUK JADI');
        $sheet->setCellValue('A3', strtoupper(auth()->user()->nama));
        $sheet->setCellValue('A4', 'DARI (BAWANG NURI)');
        $sheet->setCellValue('A5', 'PERIODE '.$filter_tanggal);

        $sheet->getStyle('A7:F7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('cacaca');
        $sheet->getStyle('A7:F7')->getFont()->setBold( true );
        $sheet->setCellValue('A7', 'No');
        $sheet->setCellValue('B7', 'Nama Produk');
        $sheet->setCellValue('C7', 'Tanggal');
        $sheet->setCellValue('D7', 'Jumlah');
        $sheet->setCellValue('E7', 'Harga (Rp)');
        $sheet->setCellValue('F7', 'Total (Rp)');
    	$i = 8;
   		$no = 1;

   		$jumlah_produk = [];
   		$jumlah_harga = [];
   		$jumlah_total = [];
		foreach ($transaksi as $row) {
			$sheet->setCellValue('A'.$i, $no++);
            $sheet->setCellValue('B'.$i, $row->Produk->nama);
            $sheet->setCellValue('C'.$i, tanggalIndo($row->tanggal));
	        $sheet->setCellValue('D'.$i, $row->jumlah);
	        $sheet->setCellValue('E'.$i, rupiah($row->harga));
	        $sheet->setCellValue('F'.$i, rupiah($row->total_harga));

	        $jumlah_produk [] = $row->jumlah;
	        $jumlah_harga [] = $row->harga;
	        $jumlah_total [] = $row->total_harga;

            $i++;
		}

		$rowCount = count($transaksi)+8;

		$sheet->mergeCells('A'.$rowCount.':C'.$rowCount);
		$sheet->getStyle('A'.$rowCount)->applyFromArray($styleTextCenter);
        $sheet->setCellValue('A'.$rowCount, 'JUMLAH TOTAL');
        $sheet->setCellValue('D'.$rowCount, array_sum($jumlah_produk));
        $sheet->setCellValue('E'.$rowCount, rupiah(array_sum($jumlah_harga)));
        $sheet->setCellValue('F'.$rowCount, rupiah(array_sum($jumlah_total)));

		$i = $i;
		$sheet->getStyle('A7:F'.$i)->applyFromArray($styleBorder);
		$sheet->getStyle('A7:F7')->applyFromArray($styleTextCenter);

		$sheet->getStyle('E8:E'.$rowCount)->applyFromArray($styleTextRight);
		$sheet->getStyle('F8:F'.$rowCount)->applyFromArray($styleTextRight);

        $sheet->getStyle('A2:F5')->applyFromArray($styleTextCenter);

        $i +=4;
        $sheet->mergeCells("C$i:F$i");
        $sheet->setCellValue('C'.$i, 'Kuningan, '.tanggalIndo(now()));
        $i +=1;
        $sheet->mergeCells("C$i:F$i");
        $sheet->setCellValue('C'.$i, 'Pimpinan Bawang Nuri');
        $i +=3;
        $sheet->mergeCells("C$i:F$i");
        $sheet->setCellValue('C'.$i, 'Tonia Hartanto, S.Kom');

        $namafile = 'laporan-transaksi-pendapatan-produkjadi-'.bulanIndo($request->bulan).'-'.$request->tahun.'.xlsx';
        $response = response()->streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$namafile.'"');
        $response->send();

	}
}
