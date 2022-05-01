<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
       <?php include "style.css" ?>
    </style>
    <title>To Do List</title>
</head>
<body >
    
    <!-- connect Database -->
    <?php
    $warning ="";
    $db = mysqli_connect("localhost", "root", "", "todo");

    //save tasks
    if(isset($_POST['submit'])) {
       if(empty(test_input($_POST['task']))){
         $warning = "Please fill in your task!";
       }else{
         $task = $_POST["task"]; 
         $sql = "INSERT INTO tasks (task) VALUES ('$task')";
         mysqli_query($db, $sql);
         header("location: index.php");
       }
    }

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //delete tasks
    if(isset($_GET["del_task"])){
       $id = $_GET["del_task"];

       mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
       header("location: index.php");
    }
    ?>

    <div class="layout">
      <div class="container">
        <h1 class="title">To Do List</h1>
        <form method="post" action="index.php" class="input-form">
           <div class=task-area>
               <input type="text" name="task" class="task-input">
               <button type="submit" name = "submit"  class="add-btn">
                   <span>Add Task</span>
                   <div id="translate"></div>
                </button>
           </div>
           <?php if (isset($warning)) { ?>
              <p class="warning"><?php echo $warning; ?></p>
           <?php }?> 
        </form>
        <table>
            <thead>
                <tr>
                  <th style="width:8%">N</th>
                  <th style="width:calc(92% - 60px)">Task</th>
                  <th style="width: 60px;">Action</th> 
                </tr>
           </thead>
           <tbody>
                <?php
                $tasks = mysqli_query($db, "SELECT * FROM tasks");

                $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td class="task"><?php echo $row["task"]; ?></td>
                        <td class="delete">
                            <a href="index.php?del_task=<?php echo $row["id"] ?>">x</a>
                        </td>
                    </tr>
                <?php $i++;} ?>
           </tbody>
        </table>
      </div>
    </div>




</body>
</html>