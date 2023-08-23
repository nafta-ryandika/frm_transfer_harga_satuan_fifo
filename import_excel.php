<?php
include("../../configuration.php");
include("../../connection.php");

require_once '../../PHPExcel/PHPExcel/IOFactory.php';
ini_set('memory_limit', '2048M');

$fileName = $_FILES['file']['name'];
$fileSize = $_FILES['file']['size'];
$fileError = $_FILES['file']['error'];
$error = "";


if($fileSize > 0 || $fileError == 0){
   $targetPath = 'temp/'.$fileName;
   $move = move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

   chmod($targetPath,0777);

   if(isset($_GET['inperiode'])){
      $inperiode = $_GET['inperiode'];
   }

   if ($move) {
      $excel = PHPExcel_IOFactory::load($targetPath);

      foreach($excel->getWorksheetIterator() as $data){
         $max_row = $data->getHighestRow();

            $sheet = $excel->getIndex($data);
            if ($sheet == 0){
               // $idx = trim(mysql_escape_string($data->getCellByColumnAndRow(0,1)->getValue())); 
               // $datax = trim(mysql_escape_string($data->getCellByColumnAndRow(1,1)->getValue())); 

               // if (strtoupper($idx) == "KODE" && strtoupper($datax) == "NAMA") {
                  // $max = 0;
                  // $data_exist = "";
                  // $row_exist = 0;
                  for($i = 2; $i <= $max_row; $i++){ 
                     $tahun = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(0,$i)->getValue()))); 
                     $kode_gudang = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(1,$i)->getValue())));
                     $nama_gudang = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(2,$i)->getValue())));
                     $kode_barang = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(3,$i)->getValue())));
                     $nama_barang = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(4,$i)->getValue())));
                     $satuan = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(5,$i)->getValue())));
                     $urut = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(6,$i)->getValue())));
                     $harga_satuan = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(7,$i)->getValue())));
                     $total_qty = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(8,$i)->getValue())));
                     $total_jumlah = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(9,$i)->getValue())));
                     $jenis = strtoupper(trim(mysql_escape_string($data->getCellByColumnAndRow(10,$i)->getValue())));

                     if ($jenis == "BAHAN BAKU") {
                        $jenis = 0;
                     }
                     else if ($jenis = "PEMBANTU") {
                        $jenis = 1;
                     }

                     $sql =   "SELECT fiftahun, fifgdg, fifkdbrg, fifsat, fifurut, fifjenis, fifhsatuan 
                              FROM kmsalfifo 
                              WHERE 
                              fiftahun = '".$tahun."' AND 
                              fifgdg = '".$kode_gudang."' AND 
                              fifkdbrg = '".$kode_barang."' AND 
                              fifsat = '".$satuan."' AND 
                              fifurut = '".$urut."'";

                     $res = mysql_query($sql,$conn);
                     $row = mysql_num_rows($res);

                     if ($row > 0) {
                        $sql1 = "UPDATE kmsalfifo SET 
                                 fifhsatuan = '".$harga_satuan."',
                                 fifjenis = '".$jenis."'
                                 WHERE 
                                 fiftahun = '".$tahun."' AND 
                                 fifgdg = '".$kode_gudang."' AND 
                                 fifkdbrg = '".$kode_barang."' AND 
                                 fifsat = '".$satuan."' AND 
                                 fifurut = '".$urut."'";
                        
                        if (!mysql_query($sql1,$conn)){
                           die("Error (1): " . mysql_error());
                        }
                     }
                     else{
                        $error .= $tahun."|".$kode_gudang."|".$nama_gudang."|".$kode_barang."|".$nama_barang."|".$satuan."|".$urut."|".$harga_satuan."|".$total_qty."|".$total_jumlah."|".$jenis."@#";
                     }
                     flush();
                     unset($tahun);
                     unset($kode_gudang);
                     unset($nama_gudang);
                     unset($kode_barang);
                     unset($nama_barang);
                     unset($satuan);
                     unset($urut);
                     unset($harga_satuan);
                     unset($total_qty);
                     unset($total_jumlah);
                     unset($jenis);
                  }  
               // }
            }
      }


      if ($error == "") {
         echo("Upload Sukses!");
      }
      else {
         echo($error);  
      }
   }
   else{
      echo("Upload Gagal!");
   }
   unlink($targetPath);
}
?>