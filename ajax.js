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
    var formData = new FormData();
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var pass = $('#pass').val();
    var image = $("#image")[0].files[0];
    formData.append("fname", fname);
    formData.append("lname", lname);
    formData.append("pass", pass);
    formData.append("name", image);
    $.ajax
      ({
        type: "POST",
        url: "to_database.php",
        data: formData,
        processData : false,
        contentType : false,
        success: function (data) {
          $('input[type="text"]').val('');
          getRecord();
          alert("data send");
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
        $('#demo').append('<table class="table"><tr><td>Id</td><td>Foto</td><td>Imie</td><td>Nazwisko</td><td>Hasło</td><td>Data utworzenia</td><td>Edycja</td></tr>');
      }
        data.forEach(function(atrb) {
         
       $(".table").append('<tr class="data"><td> '+ atrb.id +'</td><td><img src="https://'+ window.location.hostname + '/img/' + atrb.img +'"</td><td>'+ atrb.fname + 
       '</td><td>'+ atrb.lname +'</td><td>'+ atrb.pass +'</td><td>'+ atrb.create + 
       '</td><td><span id="'+ atrb.id + 
       '" class="delete">Usuń</span></br><span id="newFname" class="editData">Edytuj imię</span></br><span id="newLname" class="editData">Edytuj nazwisko</span></br><span id="newPass" class="editData">Edytuj hasło</span></td></tr></table>');
       
      })
      $('.delete').on("click", deleteRecord);
      $('.editData').on("click", editData);
      
    })
  }
  randomPass = () => {
    $.get("randomPass.php", function(data) {
    $('#pass').val(data);
  }
    
    )}

    $('#send').on("click", sendRecord);
    $('#get').on("click", getRecord);
    $('#random').on("click", randomPass);
})