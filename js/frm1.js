$(document).ready(function(){
  $("input[type=text],input[type=file]").bind("keydown", function(event) {
    if (event.which === 13) {
        event.stopPropagation();
        event.preventDefault();
       $(':input:eq(' + ($(':input').index(this) + 1) +')').focus();
    }
  });

  $("#inperiode").datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'mm/yy',
      onChangeMonthYear: function(year, month, widget) {
          setTimeout(function() {
             $('.ui-datepicker-calendar').hide();
          });
      },
      beforeShow: function () { 
          $('.ui-datepicker-calendar').hide();
      },
      onClose: function(dateText, inst) { 
          $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
          $('.ui-datepicker-calendar').hide();
      }
  }).click(function(){
      $('.ui-datepicker-calendar').hide();
  });

  $("#inperiode").focus(function () {
    $("#inperiode").datepicker("show");
    $('.ui-datepicker-calendar').hide();
  });

  $("#inperiode").focus();

  // $("#inperiode").mask("99/9999");

  $('#formupload').on('submit', function(event){  
    event.preventDefault();
    if ($("#inperiode").val() == "") {
      alert("Input Periode Kosong !");
      $("#inperiode").focus();
    }
    else {
      if (confirm("Upload Data ?")){
        $("#cmdupload").prop("disabled", true);
        $.ajax({  
            url:"import_excel.php?inperiode="+$("#inperiode").val(),  
            method:"POST",  
            data:new FormData(this),  
            contentType:false,
            cache:false,  
            processData:false, 
            beforeSend: function() {
              $("#loader").show();
              $("#upload-status").css('color','green');
              $("#upload-status").text("Please Wait ... Still Uploading Data");
              disabled();
            },
            success:function(data){
              if (data == 0){
                alert("Format Kolom Excel Tidak Sesuai !");
                $("#loader").hide();
                $("#upload-status").text("");
                enabled();
              }
              else {
                alert(data);
                $("#loader").hide();
                $("#upload-status").text("");
                clearinput();
                enabled();
              }
            }  
        })
      }
      $("#cmdupload").prop("disabled", false);
    }
  });

});

function enterfind(event){
  if(event.keyCode==13){
    findclick();
  }else{
    return ;
  }
}

function findclick(){
  var inmaster = $("#inmaster_table").val();
  if (inmaster == "") {
    alert("Parameter Master Tabel Kosong !");
  }
  else {
    $("#tabelinput").fadeOut("slow",function(){
      $("#tabelview").fadeIn("slow");
    });
                 
    $("#frmbody").slideUp('slow',function(){
      $("#frmloading").slideDown('slow',function(){
        $.ajax({
          url: "frmview.php",
          type: "POST",
          data: "inmaster="+inmaster,
          cache: false,
          success: function (html) {
                  $("#frmcontent").fadeIn("slow");
                  $("#frmcontent").html(html);
                  $("#frmbody").slideDown('slow',function(){
                  $("#frmloading").slideUp('slow');
            });
            }
        });
      });
    });
  }
}

function showinput(){
  $.ajax({
    url: "frminput.php",
    cache: false,
    success: function(html) {
      $("#areainput").html(html);
    }
  });
}

function clearinput(){
  $("#file").val('');
  $("#inmaster").val("");
}

function disabled(){
  $("#file").attr('disabled',true);
}

function enabled(){
  $("#file").attr('disabled',false);
}

function saveclick(){
  $("#cmdsave").attr('disabed','disabled');

  var data = "intxtmode="+$("#intxtmode").val()+
  "&inkode="+$("#inkode").val()+
  "&indata1="+encodeURIComponent($("#indata1").val())+
  "&indata2="+encodeURIComponent($("#indata2").val())+
  "&indata3="+encodeURIComponent($("#indata3").val())+
  "&indata4="+encodeURIComponent($("#indata4").val())+
  "&indata5="+encodeURIComponent($("#indata5").val())+
  "";
  //alert(data);
  $.ajax({
    url: "actfrm.php",
    type: "POST",
    data: data,
    cache: false,
    success: function(data) {
      alert("Data Loaded: " + data);
      if ($("#intxtmode").val()=='edit'){
        cancelclick();
      }else{
        clearinput();
      }
        $("#cmdsave").attr('disabed','');
    }
  });
};

function cancelclick(){
  $("#tabelinput").fadeOut("slow",function(){
    $("#tabelview").fadeIn("slow");
    findclick();
  });
}

function searchclick(){
  if ($("#areasearch").is(":hidden")) {
    $("#areasearch").slideDown("slow");
  } else {
    $("#areasearch").slideUp("slow");
  }
}

function setFilterData(rowx) {
  if ($("#txtfield" + rowx).val() == "IF(dt2.dkdbrg != '' AND dt3.spkdbrg != '', 1 , 0)") {
    var data_select =
      "Data : \n\
      <select class='txtdata'>\n\
      <option value=''>-</option>\n\
      <option value='1'>OK</option>\n\
      <option value='0'>Belum Dibuat</option>\n\
      </select>";
    $("#filter_data" + rowx).html(data_select);
  } else {
    var data_select =
      "Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'>";

    $("#filter_data" + rowx).html(data_select);
  }
}

function transfer(){
  if (confirm("Transfer Data ?")){
  var data ="intxtmode=checktemp";
    $.ajax({
      url: "actfrm.php",
      type: "POST",
      data: data,
      cache: false,
      beforeSend: function() {
            $("#loader").show();
            $("#upload-status").css('color','green');
            $("#upload-status").text("Please Wait ... Still Uploading Data");
            disabled();
          },
      success: function (data) {
          if (data == 0){
            alert("Data Tidak Ditemukan !");
            $("#loader").hide();
            $("#upload-status").text("");
            enabled();
          }
          else{
            $("#cmdtransfer").prop("disabled", true);
            var data ="intxtmode=transferso";
            $.ajax({
              url: "actfrm.php",
              type: "POST",
              data: data,
              cache: false,
              success: function (data) {
                var result = data.split('|');
                // alert(data);
                alert(" Import Success \n Jumlah Data Sales Order : "+result[1]+"");
                // $("#cmdtransfer").hide();
                // $("#cmdupload").show();
                $("#loader").hide();
                $("#upload-status").text("");
                enabled();
                clearinput();
                // alert(data);
                // console.log(data);
              }
            });
            $("#cmdtransfer").prop("disabled", false);
          }
      }
    });
  }
}

function hasExtension(inputID, exts) {
  var fileName = document.getElementById(inputID).value;
  return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
}

function upload(){
  if ($("#inmaster").val() == "") {
    alert("Input Master Data Kosong !");
    $("#inmaster").focus();
    return false;
  }
  else if ($("#file").val() == "") {
    alert("Input File Excel Kosong !");
    $("#file").focus();
    return false;
  }
  else if(!hasExtension('file', ['.xls']) && !hasExtension('file', ['.XLS'])){
    alert("Invalid Format File Excel !");
    return false;
  }
}

function exportclick(exptype) {
  switch (exptype) {
      case 'grd':
          $("#formexport").attr('action', 'frmviewgrid.php');
          $("#formexport").submit();
          break;
      case 'pdf':
          $("#formexport").attr('action', 'frmviewpdf.php');
          $("#formexport").submit();
          break;
      case 'xls':
          $("#formexport").attr('action', 'frmviewxls.php');
          $("#formexport").submit();
          break;
      case 'csv':
          $("#formexport").attr('action', 'frmviewcsv.php');
          $("#formexport").submit();
          break;
      case 'txt':
          $("#formexport").attr('action', 'frmviewtxt.php');
          $("#formexport").submit();
          break;
      default:
          alert('Unidentyfication Type');
  }
};

// ******************************* START JS MULTISEARCH ***************************************
var xrow = 1;
function addSearch(){
  var table = document.getElementById("tblSearch");

        // Create an empty <tr> element and add it to the 1st position of the table:
        var row = table.insertRow(xrow);

        // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        
//        cell2.className = 'txtmultisearch';

        // Add some text to the new cells:
        cell1.innerHTML = 
        "Field : \n\
        <select class='txtfield' id='txtfield" +
        xrow +
        "' onchange=\"setFilterData(" +
        xrow +
        ")\">\n\
        <option value=''>-</option>\n\
        <option value='nopo'>No. PO</option>\n\
        <option value=\"REPLACE(tanggalpo,'.','/')\" >Tgl. PO</option>\n\
        <option value='article' >Art. Customer</option>\n\
        <option value='material' >Nama Kulit</option>\n\
        <option value='color' >Warna</option>\n\
        <option value='brand' >Brand</option>\n\
        <option value='composition' >Komposisi</option>\n\
        </div>\n\
        </select>";
        cell2.innerHTML = "<select class='txtparameter' id='txtparameter"+xrow+"'>\n\
        <option value='equal'>equal</option>\n\
        <option value='notequal'>not equal</option>\n\
        <option value='less'>less</option>\n\
        <option value='lessorequal'>less or equal</option>\n\
        <option value='greater'>greater</option>\n\
        <option value='greaterorequal'>greater or equal</option>\n\
        <option value='isnull'>is null</option>\n\
        <option value='isnotnull'>is not null</option>\n\
        <option value='isnotnull'>is not null</option>\n\
        <option value='isin'>is in</option>\n\
        <option value='isnotin'>is not in</option>\n\
        <option value='like'>like</option>\n\
        </select>";
        cell3.innerHTML = 
        "<div id='filter_data" +
          xrow +
          "'>Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'></div>";
        cell4.innerHTML = "<input type='button' value='[+]' onclick='addSearch()'>";
        cell5.innerHTML = "<input type='button' value='remove' onclick=\"deleteRow(this)\" style='cursor:pointer;'>";
        
        xrow++;
      }

      function deleteRow(btn) {
      //
      if (btn == "rmv1") {
        $("#txtfield0").val("");
        $("#txtparameter0").val("equal");

        var data_select =
        "Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'>";

        $("#filter_data0").html(data_select);
        $("#txtdata0").val("");
      } else {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        xrow--;
      }
    }

// ******************************* END JS MULTISEARCH ***************************************

function showpage(page){
  $("#txtpage").val(page);
  findclick();
}

function prevpage(){
  var n = eval($("#txtpage").val())-1 ;
  if (n >= 1) {
    $("#txtpage").val(n);
    findclick();
  }
}

function nextpage(){
  var n = eval($("#txtpage").val())+1 ;
  if (eval(n)<=eval($("#jumpage").val())){
    $("#txtpage").val(n);
    findclick();
  }
}

$(function() {
  $( "#tglmasuk" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
  $( "#tglkontrak" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
  $( "#intxttglmasuk" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
  $( "#intxttglkontrak" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
});


function MyValidDate(dateString){
    var validformat=/^\d{1,2}\/\d{1,2}\/\d{4}$/ //Basic check for format validity
    if (!validformat.test(dateString)){
      return ''
    }else{ //Detailed check for valid date ranges
      var dayfield=dateString.substring(0,2);
      var monthfield=dateString.substring(3,5);
      var yearfield=dateString.substring(6,10);
      var MyNewDate = monthfield + "/" + dayfield + "/" + yearfield;
      if (checkValidDate(MyNewDate)==true){
        var SQLNewDate = yearfield + "/" + monthfield + "/" + dayfield;
        return SQLNewDate;
      }else{
        return '';
      }
    }
  }

  function checkValidDate(dateStr) {
    // dateStr must be of format month day year with either slashes
    // or dashes separating the parts. Some minor changes would have
    // to be made to use day month year or another format.
    // This function returns True if the date is valid.
    var slash1 = dateStr.indexOf("/");
    if (slash1 == -1) { slash1 = dateStr.indexOf("-"); }
    // if no slashes or dashes, invalid date
    if (slash1 == -1) { return false; }
    var dateMonth = dateStr.substring(0, slash1)
    var dateMonthAndYear = dateStr.substring(slash1+1, dateStr.length);
    var slash2 = dateMonthAndYear.indexOf("/");
    if (slash2 == -1) { slash2 = dateMonthAndYear.indexOf("-"); }
    // if not a second slash or dash, invalid date
    if (slash2 == -1) { return false; }
    var dateDay = dateMonthAndYear.substring(0, slash2);
    var dateYear = dateMonthAndYear.substring(slash2+1, dateMonthAndYear.length);
    if ( (dateMonth == "") || (dateDay == "") || (dateYear == "") ) { return false; }
    // if any non-digits in the month, invalid date
    for (var x=0; x < dateMonth.length; x++) {
      var digit = dateMonth.substring(x, x+1);
      if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text month to a number
    var numMonth = 0;
    for (var x=0; x < dateMonth.length; x++) {
      digit = dateMonth.substring(x, x+1);
      numMonth *= 10;
      numMonth += parseInt(digit);
    }
    if ((numMonth <= 0) || (numMonth > 12)) { return false; }
    // if any non-digits in the day, invalid date
    for (var x=0; x < dateDay.length; x++) {
      digit = dateDay.substring(x, x+1);
      if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text day to a number
    var numDay = 0;
    for (var x=0; x < dateDay.length; x++) {
      digit = dateDay.substring(x, x+1);
      numDay *= 10;
      numDay += parseInt(digit);
    }
    if ((numDay <= 0) || (numDay > 31)) { return false; }
    // February can't be greater than 29 (leap year calculation comes later)
    if ((numMonth == 2) && (numDay > 29)) { return false; }
    // check for months with only 30 days
    if ((numMonth == 4) || (numMonth == 6) || (numMonth == 9) || (numMonth == 11)) {
      if (numDay > 30) { return false; }
    }
    // if any non-digits in the year, invalid date
    for (var x=0; x < dateYear.length; x++) {
      digit = dateYear.substring(x, x+1);
      if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text year to a number
    var numYear = 0;
    for (var x=0; x < dateYear.length; x++) {
      digit = dateYear.substring(x, x+1);
      numYear *= 10;
      numYear += parseInt(digit);
    }
    // Year must be a 2-digit year or a 4-digit year
    if ( (dateYear.length != 2) && (dateYear.length != 4) ) { return false; }
    // if 2-digit year, use 50 as a pivot date
    if ( (numYear < 50) && (dateYear.length == 2) ) { numYear += 2000; }
    if ( (numYear < 100) && (dateYear.length == 2) ) { numYear += 1900; }
    if ((numYear <= 0) || (numYear > 9999)) { return false; }
    // check for leap year if the month and day is Feb 29
    if ((numMonth == 2) && (numDay == 29)) {
      var div4 = numYear % 4;
      var div100 = numYear % 100;
      var div400 = numYear % 400;
        // if not divisible by 4, then not a leap year so Feb 29 is invalid
        if (div4 != 0) { return false; }
        // at this point, year is divisible by 4. So if year is divisible by
        // 100 and not 400, then it's not a leap year so Feb 29 is invalid
        if ((div100 == 0) && (div400 != 0)) { return false; }
      }
    // date is valid
    return true;
  }
