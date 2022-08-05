<?php 
session_start();
if(isset($_SESSION['user'])): ?>
<?php require_once "../Userspace/includes/header.php" ?>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="#">User space</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log out</a>
            </li>
        </ul>
</nav>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="text-center text-danger font-weight-normal my-3">Welcome to dashboard!</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <h4 class="mt-2 text-primary">Your students</h4>
        </div>
        <div class="col-lg-6">

            <button class="btn btn-primary m-1 float-right" type="button" data-toggle="modal" data-target="#addmodal"><i class="mr-3 fas fa-user-plus fa-lg"></i>Add New Student</button>
            <a href="#" class="btn btn-success m-1 float-right"><i class="fas fa-table mr-3 fa-lg"></i>Export to excel</a>
        </div>
    </div>
    <hr class="my-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive" id="showStudents">

            </div>
        </div>
    </div>
</div>
<div class="container">
<!-- Add user -->
    <div class="modal fade" id="addmodal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add student</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                    <form action="" method="POST" id="form-data">
                        <div class="form-group">
                            <input type="text" name="fname" class="form-control" placeholder="First name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="lname" class="form-control" placeholder="Last name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <input type="submit" name="insert" id="insert" value="Add student" class="btn btn-danger btn-block">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit user -->
    <div class="modal fade" id="editmodal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit student</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body px-4">
                    <form action="" method="POST" id="edit-form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <input type="text" name="fname" class="form-control" id="fname" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="lname" class="form-control" id="lname" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                        <input type="submit" name="update" id="update" value="update informations" class="btn btn-primary btn-block">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "../Userspace/includes/footer.php" ?>

<script>
$(document).ready(function() {
    showAllStudents();
    function showAllStudents() {
        $.ajax({
            url: "action.php",
            type: "POST",
            data: {action:"view"},
            success:function(response) {
                $("#showStudents").html(response)
            }
        });
    }
    //insert ajax request
    $("#insert").click(function(e) {
        if($("#form-data")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url : "action.php",
                type: "POST",
                data: $("#form-data").serialize()+"&action=insert",
                success:function(response) {
                    $("#addmodal").modal('hide');
                    swal.fire({
                        title: 'Student added successfully!',
                        icon: 'success',
                    }) 
                    $("#form-data")[0].reset();
                    showAllStudents();
                }
            });
        }
    });
    //edit student
    $("body").on("click" , ".editbtn",function(e){
        e.preventDefault();
        edit_id = $(this).attr('id');
        $.ajax({
            url:"action.php",
            type:"POST",
            data:{edit_id:edit_id},
            success:function(response) {
                data = JSON.parse(response);
                $("#id").val(data.id);
                $("#fname").val(data.prenom);
                $("#lname").val(data.nom);
                $("#email").val(data.email);
            }
        })
    });
     //update ajax request
    $("#update").click(function(e) {
        if($("#edit-form-data")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url : "action.php",
                type: "POST",
                data: $("#edit-form-data").serialize()+"&action=update",
                success:function(response) {
                    $("#editmodal").modal('hide');
                    swal.fire({
                        title: 'Student Updated successfully!',
                        icon: 'success',
                    }) 
                    $("#edit-form-data")[0].reset();
                    showAllStudents();
                }
            });
        }
    });
    //delete ajax request
    $("body").on("click", ".delbtn", function(e) {
        e.preventDefault();
        var tr = $(this).closest('tr');
        del_id = $(this).attr('id');
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "action.php",
                type:"POST",
                data:{del_id:del_id},
                success:function(response){
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    tr.css('background-color' , '#ff6666');
                    showAllStudents();
                }
            })
        }
        })
    })
    //show student details
    $("body").on("click" , ".viewbtn", function(e) {
        e.preventDefault();
        info_id = $(this).attr('id');
        $.ajax({
            url:'action.php',
            type:'POST',
            data:{info_id:info_id},
            success:function(response) {
                //console.log(response);
                data = JSON.parse(response);
                swal.fire({
                    title:'<strong>Student Info : ID('+data.id + ')</strong>',
                    icon: 'info',
                    html: ' <b>First name : </b>'+data.prenom+'</br>'+
                        '   <b>Last name : </b>' +data.nom+'</br>'+
                        '   <b>Email : </b>' +data.email+'</br>'
                    
                    
                })
            }
        })
    })
});
</script>
</body>
</html>
<?php endif ?>
<?php if(!isset($_SESSION['user'])) {
    header('location: index.php');
}
?>
