<template>
    <main class="mt-5 d-flex flex-column align-items-center">
        <MDBModal
            id="ModalInput"
            tabindex="-1"
            labelledby="ModalInputLabel"
            v-model="ModalInput"
        >
            <MDBModalHeader>
                <MDBModalTitle id="ModalInputLabel">{{ mode + ' User' }}</MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <div :class="'row mt-4'+(currentUser.id!='0'?'':' d-none')">
                    <span class="col-sm-4 fs-5">ID</span>
                    <div class="col-sm-4">
                        {{ currentUser.id }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="exampleInputName" class="form-label">Name</label>
                        <input v-model="currentUser.name"
                        type="text" class="form-control" id="exampleInputName">

                        <div class="col-sm-4 text-danger">
                            {{ errors.name }}
                        </div>
                    </div>

                    <div class="col">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input v-model="currentUser.email"
                        type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                        <div class="col-sm-4 text-danger">
                            {{ errors.email }}
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input v-model="currentUser.password"
                        type="password" class="form-control" id="exampleInputPassword1">

                        <div class="col-sm-4 text-danger">
                            {{ errors.password }}
                        </div>
                    </div>

                    <div class="col">
                        <label for="exampleInputPassword2" class="form-label">Password Confirmation</label>
                        <input v-model="currentUser.password_confirmation"
                        type="password" class="form-control" id="exampleInputPassword2">

                        <div class="col-sm-4 text-danger">
                            {{ errors.password_confirmation }}
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <select class="form-select" v-model="currentUser.role">
                            <option selected disabled>role</option>
                            <option value="Worker">Worker</option>
                            <option value="Manager">Manager</option>
                            <option value="Admin">Admin</option>
                        </select>

                        <div class="col-sm-4 text-danger">
                            {{ errors.role }}
                        </div>
                    </div>
                </div>

            </MDBModalBody>
            <MDBModalFooter>
                <div class="col">
                    <MDBBtn class="btn btn-dark"
                        @click="createOrUpdate">
                        {{ mode == 'Add'?'Create':'Update' }}
                    </MDBBtn>
                </div>
            </MDBModalFooter>
        </MDBModal>
        <ModalErrorComponent ref="modalError"></ModalErrorComponent>
        <ModalConfirmComponent ref="modalConfirm"></ModalConfirmComponent>
        <div>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">email</th>
                        <th scope="col">role</th>
                        <th scope="col">created at</th>
                        <th scope="col">updated at</th>
                        <th>
                            <button class="btn-sm btn btn-light mt-1 me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="openModalInput('Add')" title="Add">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button class="btn-sm btn btn-light mt-1 me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="showUsers" title="Update list">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <th scope="row">{{ user.id }}</th>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td>
                        <td>{{ user.created_at }}</td>
                        <td>{{ user.updated_at }}</td>
                        <td>
                            <button class="btn-sm btn btn-dark mt-1 me-2" data-mdb-ripple-init
                                @click="openModalInput('Edit', user)" title="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="btn-sm btn btn-dark mt-1 me-2" data-mdb-ripple-init
                                @click="remove(user.id)" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</template>

<script>
    import ModalErrorComponent from '../posterminal/ModalErrorComponent.vue';
    import ModalConfirmComponent from '../posterminal/ModalConfirmComponent.vue';
    import {
        MDBModal,
        MDBModalHeader,
        MDBModalTitle,
        MDBModalBody,
        MDBModalFooter,
        MDBBtn,
    } from 'mdb-vue-ui-kit';

    export default {
        name: 'UserComponent',
        components: {
            ModalErrorComponent,
            ModalConfirmComponent,

            MDBModal,
            MDBModalHeader,
            MDBModalTitle,
            MDBModalBody,
            MDBModalFooter,
            MDBBtn,
        },
        data() {
            return {
                users: [],
                currentUser: {},
                ModalInput: false,
                errors: {},
                mode: '',
            }
        },
        mounted() {
            this.showUsers();
        },
        methods: {
            showUsers() {
                axios.post('/api/user/show')
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.users = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                })
                .catch((data) => {
                    if (data.response.status == 401) {
                        this.$router.push('/user/login');
                    }
                });
            },
            createOrUpdate() {
                this.errors = {};
                let url = '/api/user/'
                    +(this.mode == 'Add'?'create':'update');
                axios.post(url, this.currentUser)
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.closeModalInput();
                        this.users = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                }).catch((errors) => {
                    for (let field in errors.response.data.errors) {
                        this.errors[field] = errors.response.data.errors[field][0];
                    }
                });
            },
            remove(userID) {
                let confirmationQuestion = 'Delete user with ID: '+userID+' ?';
                this.$refs.modalConfirm.openModalConfirme(
                    confirmationQuestion,
                    function (arg) {
                        axios.post('/api/user/delete', {
                            id: arg.id
                        })
                        .then((data) => {
                            if (data.data[0] == '200') {
                                arg.vue.users = data.data[1];
                            } else {
                                arg.vue.$refs.modalError.openModalError(data.data[1]);
                            }
                        });
                    },
                    {
                        id: userID,
                        vue: this
                    }
                );
            },
            openModalInput(mode, user=null) {
                this.errors = {};
                this.ModalInput = true;
                this.mode = mode;
                if (user==null) {
                    this.currentUser = {
                        id: '0',
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: '',
                        role: ''
                    };
                } else {
                    this.currentUser = {
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        role: user.role
                    };
                }
            },
            closeModalInput() {
                this.ModalInput = false;
                this.mode = '';
            },
        }
    }
</script>
