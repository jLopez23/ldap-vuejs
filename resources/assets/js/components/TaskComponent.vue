<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <button @click="initAddTask()" class="btn btn-primary btn-xs pull-right">
              + Add New Task
            </button>
          </div>
          <br>
          <div class="panel-body">
            <table class="table table-striped table-responsive" v-if="tasks.length > 0">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                <tr v-for="(task, index) in tasks">
                  <td>{{ index + 1 }}</td>
                  <td>{{ task.name }}</td>
                  <td>{{ task.description }}</td>
                  <td>
                    <button class="btn btn-success btn-xs" @click="initUpdate(index)">Edit</button>
                    <button class="btn btn-danger btn-xs" @click="deleteTask(index)">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <create-task @new="addTask"></create-task>
    <update-task  :update_task = "update_task"></update-task>
  </div>
</template>

<script>
export default {
  data(){
    return {
      errors: [],
      tasks: [],
      update_task: {}
    }
  },
  mounted()
  {
    this.readTasks();
  },
  methods: {
    initAddTask()
    {
      this.errors = [];
      $("#add_task_model").modal("show");
    },
    readTasks()
    {
      axios.get('/task')
      .then(response => {
        this.tasks = response.data.tasks
      });
    },
    addTask(task)
    {
      this.tasks.push(task);
    },
    initUpdate(index)
    {
      this.errors = [];
      $("#update_task_model").modal("show");
      this.update_task = this.tasks[index];
    },
    deleteTask(index)
    {
      let conf = confirm("¿Realmente quieres eliminar esta tarea?");
      if(conf === true)
      {
        axios.delete('/task/' + this.tasks[index].id)
        .then(response => {
          this.tasks.splice(index, 1);
        })
        .catch(error => {

        });
      }
    }
  }
}
</script>
