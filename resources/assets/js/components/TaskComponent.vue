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
            <v-client-table :data="tasks" :columns="columns" :options="options">
              <button slot="edit" slot-scope="props" class="btn btn-success btn-xs" @click="initUpdate(props.row.id - 1)">Edit</button>
              <button slot="delete" slot-scope="props" class="btn btn-danger btn-xs" @click="deleteTask(props.row.id - 1)">Delete</button>
            </v-client-table>
            <p class="vue-pagination-ad">
              Like the pagination component and want to use it independently? Try <a target="_blank" href="https://www.npmjs.com/package/vue-pagination-2">vue-pagination-2</a>
            </p>
          </div>
        </div>
      </div>
    </div>
    <create-task @new="addTask"></create-task>
    <update-task  :update_task = "update_task"></update-task>
  </div>
</template>

<script>
import Vue from 'vue'
import {ServerTable, ClientTable, Event} from 'vue-tables-2';

Vue.use(ClientTable, {}, false, 'bootstrap4');

export default {
  data() {
    return{
      errors: [],
      tasks: [],
      update_task: {},
      columns: ['id', 'name', 'description', 'edit', 'delete'],
      options: {
        headings: {
          id: 'ID',
          name: 'Name',
          description: 'Description',
          edit: 'Edit',
          delete: 'Delete'
        }
      },
    }
  },
  mounted()
  {
    axios.get('/task')
    .then(response => {
      this.tasks = response.data.tasks
    });
  },
  methods: {
    initAddTask()
    {
      this.errors = [];
      $("#add_task_model").modal("show");
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
