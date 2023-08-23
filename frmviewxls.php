<?php
require_once '../../PHPExcel/PHPExcel.php';
include("../../configuration.php");
include("../../connection.php");

$xname = $_SESSION[$domainApp."_myname"];
$xgroup = $_SESSION[$domainApp."_mygroup"];

$excel = new PHPExcel();

$excel->getProperties()->setCreator('PT Karyamitra Budisentosa')
             ->setLastModifiedBy($xname)
             ->setTitle("Format Update Harga Satuan FIFO")
             ->setSubject("Format Update Harga Satuan FIFO")
             ->setDescription("Format Update Harga Satuan FIFO")
             ->setKeywords("Format Update Harga Satuan FIFO");

$excel->setActiveSheetIndex(0)->setCellValue('A1', "tahun");
$excel->setActiveSheetIndex(0)->setCellValue('B1', "kode gudang");
$excel->setActiveSheetIndex(0)->setCellValue('C1', "nama gudang");
$excel->setActiveSheetIndex(0)->setCellValue('D1', "kode barang");
$excel->setActiveSheetIndex(0)->setCellValue('E1', "nama barang");
$excel->setActiveSheetIndex(0)->setCellValue('F1', "satuan");
$excel->setActiveSheetIndex(0)->setCellValue('G1', "urut");
$excel->setActiveSheetIndex(0)->setCellValue('H1', "harga satuan");
$excel->setActiveSheetIndex(0)->setCellValue('I1', "total qty");
$excel->setActiveSheetIndex(0)->setCellValue('J1', "total jumlah");
$excel->setActiveSheetIndex(0)->setCellValue('K1', "jenis");

$excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
$excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);

// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Sheet1");
$excel->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Format Update Harga Satuan FIFO.xls"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');
?>