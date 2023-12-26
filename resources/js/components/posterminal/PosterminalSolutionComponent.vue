<template>
    <main class="mt-5 d-flex flex-column align-items-center">
        <MDBModal
            id="posterminal_ModalInput"
            tabindex="-1"
            labelledby="ModalInputLabel"
            v-model="posterminal_ModalInput"
        >
            <MDBModalHeader>
                <MDBModalTitle id="ModalInputLabel">{{ mode + ' Solution' }}</MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <div :class="'row mt-4'+(currentSolution.id!='0'?'':' d-none')">
                    <span class="col-sm-4 fs-5">ID</span>
                    <div class="col-sm-4">
                        {{ currentSolution.id }}
                    </div>
                </div>

                <div class="row mt-4">
                    <label  class="col-sm-4 fs-5" for="sel1">Theme</label>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="form-control cursor-pointer" id="sel1" v-model="currentSolution.theme_id">
                                <option :class="mode=='Add'?'':'d-none'" value="" disabled selected>fault theme</option>
                                <option v-for="theme in themes" :value="theme.id">
                                    {{ theme.title }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ errors.theme_id }}
                    </div>
                </div>

                <div class="row mt-4">
                    <label for="posterminal_title" class="col-sm-3
                    col-form-label fs-5">Title</label>
                    <div class="col-sm-5">
                        <textarea class="form-control" rows="2" maxlength="50"
                            id="posterminal_title" v-model="currentSolution.title">
                        </textarea>
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ errors.title }}
                    </div>
                </div>
            </MDBModalBody>
            <MDBModalFooter>
                <div class="col">
                    <MDBBtn class="btn btn-dark"
                        @click="createOrUpdateSolution">
                        {{ mode == 'Add'?'Create':'Update' }}
                    </MDBBtn>
                </div>
            </MDBModalFooter>
        </MDBModal>
        <ModalErrorComponent ref="modalError"></ModalErrorComponent>
        <ModalConfirmComponent ref="modalConfirm"></ModalConfirmComponent>
        <div>
            <h2>Posterminal Solutions</h2>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Theme</th>
                        <th scope="col">Title</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col">
                            <button class="btn-sm btn btn-light mt-1 me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="openModalInput('Add')" title="Add">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button class="btn-sm btn btn-light mt-1 me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="showSolutions" title="Update list">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="solution in solutions">
                        <th scope="row">{{ solution.id }}</th>
                        <td>{{ solution.theme.title }}</td>
                        <td>{{ solution.title }}</td>
                        <td>{{ solution.created_at }}</td>
                        <td>{{ solution.updated_at }}</td>
                        <td>
                            <button class="btn-sm btn btn-dark mt-1 me-2" data-mdb-ripple-init
                                @click="openModalInput('Edit', solution)" title="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="btn-sm btn btn-dark mt-1 me-2" data-mdb-ripple-init
                                @click="remove(solution.id)" title="Delete">
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
    import ModalErrorComponent from './ModalErrorComponent.vue';
    import ModalConfirmComponent from './ModalConfirmComponent.vue';
    import {
        MDBModal,
        MDBModalHeader,
        MDBModalTitle,
        MDBModalBody,
        MDBModalFooter,
        MDBBtn,
    } from 'mdb-vue-ui-kit';

    export default {
        name: 'PosterminalSolutionComponent',
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
        mounted() {
            this.showSolutions();
            this.getThemes();
        },
        data() {
            return {
                themes: [],
                solutions: [],
                posterminal_ModalInput: false,
                mode: '',
                currentSolution: {},
                errors: {},
            }
        },
        methods: {
            getThemes(){
                axios.post('/api/posterminal/theme/show')
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.themes = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                });
            },
            showSolutions(){
                axios.post('/api/posterminal/solution/show')
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.solutions = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                });
            },
            createOrUpdateSolution(){
                this.errors = {};
                let url = '/api/posterminal/solution/'
                    +(this.mode == 'Add'?'create':'update');
                axios.post(url, this.currentSolution)
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.closeModalInput();
                        this.solutions = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                }).catch((errors) => {
                    for (let field in errors.response.data.errors) {
                        this.errors[field] = errors.response.data.errors[field][0];
                    }
                });
            },
            remove(solutionId) {
                let confirmationQuestion = 'Delete solution with ID: '+solutionId+' ?';
                this.$refs.modalConfirm.openModalConfirme(
                    confirmationQuestion,
                    function (arg) {
                        axios.post('/api/posterminal/solution/delete', {
                            id: arg.id
                        })
                        .then((data) => {
                            if (data.data[0] == '200') {
                                arg.vue.solutions = data.data[1];
                            } else {
                                arg.vue.$refs.modalError.openModalError(data.data[1]);
                            }
                        });
                    },
                    {
                        id: solutionId,
                        vue: this
                    }
                );
            },
            openModalInput(mode, solution=null) {
                this.errors = {};
                this.posterminal_ModalInput = true;
                this.mode = mode;
                if (solution == null) {
                    this.currentSolution = {
                        id: '0',
                        theme_id: '',
                        title: '',
                        theme: {}
                    };
                } else {
                    this.currentSolution = {
                        id: solution.id,
                        theme_id: solution.theme_id,
                        title: solution.title,
                        theme_title: solution.theme.title,
                    };
                }
            },
            closeModalInput() {
                this.posterminal_ModalInput = false;
                this.mode = '';
            },
        }
    }
</script>
