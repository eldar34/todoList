//Шина событий

const eventEmmiter = new Vue();


//Компонент для создания задач (форма)

const CreateTask = {
    data() {
        return {
            tableTitle: ["UserId", "Name", "TotalFriends"],
            modalTitle: 'Create new task',
        }
    },
    template: `
    <!-- Modal -->
    <div id="exampleModalLong" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">{{ modalTitle.substr(0, 37) }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form @submit.prevent="onSubmit" id="createTaskForm" method="post"  action="">
          <div class="form-group row">
              <label for="staticName" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="staticName" name="staticName"  placeholder="name">
                  <div class="invalid-feedback">                               
                  </div>
              </div>
          </div>
          <div class="form-group row">
              <label for="createEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="createEmail" name="createEmail" aria-describedby="emailHelp" placeholder="name@example.com">
                  <div class="invalid-feedback">
                  </div>
              </div>                        
          </div>
          <div class="form-group row">
              <label for="staticTask" class="col-sm-2 col-form-label">Task</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="staticTask" name="staticTask"  placeholder="task">
                  <div class="invalid-feedback">
                  </div>
              </div>
          </div>
         
          
          <button class="btn btn-primary mb-2">Add</button>
      </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>       
          </div>
        </div>
      </div>
    </div> 

`,
    methods: {

        onSubmit() {
            //Добавление полей в формы в объект FormData() - передача файлов
            var userData = new FormData();
            userData.append('name', $('input[name="staticName"]').val());            
            userData.append('email', $('input[name="createEmail"]').val());
            userData.append('task', $('input[name="staticTask"]').val());

            $.ajax({
                type: 'POST',
                url: '/create-task',
                data: userData,
                processData: false,
                contentType: false,
                success: function (data) {

                    let result = JSON.parse(data);
                    
                    // Смена языка вывода ошибок
                    // let position = $('#langPosition').val();
                    let position = 0;
                    let errorCount = 0;
                    // console.log(result);
                    
                    //Отображение результатов валидации
                    result.forEach(function (item, i, arr) {
                        let gj = item.field;
                        if (item.status == 'error') {
                            errorCount++;
                            let fieldName = $('label[for*=' + gj + ']').text();

                            $('input[id*=' + gj + ']').removeClass('is-valid');
                            $('input[id*=' + gj + ']').addClass('is-invalid');
                            $('input[id*=' + gj + ']').next().text(fieldName + item.errors[position])
                        } else {
                            $('input[id*=' + gj + ']').removeClass('is-invalid');
                            $('input[id*=' + gj + ']').addClass('is-valid');
                        }

                    });

                    if (errorCount == 0) {
                        //Валидация прошла успешно
                        $('#regSuccess').text(
                            "New task is created"
                        );
                        $('#regSuccess').css("display", "block");
                        setTimeout(function () {
                            $('#regSuccess').fadeOut('slow');
                        }, 3000);
                        $('#exampleModalLong').modal('toggle');
                        // $('#exampleModalLong').hide();
                        //this.$router.push({ path: '/login' })
                    }

                }.bind(this),
                error: function (xhr, str) {
                    alert('Возникла ошибка: ' + xhr.responseCode);
                }
            });
        }
    },
    computed: {
        
    }
};


//Компонент для Авторизации (форма)

const LoginPage = {
    data() {
        return {
            tableTitle: ["UserId", "Name", "TotalFriends"],
            modalTitle: 'Login',
        }
    },
    template: `
    <!-- Modal -->
    <div id="exampleModalLogin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">{{ modalTitle.substr(0, 37) }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form @submit.prevent="onSubmit" id="signinForm" method="post" class="mt-5" action="">                   
                    
                <div class="form-group row">
                    <label for="staticEmailLogin" class="col-sm-5 col-form-label">Login</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="staticEmailLogin" name="staticEmailLogin" aria-describedby="emailHelp" placeholder="Login">
                        <div class="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>                        
                </div>
                <div class="form-group row">
                    <label for="inputPasswordLogin" class="col-sm-5 col-form-label">Password</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control" id="inputPasswordLogin" name="inputPasswordLogin" placeholder="password">
                        <div class="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>
                </div>

                    <input type="hidden" name="log_in">
                    <button class="btn btn-primary mb-2" name="log_in">Login</button>
                </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>       
          </div>
        </div>
      </div>
    </div> 
`,
    methods: {
        onSubmit() {
            var msg = $('#signinForm').serialize();

            $.ajax({
                type: 'POST',
                url: '/login',
                data: msg,

                success: function (data) {

                    let position = 0;                    
                    let errorCount = 0;
                    let result = JSON.parse(data);
                    // console.log('auth' in result);
                    // console.log(result);
                    if ('auth' in result) {
                        if (result.auth == 'login') {
                            //авторизация прошла успешно
                            eventEmmiter.$emit('loginTry');
                            $('#exampleModalLogin').modal('toggle');
                        } else {
                            // console.log(position);                        
                            
                            $('input[id*=staticEmailLogin]').removeClass('is-valid');
                            $('input[id*=staticEmailLogin]').addClass('is-invalid');
                            $('input[id*=staticEmailLogin]').next().text(result.errors[position])
                        }
                    } else {
                        result.forEach(function (item, i, arr) {
                            let gj = item.field;
                            if (item.status == 'error') {
                                errorCount++;
                                let fieldName = $('label[for*=' + gj + ']').text();

                                $('input[id*=' + gj + ']').removeClass('is-valid');
                                $('input[id*=' + gj + ']').addClass('is-invalid');
                                $('input[id*=' + gj + ']').next().text(fieldName + item.errors[position])
                            } else {
                                $('input[id*=' + gj + ']').removeClass('is-invalid');
                                $('input[id*=' + gj + ']').addClass('is-valid');
                            }

                        });
                    }

                }.bind(this),
                error: function (xhr, str) {
                    alert('Возникла ошибка: ' + xhr.responseCode);
                }
            });
        }
    },
    computed: {
        
    }
};

//Компонент для РедактированияЗадачи (форма)

Vue.component('update-task', {
    props: ['taskId', 'dataList'],
    template: `
    <!-- Modal -->
    <div id="updateTask" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateTask" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form @submit.prevent="onSubmit" id="updateTaskForm" method="post"  action="">
          <div class="form-group row">
              <label for="updateName" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="updateName" name="updateName"  placeholder="name" :value="dataList.name">
                  <input type="hidden" name="taskId"  :value="taskId">
                  <div class="invalid-feedback">                               
                  </div>
              </div>
          </div>
          <div class="form-group row">
              <label for="updateEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="updateEmail" name="updateEmail" aria-describedby="emailHelp" placeholder="name@example.com" :value="dataList.email">
                  <div class="invalid-feedback">
                  </div>
              </div>                        
          </div>
          <div class="form-group row">
              <label for="updateTask" class="col-sm-2 col-form-label">Task</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="updateTask" name="updateTask"  placeholder="task" :value="dataList.task">
                  <div class="invalid-feedback">
                  </div>
              </div>
          </div>
          <div class="form-group row">
                <label for="updateStatus" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                    <select id="updateStatus" class="form-control" id="updateStatus" name="updateStatus" >
                        <option selected>{{ dataList.status }}</option>
                        <option v-if="dataList.status == 'Complete'">New</option>
                        <option v-if="dataList.status == 'New'">Complete</option>
                    </select>                    
                    <div class="invalid-feedback">
                    </div>
                </div>
            </div>
          
         
          
          <button class="btn btn-primary mb-2">Update</button>
      </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>       
          </div>
        </div>
      </div>
    </div>                              
`,
methods: {
    onSubmit() {
        var msg = $('#updateTaskForm').serialize();

        $.ajax({
            type: 'POST',
            url: '/update-task',
            data: msg,

            success: function (data) {

                let position = 0;                    
                let errorCount = 0;
                let result = JSON.parse(data);
                //console.log('auth' in result);
                if ('auth' in result) {
                    $('#regSuccess').text(
                        result.errors
                    );
                    $('#regSuccess').css("display", "block");
                    setTimeout(function () {
                        $('#regSuccess').fadeOut('slow');
                    }, 3000);
                    $('#updateTask').modal('toggle');                    
                } else {
                        // console.log(result);
                        // Отображение результатов валидации                       
                        result.forEach(function (item, i, arr) {
                            let gj = item.field;
                            let anotherFields = ['taskId', 'staticDB'];

                            if (!anotherFields.includes(gj)){

                                if (item.status == 'error') {
                                    errorCount++;
                                    let fieldName = $('label[for*=' + gj + ']').text();                                  
    
                                    $('input[id*=' + gj + ']').removeClass('is-valid');
                                    $('input[id*=' + gj + ']').addClass('is-invalid');
                                    $('input[id*=' + gj + ']').next().text(fieldName + item.errors[position])

                                    // bad solution
                                    $('select[id*=' + gj + ']').removeClass('is-valid');
                                    $('select[id*=' + gj + ']').addClass('is-invalid');
                                    $('select[id*=' + gj + ']').next().text(fieldName + item.errors[position])
                                }else{

                                    $('input[id*=' + gj + ']').removeClass('is-invalid');
                                    $('input[id*=' + gj + ']').addClass('is-valid');

                                    // bad solution
                                    $('select[id*=' + gj + ']').removeClass('is-invalid');
                                    $('select[id*=' + gj + ']').addClass('is-valid');                                                                          
                                }
                            }
                        });

                        if (errorCount == 0) {
                            //Валидация прошла успешно
                            $('#regSuccess').text(
                                'Task with id - ' + result[5].field + ' udated successfully'
                            );
                            $('#regSuccess').css("display", "block");
                            setTimeout(function () {
                                $('#regSuccess').fadeOut('slow');
                            }, 3000);
                            $('#updateTask').modal('toggle');  
                        }
                    }                  

            }.bind(this),
            error: function (xhr, str) {
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
    }
},
computed: {
    
}
});


// Создаем экземпляр Vue

new Vue({
    el: '#app',
   
    data: {
        langVal: 0,
        guest: true,
        taskId: 1,
        dataList: {id: "1", name: "Bany", email: "bany@mail.com", task: "first", status: "New"},
        // Текущий индикатор сортировки
        sortCurrent: 'ASC',
        paramCurrent: 'id',
        // Группа переменных для сортировки полей (name, email, staus, id)
        paramName: 'name',
        typeName: 'ASC',
        paramEmail: 'email',
        typeEmail: 'ASC',
        paramStatus: 'status',
        typeStatus: 'ASC',
        paramId: 'id',
        typeId: 'ASC'
    },
    methods: {
        sortTask(fieldName, sortType){            
            // console.log(fieldName); 
            let protocolName = window.location.protocol;
            let hostPort = window.location.host;

            window.location.replace(protocolName + "//" + hostPort + "/pagination/1/" + fieldName + "/" + sortType);       
        },
        createTask(){            
            $('#exampleModalLong').modal();           
        },

        userLogin(){            
            $('#exampleModalLogin').modal();           
        },

        updateTask(taskId){  
            this.taskId = taskId; 
            $.ajax({
                type: 'POST',
                url: '/read-task',
                data: {taskId: taskId},
    
                success: function (data) {
                    
                    let result = JSON.parse(data);
                    if ('auth' in result) {
                        $('#regSuccess').text(
                            result.errors
                        );
                        $('#regSuccess').css("display", "block");
                        setTimeout(function () {
                            $('#regSuccess').fadeOut('slow');
                        }, 3000);                                         
                    }else{
                        
                        if(result[1].status == 'success'){
                            this.dataList = result[1].fields;
                            $('#updateTask').modal();
                        }else{
                            $('#regSuccess').text(
                                result[1].errors[1]
                            );
                            $('#regSuccess').css("display", "block");
                            setTimeout(function () {
                                $('#regSuccess').fadeOut('slow');
                            }, 3000); 
                        }
                        
                        
                    }                   
    
                }.bind(this),
                error: function (xhr, str) {
                    alert('Возникла ошибка: ' + xhr.responseCode);
                }
                
            });     
                       
        },

        deleteTask(deleteId){            
            let deleteTaskAnswer = confirm("Dlete task with id - " + deleteId + "?");
            if(deleteTaskAnswer){
                $.ajax({
                    type: 'POST',
                    url: '/delete-task',
                    data: {taskId: deleteId},
        
                    success: function (data) {
                        
                        let result = JSON.parse(data);
                        if ('auth' in result) {
                            $('#regSuccess').text(
                                result.errors
                            );
                            $('#regSuccess').css("display", "block");
                            setTimeout(function () {
                                $('#regSuccess').fadeOut('slow');
                            }, 3000);                                         
                        }else{
                            if(result[1].status == 'success'){
                                $('#regSuccess').text(
                                    'Task with id - ' + result[1].field + ' deleted successfully'
                                );
                                $('#regSuccess').css("display", "block");
                                setTimeout(function () {
                                    $('#regSuccess').fadeOut('slow');
                                }, 3000); 
                            }
                                                     
                        }                   
        
                    }.bind(this),
                    error: function (xhr, str) {
                        alert('Возникла ошибка: ' + xhr.responseCode);
                    }
                    
                }); 
            }          
        },

        logout() {
            $.ajax({
                type: 'GET',
                url: '/logout',
                data: { action: 'out' },

                success: function (data) {
                    let result = JSON.parse(data);
                    // console.log(result);
                }.bind(this),
                error: function (xhr, str) {
                    alert('Возникла ошибка: ' + xhr.responseCode);
                }
            });
            this.guest = true;
            // this.$router.push({ path: '/' });
        }
       
    },
    components: {
        'add-task': CreateTask,
        'login': LoginPage
        
    },
    created() {
        eventEmmiter.$on('loginTry', () => {
            this.guest = false;
        }); 
        

        // Начало сортировки полей
        
        if (window.location.href.includes('pagination'))
        {
            let testArray = window.location.href.split("/");
            let sortParam = testArray[5]; 
            let sortType = testArray[6];
            this.sortCurrent = sortType;
            this.paramCurrent = sortParam;
            
            if(sortParam == 'name' && sortType == 'ASC'){
                this.typeName = 'DESC'
            }
            else if(sortParam == 'name' && sortType == 'DESC'){
                this.paramName = 'id'
                this.typeName = 'ASC'
            }

            if(sortParam == 'status' && sortType == 'ASC'){
                this.typeStatus = 'DESC'
            }
            else if(sortParam == 'status' && sortType == 'DESC'){
                this.paramStatus = 'id'
                this.typeStatus = 'ASC'
            }

            if(sortParam == 'email' && sortType == 'ASC'){
                this.typeEmail = 'DESC'
            }
            else if(sortParam == 'email' && sortType == 'DESC'){
                this.paramEmail = 'id'
                this.typeEmail = 'ASC'
            }

            if(sortParam == 'id' && sortType == 'ASC'){
                this.typeId = 'DESC'
            }
            else if(sortParam == 'id' && sortType == 'DESC'){
                this.paramId = 'id'
                this.typeId = 'ASC'
            }
        }

        // Конец сортировки полей
            
    },
    beforeCreate: function () {
        $.ajax({
            type: 'POST',
            url: '/user-auth',

            success: function (data) {
                let result = JSON.parse(data);
                if (result.auth == 'login') {
                    this.guest = false;
                    // console.log(result)
                } else {
                    // console.log(result)
                }
            }.bind(this),
            error: function (xhr, str) {
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
        
    }
});