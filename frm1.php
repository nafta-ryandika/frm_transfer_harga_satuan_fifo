<?php

include("../../configuration.php");
include("../../connection.php");
include("../../endec.php");
include("akses.php");
require_once('calendar/classes/tc_calendar.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Form Update Harga Satuan FIFO</title>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="expires" content="0">
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    </head>


   <script language="javascript" src="calendar/calendar.js"></script>

    <link rel="stylesheet" href="../../theme/south-street/jquery-ui-1.8.13.custom.css">
    <!-- <script src="../../js/jquery-1.5.1.js"></script> -->
    <script src="../../js/ui/jquery.ui.core.js"></script>
    <script src="../../js/ui/jquery.ui.widget.js"></script>
    <script src="../../js/ui/jquery.ui.datepicker.js"></script>
    <link rel="stylesheet" href="css/demos.css">
    <link rel="stylesheet" href="css/table.css">

    <!-- MODAL DIALOG -->
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquery-ui.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css"/>

    <!-- mask input -->
    <script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>

    <?php
    $xrdm = date("YmdHis");
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css?verion=$xrdm\" />";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/frmstyle.css?version=$xrdm\" />";
    ?>
    <link href="calendar/calendar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/frm1.js"></script>

    <!-- DATA TABLE -->
    <script type="text/javascript" src="DataTables/datatables.js"></script>
    <link rel="stylesheet" href="DataTables/datatables.css"/>


    <body>
      <table id="tabelview" width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2">
                  <div align="left">
                    <span style="font-size: 14px;font:Arial, Helvetica, sans-serif;font-weight: bold;">
                      Form Update Harga Satuan FIFO
                    </span>
                    <hr />
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <div>
              <fieldset class="info_fieldset"><legend>Import File Excel</legend>
                <iframe name="upload-frame" id="upload-frame" style="display:none;"></iframe>
                <form id="formupload" name="formupload" method="POST" enctype="multipart/form-data" target="upload-frame" onSubmit="">
                  <div style="width: 100%; text-align: center;">
                    <table align="center">
                        <tr>
                          <td align="left">Periode</td>
                          <td> : </td>
                          <td align="left">
                            <input type="text" id="inperiode" style="width: 80px; text-align: center;">
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3">
                            <input type="file" name="file" id="file"  style="margin: 5px; width: 500px;" onchange="importxls()">
                            <img align="center" src="img/loading1.gif" id="loader" style="display:none" />
                            <span id="upload-status"></span>
                          </td>
                        </tr>
                    </table>
                    <br/>
                    <INPUT id="cmdupload" class="buttonupload" type="submit" name="import" value="Upload" onclick="return upload()" title="upload Data">
                    <input id="cmddownload" class="buttondownload" type="button" name="nmcmddownload" value="Download" onclick="exportclick('xls')" title="Download Format Excel">
                    <INPUT id="cmdcancel" class="buttonclear" type="button" name="nmcmdcancel" value="Clear" onclick="clearinput()">
                    <br/>
                    <br/>
                  </div>
                </form>
                <FORM id="formexport" name="nmformexport" action="export.php" method="post" onsubmit="window.open ('', 'NewFormInfo', 'scrollbars,width=730,height=500')" target="NewFormInfo">
                  <!-- <input id="txtSQL" name="nmSQL" type="hidden" value="<?php echo $sql; ?>"> -->
                </FORM>
              </fieldset>
            </div>
          </td>
        </tr>
        <!-- <tr>
          <td>
            &nbsp;
          </td>
        </tr>
        <tr>
          <td>
            <fieldset class="info_fieldset">
              <p>
                * Note : <br/>
                <ul>
                  <li>Pastikan master data yang di pilih sudah sesuai dengan data yang di upload !</li>
                  <li>Format file transfer .xls</li>
                  <li>Master Color maksimal panjang kode 10 digit dan nama 30 digit</li>
                  <li>Master Golongan Sepatu maksimal panjang kode 10 digit dan nama 30 digit</li>
                  <li>Master Material maksimal panjang kode 2 digit dan nama 30 digit</li>
                </ul>
              </p>
            </fieldset>
          </td>
        </tr> -->
      </table>
      <div id="dialog-open"></div>

    </body>

    </html>
    <?php
    mysql_close($conn);
    ?>
