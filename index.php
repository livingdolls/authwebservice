<?php 
  session_start();

  if(isset($_POST['submit'])){
    $token = $_POST['token'];

    $_SESSION['token'] = $token;
  }

  if(isset($_POST['delet'])){ 
      session_unset();
      session_destroy();
  }
  
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous"></script>
    <title>Web Service Auth</title>
  </head>
  <body class="container">

  <p class="bg bg-info p-1">Token = ODVmODY0NzUxNDQwMWM2YmEzZGM1OGVhZmVlZDFlZjI6MDFjNGJmNmJhODE2ZWY1M2MzNGUwNTdhZjI1OGY3NmY=</p>

    <form action="" method="post">
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Masukkan Token Untuk Menampilkan Data</label>
        <textarea class="form-control" name="token" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
        <button type="submit" class="btn btn-sm btn-primary" name="submit">Enter</button>
        <form action="" method="post">
          <button type="submit" class="btn btn-sm btn-danger" name="delet">Delete Token</button>
        </form>
    </form>

    <br>

    <script type="text/javascript">
        $.ajax({
        url: 'produk.php',
        success: function(json) {
            if(json.statusEror == 1){
              $('#warning').html("<i class='bg bg-warning'>"+json.error+"</i>")
            }
            else
            {
              $('#warning').remove();
              $.each(json, function(i){
                json[i].forEach(a => {
                document.getElementById("produk").innerHTML +=
                    "<tr><td>"+ a.id + 
                    "</td><td>" + a.kat_barang + 
                    "</td><td>" + a.kat_produk +
                    "</td><td>" + a.nm_barang +
                    "</td><td>" + a.deskripsi +
                    "</td><td>" + a.berat +
                    "</td><td>" + a.harga +
                    "</td><td>" + a.qty +
                    "</td><td><ul class='list-group'><li class='list-group-item'> Merk : " + a.attribut.merk +
                    "</li><li class='list-group-item'>Warna : " + a.attribut.warna +
                    "</li></ul></td></tr>";
                });
            })
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus, errorThrown);
        },
        beforeSend: function (xhr) {
          xhr.setRequestHeader ("Authorization", "Bearer " + '<?= $_SESSION['token']; ?>');
        },
        type: 'GET',
        contentType: 'json',
    });
    </script>

<div class="">
    <p id="warning"></p>
    <table id="myProduk" class="table border table-striped">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Kategori Barang</th>
            <th scope="col">Kategori Produk</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Berat</th>
            <th scope="col">Harga</th>
            <th scope="col">Qty</th>
            <th scope="col">Attribut</th>
          </tr>
        </thead>
        <tbody id="produk">
        </tbody>
      </table>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
  </body>
</html>
