<?php
// url DESIGN :
// localhost/api-native/api.php?function=getUsers

require_once "koneksi.php";

if(function_exists($_GET['function'])){
    $_GET['function']();
}

// untuk menampilkan data
function getUsers(){

    // permintaan ke server
    global $koneksi;
    $query = mysqli_query($koneksi, "SELECT * FROM users");
    while($data = mysqli_fetch_object($query)){
        $users[] = $data;
    }

    // menghasilkan response server
    $respon = array(
        'status'  => 1,
        'message' =>'success get users',
        'users'   => $users   
    );

    // menampilkan data JSON
    header('content-Type: application/json');
    print json_encode($respon);
}

// insert data user
 function addUser(){
  
     global $koneksi;
     $parameter = array(
         'nama'   => '',
         'alamat' => ''
     );
     $cekData = count(array_intersect_Key($_POST, $parameter));

     if($cekData == count($parameter)){

         $nama =$_POST['nama'];
         $alamat =$_POST['alamat'];


         $result =mysqli_query($koneksi, "INSERT INTO users VALUES('', '$nama', '$alamat')");

         if($result){
             return message(1, "insert data $nama success");
         }else{
            return message(0, "insert data failed");
         }

        }else{
            return message(0, "parameter salah");
        }
}

 function message($status, $msg){

     $respon = array(
         'status'   =>$status,
         'message'   =>$msg
     );

    // menampilkan data dalam betuk json
     header('Content-Type: application/json');
     print json_encode($respon);
 }
//update data user
//URL DESAIGN update data user
//localhost/api-native/api.php?function=updateUser&id={id}

function updateUser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id =$_GET['id'];
    }

    $parameter = array(
        'nama' => "",
        'alamat' =>""
    );
 //fungsi array_intersect_key() berfungsi untuk membandingkan kunci dari dua atau lebih array, dan mengembalikann kecocokan
    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count ($parameter)){
        $nama =$_POST['nama'];
        $alamat=$_POST['alamat'];

        $result= mysqli_query($koneksi, "UPDATE users SET nama='$nama', alamat ='$alamat' WHERE id='id' ");

        if($result){
            return message(1, "Update data $nama succes");
        }else{
            return message(0, "update data failded");
        }
    
    }else{
        return message(0, "parameter sallah" );
    }
}  


// delete data user
// URL DESIGN delete data user:
// localhost/api-native/api.php?function=deleteUser&id={id}
function deleteuser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $result =mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    if($result){
        return message(1, "delete data succsess");
    }else{
        return message(0, "delete data failed");
    }

}

// detail data user per id
// URL DESIGN detail data user per id:
// localhost/api-native/api.php?function=detailUserId&id={id}

function detailUserId(){
    global $koneksi;
    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $result =$koneksi->query("SELECT * FROM users WHERE id='$id'");

    while($data = mysqli_fetch_object($result)){
        $detailUser[] =$data;
    }

    if($detailUser){
        $respon =array(
            'status'  =>1,
            'message' =>"berhasil mendapatkan data detail user",
            'user'    => $detailUser
        );
    }else{
        return message(0, "Data tidak ditemukan");
    }

    // Menampilkan Data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);
}
?>