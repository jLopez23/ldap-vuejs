<template>
  <div class="modal fade" tabindex="-1" role="dialog" id="update_task_model">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Update Task</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>
            <div class="form-group">
              <label>Name:</label>
              <input type="text" placeholder="Task Name" class="form-control"
              v-model="update_task.name">
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <textarea cols="30" rows="5" class="form-control"
              placeholder="Task Description" v-model="update_task.description"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" @click="updateTask" class="btn btn-primary">Submit</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </template>

  <script>
  export default {
    props: ['update_task'],
    data(){
      return {
        errors: []
      }
    },
    methods: {
      updateTask()
      {
        axios.patch('/task/' + this.update_task.id, this.update_task)
        .then(response => {
          $("#update_task_model").modal("hide");
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
    }
  }
  </script>
