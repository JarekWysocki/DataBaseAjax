$(document).ready(function () {
  editData = (e) => {
    var target = $(e.target);
    var up = $(target.parent());
    var thisId = $(up[0]).children().attr('id');
    var change = e.target.id;
    switch (change) {
      case 'newFname':
      var newFname = prompt("Edytuj imię");
      break;
      case 'newLname' :
      var newLname = prompt("Edytuj nazwisko"); 
      break;
      case 'newPass' :
      var newPass = prompt("Edytuj hasło"); 
      break; 
    }
    
    if (newFname || newLname || newPass) {
    $.ajax
    ({
      type: "POST",
      url: "edit_data.php", 
      data: {"thisId": thisId, "newFname": newFname, "newLname": newLname, "newPass": newPass},
      success: function (data) {
     getRecord();
      }
    });
  }
  }
  deleteRecord = (e) => {
    var thisId = e.target.id;
    $.ajax
    ({
      type: "POST",
      url: "data_delete.php",
      data: { "thisId": thisId },
      success: function (data) {
        
     alert("Usuniete");
     getRecord();
      }
    });
  }
  sendRecord = (e) => {
    e.preventDefault()
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var pass = $('#pass').val();
    $.ajax
      ({
        type: "POST",
        url: "to_database.php",
        data: { "fname": fname, "lname": lname, "pass": pass },
        success: function (data) {
        $('input[type="text"]').val('');
       alert("Dane wysłane");
       getRecord();
        }
      });
  }
  getRecord = (e) => {
    $.get("from_database.php", function(data) {
      data = JSON.parse(data);
      if ($('.data').length) {
      $(".data").remove();
      }
      if ($('.table').length == 0) {
        $('#demo').append('<table class="table"><tr><td>Id</td><td>Imie</td><td>Nazwisko</td><td>Hasło</td><td>Data utworzenia</td><td>Edycja</td></tr>');
      }
        data.forEach(function(atrb) {
       let id = String(atrb[0]);
       var fname = String(atrb[1]);
       var lname = String(atrb[2]);
       var pass = String(atrb[3]);
       var create = String(atrb[4]);
       $(".table").append('<tr class="data"><td> '+ id +'</td><td>'+ fname + 
       '</td><td>'+ lname +'</td><td>'+ pass +'</td><td>'+ create + 
       '</td><td><span id="'+ id + 
       '" class="delete">usuń</span></br><span id="newFname" class="editData">Edytuj imię</span></br><span id="newLname" class="editData">Edytuj nazwisko</span></br><span id="newPass" class="editData">Edytuj hasło</span></td></tr></table>');
       
      })
      $('.delete').on("click", deleteRecord);
      $('.editData').on("click", editData);
    })
  }
    $('#send').on("click", sendRecord);
    $('#get').on("click", getRecord);
    
})