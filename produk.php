<?php
    error_reporting(1);
    header('Content-type: application/json; charset=utf8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,OPTIONS');
    header('Access-Control-Allow-Methods: Content-Type,Content-Range,Content-Disposition,Content-Description');
    
    include('db.php');

    
	//Definisikan Token
	define('ClientID','85f8647514401c6ba3dc58eafeed1ef2');
	define('ClientSecret','01c4bf6ba816ef53c34e057af258f76f');
	$token=base64_encode(ClientID.":".ClientSecret);
	$action=$_REQUEST['act'];
	$requestHeaders = apache_request_headers();
	$Authorization = trim($requestHeaders['Authorization']);

		if (isset($Authorization)) 
		{
			list($type, $data) = explode(" ", $Authorization, 2);	
			if (strcasecmp($type, "Bearer") == 0) 
			{
				if($data!=$token)
				{
					echo '{"error":"Token Salah","statusEror":"1"}';
					exit();
				}
			}else 
			{
				echo '{"error":"Tipe Auth Tidak Diketahui","statusEror":"1"}';
				exit();
			}
		}else 
		{
			echo '{"error":"Auth diperlukan - '.$Authorization.'","statusEror":"1"}';
			exit();
		}

    $param=$_GET['param'];
    $v=$_GET['v'];

	
    
    $sql = $conn->query('SELECT * FROM `kt_barang` ');

    $res = array();
    while ($kat = mysqli_fetch_array($sql)) {
        $id =  $kat['id_kat'];
        $nm = $kat['nama_kategori'];
        $res[$nm] = [];
        if($param == '')
        {
            $data = $conn->query("SELECT * FROM tb_produk WHERE id_barang = $id");
        }elseif($param <> '')
        {
            $data = $conn->query("SELECT * FROM tb_produk WHERE id_barang = $id AND $param LIKE '%$v%' ");
        }
        while($p = mysqli_fetch_array($data)){
            $i =  $p['attribut'];
            $attr = $conn->query("SELECT * FROM  tb_attr WHERE id_produk = $i ");
            while($d = mysqli_fetch_array($attr)){
                $f['merk'] = $d['merk'];
                $f['warna'] = $d['warna'];
            }
            
            $r['id'] = $p['id'];
            $r['id_barang'] = $p['id_barang'];
            $r['kat_barang'] = $kat['nama_kategori'];
            $r['kat_produk'] = $p['kat_produk'];
            $r['nm_barang'] = $p['nm_barang'];
            $r['deskripsi'] = $p['deskripsi'];
            $r['berat'] = $p['berat'];
            $r['harga'] = $p['harga'];
            $r['qty'] = $p['qty'];
            $r['attribut'] = $f;


            array_push($res[$nm], $r);

        }
    }

    echo json_encode($res);

?>