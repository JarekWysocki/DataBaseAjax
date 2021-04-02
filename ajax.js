$(document).ready(function () {
  
  editData = (e) => {
    var target = $(e.target);
    var up = $(target.parent());
    var thisId = $(up[0]).children().attr('id');
    var change = e.target.id;
    switch (change) {
      case 'newFname':
      var newFname = prompt("Edit first name");
      break;
      case 'newLname' :
      var newLname = prompt("Edit last name"); 
      break;
      case 'newPass' :
      var newPass = prompt("Edit password"); 
      break; 
    }
    
    if (newFname || newLname || newPass) {
    $.ajax
    ({
      type: "POST",
      url: "controll.php", 
      data: {"thisId": thisId, "newFname": newFname, "newLname": newLname, "newPass": newPass, "choice" : "edit"},
      success: function (data) {
     getRecord();
     alert(data);
      }
    });
  }
  }
  deleteRecord = (e) => {
    $.ajax
    ({
      type: "POST",
      url: "controll.php",
      data: { "thisId": e.target.id, "choice" : "delete" },
      success: function (data) {
        getRecord();  
     alert(data);
      }
    });
  }
  sendRecord = (e) => {
    e.preventDefault();
    var formData = new FormData();
    formData.append("choice", e.target.id);
    formData.append("fname", $('#fname').val());
    formData.append("lname", $('#lname').val());
    formData.append("pass", $('#pass').val());
    formData.append("name", $("#image")[0].files[0]);
    $.ajax
      ({
        type: "POST",
        url: "controll.php",
        data: formData,
        processData : false,
        contentType : false,
        success: function (data) {
          $('input[type="text"]').val('');
          getRecord();
          alert(data);
        }
      });
  }
  getRecord = (e) => {
    $.ajax
    ({
      type: "POST",
      url: "controll.php",
      data: {"choice": "get"},
      success: function (data) {   
      data = JSON.parse(data);
      if ($('.data').length) {
      $(".data").remove();
      }
      if ($('.table').length == 0) {
        $('#demo').append('<table class="table"><tr><td>Id</td><td>Foto</td><td>Imie</td><td>Nazwisko</td><td>Hasło</td><td>Data utworzenia</td><td>Edycja</td></tr>');
      }
        data.forEach(function(atrb) {
         atrb.img ?
       $(".table").append('<tr class="data"><td> '+ atrb.id +'</td><td><img src="http://'+ window.location.hostname + '/img/' + atrb.img +'"></td><td>'+ atrb.fname + 
       '</td><td>'+ atrb.lname +'</td><td>'+ atrb.pass +'</td><td>'+ atrb.create + 
       '</td><td><span id="'+ atrb.id + 
       '" class="delete">Usuń</span></br><span id="newFname" class="editData">Edytuj imię</span></br><span id="newLname" class="editData">Edytuj nazwisko</span></br><span id="newPass" class="editData">Edytuj hasło</span></td></tr></table>'):
       $(".table").append('<tr class="data"><td> '+ atrb.id +'</td><td>Brak foto</td><td>'+ atrb.fname + 
       '</td><td>'+ atrb.lname +'</td><td>'+ atrb.pass +'</td><td>'+ atrb.create + 
       '</td><td><span id="'+ atrb.id + 
       '" class="delete">Usuń</span></br><span id="newFname" class="editData">Edytuj imię</span></br><span id="newLname" class="editData">Edytuj nazwisko</span></br><span id="newPass" class="editData">Edytuj hasło</span></td></tr></table>') ; 
      })
      $('.delete').on("click", deleteRecord);
      $('.editData').on("click", editData);
      }
      })
      }
  randomPass = (e) => {
    $.ajax
    ({
      type: "POST",
      url: "controll.php", 
      data: {"choice": e.target.id},
      success: function (data) {
        $('#pass').val(data);
      }
    });
    }

    $('#send').on("click", sendRecord);
    $('#get').on("click", getRecord);
    $('#random').on("click", randomPass);
})