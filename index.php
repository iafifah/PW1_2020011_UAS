<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "db_stock";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak dapat terhubung");
}

$kode       = "";
$nama     = "";
$quantity     = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from stock where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Data Terhapus";
    }else{
        $error  = "Gagal Terhapus";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from stock where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $kode        = $r1['kode'];
    $nama       = $r1['nama'];
    $quantity     = $r1['quantity'];

    if ($kode == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { 
    $kode        = $_POST['kode'];
    $nama       = $_POST['nama'];
    $quantity     = $_POST['quantity'];

    if ($kode && $nama && $quantity) {
        if ($op == 'edit') { 
            $sql1       = "update stock set kode= '$kode', nama='$nama',quantity = '$quantity' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = " Data diupdate";
            } else {
                $error  = "Gagal diupdate";
            }
        } else { 
            $sql1   = "insert into stock(kode,nama,quantity) values ('$kode','$nama','$quantity')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Tersimpan";
            } else {
                $error      = "Gagal Tersimpan";
            }
        }
    } else {
        $error = "Data yang dimasukkan tidak benar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body >
<div style="border: none ; outline:none; max-width: 300px; border-radius: 10px; 
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.125); height: 100%; padding-bottom:30px; background: #fff; margin: 50px auto;">
    <h5 style="padding-top: 30px; color: #2438a6; text-align: center; font-size: 18px;"
            >Menambahkan Barang Baru</h5>
 <div>
    <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:4;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:4;url=index.php");
                }
    ?>
    <form action="" method="POST">

            <input placeholder="Kode Barang" style="border: 1px solid #2438a6; border-radius: 8px; outline: none; height: 35px;
               text-align: left; padding-left: 20px;  width: 75%; margin: 5px 50px; "
               type="text" id="kode" name="kode"  value="<?php echo $kode ?>">

            <input placeholder="Nama Barang" style="border: 1px solid #2438a6; border-radius: 8px; outline: none; height: 35px;
               text-align: left; padding-left: 20px;  width: 75%; margin: 5px 50px; "
               type="text" id="nama" name="nama" value="<?php echo $nama ?>">

            <input placeholder="Quantity" style="border: 1px solid #2438a6; border-radius: 8px; outline: none; height: 35px;
               text-align: left; padding-left: 20px;  width: 75%; margin: 5px 50px; "
               type="text" id="quantity" name="quantity" value="<?php echo $quantity ?>">      
               
        
        <br><br>
         <div class="col-12">
         <input style="margin-left: 50px;" type="submit" name="simpan" value="Simpan" class="btn btn-primary" />
         </div>
    </form>

 </div>
</div>
<div style="border: none ; outline:none; width: 100%; border-radius: 10px; 
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.125); height: 100%; padding-bottom:30px; background: #fff; margin: 50px auto;">
    <h5 style="padding-top: 30px; color: #2438a6; text-align: center; font-size: 18px;"
            >Barang Baru</h5>            
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nomor</th>
                            <th scope="col">KODE BARANG</th>
                            <th scope="col">NAMA BARANG</th>
                            <th scope="col">QUATITY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from stock order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id          = $r2['id'];
                            $kode        = $r2['kode'];
                            $nama        = $r2['nama'];
                            $quantity       = $r2['quantity'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $kode ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $quantity ?></td> 
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Ubah</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Hapus Data?')"><button type="button" class="btn btn-danger">Hapus</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
</div>
</body>
</html>
