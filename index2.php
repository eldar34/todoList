<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <!-- <link href="/assets/font/css/all.css" rel="stylesheet"> -->
    <title>Document</title>
</head>

<body>

<?php

use App\Pagination;

$sortFields = ['name', 'status', 'email', 'id'];
$pagination = new Pagination(3, 'tasks', $sortFields);
$page = $pagination->get_page();
$result = $pagination->get_page_content();

?>

<div class="container">

<div id="app">

        <div class="row justify-content-center mt-5">
        
            
            
        

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">TodoList</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav">
                    <li class="nav-item active">
                      <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                      <a @click="createTask" class="nav-link" style="cursor: pointer">Add</a>
                    </li>

                    <li v-if="guest" class="nav-item">
                      <a @click="userLogin" class="nav-link" style="cursor: pointer">Login</a>
                    </li>
                    <li v-else class="nav-item">
                      <a @click="logout" class="nav-link" style="cursor: pointer">Logout(admin)</a>                      
                    </li>      
                  </ul>
                </div>
              </nav>
              
              
              <add-task></add-task>
              <login></login>
              <update-task :task-id='taskId' :data-list="dataList"></update-task>

          

            </div>

            <div class="row justify-content-center mt-5">
              <div id="regSuccess" style="display: none;" class="alert alert-success" role="alert">
                  This is a success alert—check it out!
              </div>
            </div>
            
            
            <br>

            <div class="row">

            <table class="table">
                <thead>
                  <tr>
                    <th scope="col"><a @click="sortTask(paramId, typeId)" style="cursor: pointer">#</a></th>                    
                    <th scope="col">
                      <a @click="sortTask(paramName, typeName)" style="cursor: pointer">
                        Name 
                        <i v-if="paramCurrent == 'name' && sortCurrent == 'ASC'">&#8595;</i>
                        <i v-if="paramCurrent == 'name' && sortCurrent == 'DESC'">&#8593;</i>
                      </a>
                    </th>
                    <th scope="col">
                      <a @click="sortTask(paramEmail, typeEmail)" style="cursor: pointer">
                        Email
                        <i v-if="paramCurrent == 'email' && sortCurrent == 'ASC'">&#8595;</i>
                        <i v-if="paramCurrent == 'email' && sortCurrent == 'DESC'">&#8593;</i>
                      </a>
                    </th>
                    <th scope="col">Task</th>
                    <th scope="col">
                      <a @click="sortTask(paramStatus, typeStatus)" style="cursor: pointer">
                        Status
                        <i v-if="paramCurrent == 'status' && sortCurrent == 'ASC'">&#8595;</i>
                        <i v-if="paramCurrent == 'status' && sortCurrent == 'DESC'">&#8593;</i>
                      </a>
                    </th>
                    <th v-if="!guest" scope="col">Actions</th>                      
                  </tr>
                </thead>
                <tbody>
                
<?php

$records = $result['records'];
$number_of_pages = $result['number_of_pages'];


while($myrow = $records->fetch()){
  
   printf("
    <tr>
    
    <th scope='row'>%s</th>
    <td>%s</td>
    <td>%s</td>
    <td>%s</td>
    <td>%s <i v-if='%s == 1'>&#169;</i></td>
    <td v-if='!guest'>
      <a @click='updateTask(%s)'  style='cursor: pointer'><img src='/assets/img/pencil.png'/></a>
      <a @click='deleteTask(%s)' style='cursor: pointer'><img src='/assets/img/trash.png'/></a>
    </td>
    </tr>
    ", $myrow['id'], $myrow['name'], $myrow['email'], $myrow['task'], $myrow['status'], $myrow['updated_by'], $myrow['id'], $myrow['id']);
     
}

?>

</tbody>
</table>

<nav aria-label="Page navigation example">
  <ul class="pagination">
<?php
    $sort_params = $pagination->get_sort_param();
    $sort_type = $pagination->get_sort_type();
    for($page=1;$page<=$number_of_pages;$page++){

    echo '<li class="page-item"><a class="page-link" href="index.php?page='. $page .'&sort_param='. $sort_params . '&sort_type=' . $sort_type .'">' . $page . '</a></li>';
    }
?>
    </ul>
</nav>
</div>
</div>
</div>
<script type="text/javascript" src="assets/js/jquery-3.4.1.js"></script>    
<script type="text/javascript" src="assets/js/vue.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="assets/js/components.js"></script>
</body>
</html>