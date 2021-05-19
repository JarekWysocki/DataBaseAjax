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
      }
    });
  }
  sendRecord = (e) => {
    e.preventDefault();
    const regNick = /^.{3,20}$/;
    var nick = $("#fname").val();
    if (!regNick.test(nick)) {
     alert("Nick must have max 20 and min 3 signs");
     return false;
    }
    var email = $("#lname").val();
    const regMail = /^[a-z\d]+[\w\d.-]*@(?:[a-z\d]+[a-z\d-]+\.){1,5}[a-z]{2,6}$/i;
    if (!regMail.test(email)) {
    alert('Email is incorrect');
    return false;
    }
    var strongRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,20}$/; 
    var pass = $("#pass").val();
    if (!strongRegex.test(pass)) {
        alert('Passoword must have min 8 and max 20 characters, minimum 1  number and special character');
        return false;
      }
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
          if(data == 'Verify your registy on your email') {$(':input').val('')};
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
         atrb.img.split('.').pop() ?
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
      data: {"choice": "random"},
      success: function (data) {
        $('#pass').val(data);
      }
    });
    }
    log = (e) => {
      e.preventDefault();
      const regNick = /^.{3,20}$/;
    var nick = $("#logNick").val();
    var pass = $("#logPass").val();
    if (!regNick.test(nick) || !regNick.test(pass) ) {
     alert("Error login");
     return false;
    }
    
      var formData = new FormData();
      formData.append("choice", "log");
      formData.append("fname", $('#logNick').val());   
      formData.append("pass", $('#logPass').val());
    
      $.ajax
        ({
          type: "POST",
          url: "controll.php",
          data: formData,
          processData : false,
          contentType : false,
          success: function (data) {
          data == 'Error' || data == 'Confirm your email'? alert(data) : window.location = data; 
          }
        });
    }
    $('#send').on("click", sendRecord);
    $('#get').on("click", getRecord);
    $('#random').on("click", randomPass);
    $('#login').on("click", log);
})