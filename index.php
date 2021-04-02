<?php
$insert = false;
$update = false;
$delete = false;
$server = "localhost";
$username = "root";
$password = "";
$database = "notes";
// create a connection
$conn = mysqli_connect($server,$username,$password,$database);

//Die if connection was not successfull
if(!$conn){
  die("Sorry we failed to conect : " . mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql="DELETE FROM `notes` WHERE `sno`=$sno";
  $result = mysqli_query($conn, $sql);
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    //update for record
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $Description = $_POST["descriptionEdit"];
  
  // Sql query to be executed
  $sql = "UPDATE  `notes` SET `title`= '$title', `description`= '$Description' WHERE `notes` .`sno`=$sno";
  $result = mysqli_query($conn,$sql);
  if($result){
    $update = true;

  }
  else{
    echo"We not update the record successfully";
  }
  }
  else{
  $title = $_POST["title"];
  $Description = $_POST["Description"];

// Sql query to be executed
$sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title' ,'$Description')";
$result = mysqli_query($conn,$sql);
//Add a new trip to the trip table  in the database
if($result){
 // echo"The record has been inserted successfully<br>";
 $insert = true;
}
else{
  echo"The record has been not inserted successfully ".mysqli_error($conn);
}
}
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
     <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
     <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous.css"> -->
     <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>iNotes - Make Your Notes</title>
  </head>
  <body>
  <!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button> -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1"  role="dialog"aria-labelledby="editModalLable" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit This Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/crud/index.php" method="post">
      <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              
            </div>
           
            <div class="mb-3">
              <label for="desc" class="form-label">Note Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">iNotes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact us</a>
              </li>
            
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
      <?php
      if($insert){
       echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Success!</strong> Your note has been inserted successfully.
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
     </div>";
      }
      ?>
      <?php
      if($delete){
       echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Success!</strong> Your note has been deleted successfully.
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
     </div>";
      }
      ?>
      <?php
      if($update){
       echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Success!</strong> Your note has been updated successfully.
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
     </div>";
      }
      ?>
      <div class="container my-3 ">
          <h2>Add a Note to iNotes App</h2>
        <form action="/crud/index.php" method="post">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
              
            </div>
           
            <div class="mb-3">
              <label for="desc" class="form-label">Note Description</label>
              <textarea class="form-control" id="Description" name="Description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
      </div>
      <div class="container my-4">
       
        <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">sno</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn , $sql);
        $sno = 0;
        while($row = mysqli_fetch_assoc($result)){
          $sno = $sno+1;
          echo"<tr>
          <th scope = 'row'>" .  $sno. "</th>
          <td>". $row['title'] . "</td> 
          <td>". $row['description'] . "</td>
          <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id= d".$row['sno'].">Delete</button></td>
          </tr>";
        }
        ?>
    
   
  </tbody>
</table>
      </div>
      <hr>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  -->
     <script>
          $(document).ready( function () {
         $('#myTable').DataTable();
      } );
      </script>
      <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit ",);
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title, description);
          titleEdit.value = title;
          descriptionEdit.value = description;  
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
        })
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("delete ",);
          sno = e.target.id.substr(1,);
          // tr = e.target.parentNode.parentNode;
          // title = tr.getElementsByTagName("td")[0].innerText;
          // description = tr.getElementsByTagName("td")[1].innerText;
          if(confirm("Are you sure you want to delete this note!")){
            console.log("Yes");
            window.location = `/crud/index.php?delete=${sno}`;
          }
          else{
            console.log("No");
          }
          // console.log(title, description);
          // titleEdit.value = title;
          // descriptionEdit.value = description;  
          // snoEdit.value = e.target.id;
          // console.log(e.target.id);
          // $('#editModal').modal('toggle');
        })
      })
      </script>
  </body>
</html>