<template>
    <div class="container-fluid" id="employees">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Employees
                        <button @click="create()" class="btn btn-primary btn-sm float-right">
                            + Add new
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" v-if="employees.length > 0">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Name</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Job</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(employee, index) in employees">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ employee.name }}</td>
                                    <td>{{ employee.email }}</td>
                                    <td>{{ employee.gender }}</td>
                                    <td>{{ employee.job }}</td>
                                    <td class="actions">
                                        <button class="btn btn-secondary btn-sm" @click="edit(index)">Edit</button>
                                        <button class="btn btn-danger btn-sm" @click="remove(index)">Delete</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="empty" v-else>There are no registered Employees.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="employee-add-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Name" class="form-control" v-model="employee.name">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" name="email" id="email" placeholder="E-mail" class="form-control" v-model="employee.email">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-control" v-model="employee.gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="job">Job Title</label>
                            <input type="text" name="job" id="job" placeholder="Job Title" class="form-control" v-model="employee.job">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="store">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="employee-edit-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="name-edit">Name</label>
                            <input type="text" name="name" id="name-edit" placeholder="Name" class="form-control" v-model="employee_edit.name">
                        </div>
                        <div class="form-group">
                            <label for="email-edit">E-mail</label>
                            <input type="text" name="email" id="email-edit" placeholder="E-mail" class="form-control" v-model="employee_edit.email">
                        </div>
                        <div class="form-group">
                            <label for="gender-edit">Gender</label>
                            <select name="gender" id="gender-edit" class="form-control" v-model="employee_edit.gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="job-edit">Job Title</label>
                            <input type="text" name="job" id="job-edit" placeholder="Job Title" class="form-control" v-model="employee_edit.job">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="update">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                employee: {
                    name: '',
                    email: '',
                    gender: 'male',
                    job: ''
                },
                errors: [],
                employees: [],
                employee_edit: {}
            }
        },
        methods: {
            list()
            {
                axios.get('/api/employees')
                    .then(response => {
                        this.employees = response.data.data;
                    });
            },
            create()
            {
                this.erros = [];
                $('#employee-add-modal').modal('show');
            },
            store()
            {
                this.errors = [];
                axios.post('/api/employee', {
                    name: this.employee.name,
                    email: this.employee.email,
                    gender: this.employee.gender,
                    job: this.employee.job
                }).then(response => {
                    this.reset();
                    this.employees.push(response.data.data);
                    $('#employee-add-modal').modal('hide');
                })
                .catch(error => {
                    this.showError(error);
                });
            },
            edit(index)
            {
                this.errors = [];
                this.employee_edit = this.employees[index];
                $('#employee-edit-modal').modal('show');
            },
            update()
            {
                axios.put('/api/employee/' + this.employee_edit.id, {
                    name: this.employee_edit.name,
                    email: this.employee_edit.email,
                    gender: this.employee_edit.gender,
                    job: this.employee_edit.job
                })
                .then(response => {
                    $('#employee-edit-modal').modal('hide');
                })
                .catch(error => {
                    this.showError(error);
                });
            },
            remove(index) //Delete word is reserved :(
            {
                if(confirm("Do you ready want to delete this employee?")) {
                    axios.delete('/api/employee/' + this.employees[index].id)
                        .then(response => {
                            this.employees.splice(index, 1)
                        })
                        .catch(error => {
                            //To do
                        })
                }
            },
            reset()
            {
                this.employee.name = '';
                this.employee.email = '';
                this.employee.gender = 'male';
                this.employee.job = '';
            },
            showError(error)
            {
                if (error.response.data.errors.name) {
                    this.errors.push(error.response.data.errors.name[0]);
                }

                if (error.response.data.errors.email) {
                    this.errors.push(error.response.data.errors.email[0]);
                }

                if (error.response.data.errors.gender) {
                    this.errors.push(error.response.data.errors.gender[0]);
                }

                if (error.response.data.errors.job) {
                    this.errors.push(error.response.data.errors.job[0]);
                }
            }
        },
        mounted() {
            this.list();
        }
    }
</script>


<style>
    #employees .table-hover tbody tr:hover {
        background-color: #3490dc;
        color: #fff;
    }
    #employees .table .actions {
        text-align: right;
    }
    #employees .empty {
        text-align: center;
        color: rgba(0,0,0,0.5);
    }
</style>
