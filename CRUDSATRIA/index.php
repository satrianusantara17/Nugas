<?php
    //Koneksi Database
    $server = "lokalhost";
    $user = "root";
    $pass = "";
    $database = "dblatihan";

    $conn = mysqli_connect("localhost", "root", "", "dblatihan");

    if($conn){
        echo "koneksi berhasil";
    }else{
        echo "koneksi gagal". mysqli_connect_error();
        die();
    }

    //jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        //uji edit
        if ($_GET['hal'] == "edit")
        {
            
            //data edit
            $edit = mysqli_query($conn, "UPDATE tmhs set
                                            nim = '$_POST[tnim]',
                                            nama = '$_POST[tnama]',
                                            jurusan = '$_POST[tjurusan]'
                                        WHERE id_mhs = '$_GET[id]'
                                        ");
            if($edit) //jika edit sukses
            {
                echo "<script>
                alert('edit data sukses!');
                document.location='index.php';
                </script>";
            }
            else
            {
                echo "<script>
                alert('edit data gagal');
                document.location='index.php';
                </script>";
            }

        }
        else
        {

            //simpan baru
            $simpan = mysqli_query($conn, "INSERT INTO tmhs (nim, nama, jurusan)
                                          VALUES ('$_POST[tnim]', 
                                                 '$_POST[tnama]', 
                                                 '$_POST[tjurusan]')
                                          ");
            if($simpan) //jika simpan sukses
            {
                echo "<script>
                alert('simpan data sukses!');
                document.location='index.php';
                </script>";
            }
            else
            {
                echo "<script>
                alert('simpan data gagal');
                document.location='index.php';
                </script>";
            }

        }
        
    }

    //tombol edit
    if(isset($_GET['hal']))
    {
        if($_GET['hal'] == "edit")
        {
            $tampil = mysqli_query($conn, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $vjurusan = $data['jurusan'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //persiapan hapus data
            $hapus = mysqli_query($conn, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]'");
            if($hapus){
                echo "<script>
                alert('hapus data sukses!');
                document.location='index.php';
                </script>";
            }
        }
    }


?>

<!DOCTYPE html>
<html>
    <head>
        <title>CRUD SATRIA 18083000129</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
    <div class="container">


        <h1 class="text-center">uhuy</h1>

    <!-- Awal Card Form -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                Form Input Data Mahasiswa
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Nim</label>
                            <input type="text" name="tnim" value="<?=@$vnim?>" class="form-conrol" placeholder="Input Nim Anda Disini" required>
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="tnama" value="<?=@$vnama?>" class="form-conrol" placeholder="Input Nama Anda Disini" required>
                        </div>

                        <div class="form-group">
                            <label>Jurusan</label>
                            <select class="form-control" name="tjurusan">
                                <option value="<?=@$vjurusan?>"><?=@$vjurusan?></option>
                                <option value="D3-Sistem Informasi">D3-Sistem Informasi</option>
                                <option value="S1-Sistem Informasi">S1-Sistem Informasi</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                        <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
                    </form>
                </div>
        </div>
    <!-- Akhir Card Form -->

    <!-- Awal Card Tabel -->
    <div class="card mt-3">
            <div class="card-header bg-success text-white">
                Daftar Mahasiswa
                </div>
                <div class="card-body">
                    
                    <table class="table table-borderer table-striped"> 
                        <tr>
                            <th>No.</th>
                            <th>Nim</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                        <?php
                            $no = 1;
                            $tampil = mysqli_query($conn, "SELECT * from tmhs order by id_mhs desc");
                            while($data = mysqli_fetch_array($tampil)) :
                        
                        ?>
                        <tr>
                            <td><?=$no++;?>1</td>
                            <td><?=$data['nim']?></td>
                            <td><?=$data['nama']?></td>
                            <td><?=$data['jurusan']?></td>
                            <td>
                                <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning"> Edit </a>
                                <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm('apakah yakin ingin menghapus data ini?')" class="
                                   btn btn-danger"> Hapus </a>
                            </td>
                        </tr>
                    <?php endwhile; //penutup perulangan while ?>
                    </table>
                </div>
        </div>
    <!-- Akhir Card Tabel -->

    </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
