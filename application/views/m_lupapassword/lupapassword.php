<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ganti Password RIDE</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

  <nav class="navbar navbar-light" style="background-color: #2CBD92;text-align: center; color: white">
    <h3>
      RIDE
    </h3>
  </nav>
<div class="container">
  <input type="hidden" id="code" value="<?= $data['code'] ?>">
  <div class="col-md-12">
    <div class="card border-primary mb-3" style="max-width: 18rem;">
      <div class="card-header">Your Active Card : </div>
      <div class="card-body">
        <h5 class="card-title"><?= $data['code'] ?></h5>
      </div>
    </div>
  </div>
  <div class="col-md-12" id = "lay1">
    <div class="form-group">
       <label for="exampleInputPassword1">Masukkan Password Baru :</label>
       <input type="password" class="form-control" id="passwordbaru" placeholder="Password Baru">
     </div>
  </div>
  <div class="col-md-12" id = "lay2">
    <div class="form-group">
      <label for="exampleInputPassword1">Ulangi Password Baru :</label>
      <input type="password" class="form-control" id="ulangipassword" placeholder="Ulangi Password">
    </div>
  </div>
  <div class="col-md-12" style="text-align: center">
    <button type="button" id="btn" class="btn btn-primary btn-lg">Ubah Password</button>
  </div>
  <div id="tunggu" class="col-md-12" style="text-align: center">

  </div>
</div>
</div>
</body>
</html>

<script>
$( document ).ready(function() {
  $( "#btn" ).click(function() {
    var password = $("#passwordbaru").val();
    var ulangipassword = $("#ulangipassword").val();
    var code = $("#code").val();

    if(password == ""){
      alert("Isi terlebih dahulu passwordnya")
    } else if(password == ulangipassword){
      $.ajax({
        method: "GET",
        beforeSend: function() {
          $( "#btn" ).hide();
          $( "#tunggu" ).html("Tunggu...");
        },
        url: "api/login/updateLupaPassword?password="+password+"&code="+code,
        data: {}
      }).done(function(result) {
        $( "#btn" ).show();
        $( "#tunggu" ).html("");
        var status = JSON.parse(result);
        if(status.status == "success"){
          alert(status.message);
          window.close();
        } else {
          alert(status.message);
        }
        // $("#loading").fadeOut();
        // this.datas = result;
        // console.log(this.datas);
        // setTokoFromService(JSON.parse(this.datas), "", "");
        // makeTokoMap(JSON.parse(this.datas));
      });
    } else {
      alert("Password yang Anda isi belum sama")
    }
  });
});
</script>
