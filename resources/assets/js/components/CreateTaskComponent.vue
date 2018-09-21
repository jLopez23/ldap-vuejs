<template>
<div class="modal fade" tabindex="-1" role="dialog" id="add_task_model">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
          aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add New Task</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" v-if="errors.length > 0">
            <ul>
              <li v-for="error in errors">{{ error }}</li>
            </ul>
          </div>
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Task Name" class="form-control"
            v-model="task.name">
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" cols="30" rows="5" class="form-control"
            placeholder="Task Description" v-model="task.description"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" @click="createTask" class="btn btn-primary">Submit</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  </template>

  <script>
  export default {
    data(){
      return {
        task: {
          name: '',
          description: ''
        },
        errors: []
      }
    },
    methods: {
      createTask()
      {
        axios.post('/task', this.task)
        .then(response => {
          this.reset();
          this.$emit('new',response.data.task);
          $("#add_task_model").modal("hide");

        })
        .catch(error => {
          this.errors = [];
          if (error.response.data.errors.name) {
            this.errors.push(error.response.data.errors.name[0]);
          }

          if (error.response.data.errors.description) {
            this.errors.push(error.response.data.errors.description[0]);
          }
        });
      },
      reset()
      {
        this.task.name = '';
        this.task.description = '';
      },
    }
  }
  </script>
