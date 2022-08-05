<?php
require_once 'db.php';
$db = new Database();

if(isset($_POST['login'])) {
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $pwd = trim($_POST['password']);
        $login = $db->login($username, $pwd);
        if($login) {
            $_SESSION['user'] = $_POST['username'];
            header("location: dashboard.php");
        }
        else {
            $message = 'Username or Password wrong!';
            header("location: index.php?err=$message");
        }
    }
}
if(isset($_POST['signup'])) {
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {
        $username = trim($_POST['username']);
        $pwd = trim($_POST['password']);
        $pwdcnf = trim($_POST['confirm-password']);
        if($pwd == $pwdcnf) {
            $sign = $db->register($username, $pwd);
            if($sign) {
                $_SESSION['user'] = $username;
                header("location: dashboard.php");
            } else {
                $message = 'Something went wrong please try again!';
                header("location: signup.php?err=$message");
            }
        }
        else {
            $message = 'Password and confirmation doesnt match!';
            header("location: signup.php?err=$message");
        }
    }
}

if(isset($_POST['action']) && $_POST['action'] == "view") {
    $output = '';
    $data = $db->read();
    if($db->totalRowCount()>0) {
        $output .= '
        <table class="table table-striped table-sm table-border">
        <thead>
            <tr class="text-center">
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';
        $i = 0;
        foreach($data as $row) {
            $i++;
            $output .= '<tr class="text-center text-secondary">
                        <td>' .$i .'</td>
                        <td>' .$row['prenom'] .'</td>
                        <td>' .$row['nom'] .'</td>
                        <td>' .$row['email'] .'</td>
                        <td>
                            <a href="#" title="View details" class="text-success viewbtn" id="'.$row['id'].'"><i class="fas fa-info-circle fa-lg mr-3 "></i> </a>&nbsp;&nbsp;
                            <a href="#" title="Edit info" class="text-primary editbtn" id="'.$row['id'].'"><i class="fas fa-edit fa-lg mr-3"  data-toggle="modal" data-target="#editmodal"></i> </a>&nbsp;&nbsp;
                            <a href="#" title="Delete" class="text-danger delbtn" id="'.$row['id'].'"><i class="fas fa-trash-alt fa-lg mr-3"></i> </a>&nbsp;&nbsp;
                        </td></tr>        
            ';
        }
        $output .= '</tbody></table>';
        echo $output;
    }else {
        echo '<h3 class="text-center text-secondary mt-5">Please add students </h3>';
    }
}
if(isset($_POST['action']) && $_POST['action'] == "insert") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $db->insert($fname,$lname,$email);
}
if(isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $row = $db->getStudentsById($id);
    echo json_encode($row);
}
if(isset($_POST['action']) && $_POST['action'] == "update") {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $db->update($id,$fname,$lname,$email);
}
if(isset($_POST['del_id'])) {
    $id = $_POST['del_id'];
    $db->delete($id);
}

if(isset($_POST['info_id'])) {
    $id = $_POST['info_id'];
    $row = $db->getStudentsById($id);
    echo json_encode($row);
}
?>