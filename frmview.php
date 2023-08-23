<?php

include("../../configuration.php");
include("../../connection.php");
include("actsearch.php");

  if(isset($_POST['inmaster'])){
    $inmaster = $_POST['inmaster'];
  }

  if ($inmaster == "color") {
    $tablex = "kmwrnsepatu";
    $column_idx = "kdwarna";
    $column_datax = "nmwarna";
    $name_idx = "Kode Warna";
    $name_datax = "Nama Warna";
  }
  elseif ($inmaster == "golongan") {
    $tablex = "kmgolsepatu";
    $column_idx = "kdgol";
    $column_datax = "nmgol";
    $name_idx = "Kode Golongan";
    $name_datax = "Nama Golongan";
  }
  elseif ($inmaster == "material") {
    $tablex = "kmjeniskulit";
    $column_idx = "kdjenis";
    $column_datax = "nmjenis";
    $name_idx = "Kode Material";
    $name_datax = "Nama Material";
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Form View</title>
</head>

<!-- DATA TABLE -->
<script type="text/javascript" src="DataTables/datatables.js"></script>
<link rel="stylesheet" href="DataTables/datatables.css"/>

<?php
$xrdm = date("YmdHis");
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css?verion=$xrdm\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/frmstyle.css?version=$xrdm\" />";
?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#myTable').DataTable({"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]});
  });
</script>


  <body>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="">
      <tr>
        <td>
         <div id="frmisi">
          <table id="myTable" class="table">
            <thead>
              <tr>
                <th align="center">No</th>
                <th align="center"><?=$name_idx?></th>
                <th align="center"><?=$name_datax?></th>
              </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM ".$tablex." ORDER BY access DESC";
            $res = mysql_query($sql,$conn);
            $count = mysql_num_rows($res);
            $row = 0;

            if($count > 0){
              while ($data = mysql_fetch_array($res, MYSQL_BOTH)){
                $row += 1;
                $kode = $data[$column_idx];
                $nama = $data[$column_datax];
                ?>
                <tr>
                  <td align="center" nowrap><?=$row?></td>
                  <td style="text-align: left;" nowrap><?=$kode?></td>
                  <td style="text-align: left;" nowrap><?=$nama?></td>
                </tr>
                <?php
              }
              mysql_free_result($result);
            }
            ?>
          </tbody>
        </table>
      </div>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_close($conn);
?>
