<template>
    <h2 class="h2">Postamat defects solutions</h2>
    <main class="mt-4 d-flex flex-column align-items-center">
        <div class="col-sm-12">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="col-sm">ID</th>
                        <th scope="col">Theme</th>
                        <th scope="col">Title</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th class="float-right">
                            <button type="button" class="btn btn-sm btn-light" @click="showModal('create')">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(solution, key) of solutions" :key="key">
                        <td>{{ solution.id }}</td>
                        <td>{{ solution.theme.title }}</td>
                        <td>{{ solution.title }}</td>
                        <td>{{ solution.created_at }}</td>
                        <td>{{ solution.updated_at }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-dark me-2" @click="showModal('edit', solution)"> <i
                                    class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" class="btn btn-sm btn-dark" @click="showModal('delete', solution)"><i
                                    class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
        <MDBModalHeader>
            <MDBModalTitle id="createModalLabel"> Add solution </MDBModalTitle>
        </MDBModalHeader>
        <MDBModalBody>
            <form id="form">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <label for="theme_title" class="col-md-4 form-label">Select theme</label>
                                <div class="col-md-7">
                                    <select class="form-select" id="theme_title" v-model="newObject.theme_id">
                                        <option disabled selected value="">select theme</option>
                                        <option v-for="theme in themes" :value="theme.id">
                                            {{  theme.title }}
                                        </option>
                                    </select>
                                </div>
                        </div>

                        <div class="row row2 pt-4">
                            <label for="title" class="col-md-3 form-label">Title</label>
                            <div class="col-md-8">
                                <textarea type="text" class="form-control textarea2" id="title" v-model="newObject.title"></textarea>
                                <div class="row-sm-4 text-danger" > {{ error.title }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </MDBModalBody>
        <MDBModalFooter>
            <MDBBtn color="secondary" @click="showModal('create')">Close</MDBBtn>
            <MDBBtn color="primary" @click="save('create')">Save</MDBBtn>
        </MDBModalFooter>
    </MDBModal>

    <MDBModal id="editModal" tabindex="-1" labelledby="editModalLabel" v-model="editModal">
        <MDBModalHeader>
            <MDBModalTitle id="editModalLabel"> Edit solution </MDBModalTitle>
        </MDBModalHeader>
        <MDBModalBody>

            <form id="form">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <label for="theme_title" class="col-md-4 form-label">Select theme</label>
                            <div class="col-md-7">
                                <select class="form-select col-md-8" id="theme_title" v-model="currentSolution.theme_id">
                                    <option disabled selected v-for="theme in themes" :value="theme.id">
                                        {{  theme.title }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row row2 pt-4">
                            <label for="title" class="col-md-3 form-label">Title</label>
                            <div class="col-md-8">
                                <textarea type="text" class="form-control textarea2" id="title" v-model="currentSolution.title"></textarea>
                                <div class="row-sm-4 text-danger" > {{ error.title }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </MDBModalBody>
        <MDBModalFooter>
            <MDBBtn color="secondary" @click="showModal('edit')">Close</MDBBtn>
            <MDBBtn color="primary" @click="save('edit')">Save</MDBBtn>
        </MDBModalFooter>
    </MDBModal>

    <MDBModal id="deleteModal" tabindex="-1" labelledby="deleteModalLabel" v-model="deleteModal">
        <MDBModalHeader>
            <MDBModalTitle id="deleteModalLabel"> Delete solution </MDBModalTitle>
        </MDBModalHeader>
        <MDBModalBody>Are you sure?</MDBModalBody>
        <MDBModalFooter>
            <MDBBtn color="primary" @click="save('delete')"><i class="fa-solid fa-check"></i></MDBBtn>
            <MDBBtn color="secondary" @click="showModal('delete')"><i class="fa-solid fa-xmark"></i></MDBBtn>
        </MDBModalFooter>
    </MDBModal>
</template>

<script>
    import axios from 'axios';
    import {
        MDBModal,
        MDBModalHeader,
        MDBModalTitle,
        MDBModalBody,
        MDBModalFooter,
        MDBBtn,
    } from 'mdb-vue-ui-kit';

    export default {
        components: {
            MDBModal,
            MDBModalHeader,
            MDBModalTitle,
            MDBModalBody,
            MDBModalFooter,
            MDBBtn,
        },

        data() {
            return {
                solutions: [],
                themes: [],
                createModal: false,
                editModal: false,
                deleteModal: false,
                newObject: {
                    theme_id: null,
                    title: null
                },
                currentSolution: {},
                error: {}
            };
        },

        mounted() {
            let vue = this;
            axios.get('/api/postamat/solutions/index')
                .then(function (response) {
                    if (response.data.status) {
                        vue.solutions = response.data.solutions;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });

            axios.get('/api/postamat/themes/index')
                .then(function (response) {
                    if (response.data.status) {
                        vue.themes = response.data.themes;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

        methods: {
            showModal: function (modal, solution = null) {
                if (modal == 'create') {
                    this.createModal = !this.createModal;
                } else if (modal == 'edit') {
                    this.editModal = !this.editModal;
                    if (solution != null) {
                        this.currentSolution = solution;
                    }
                } else if (modal == 'delete') {
                    this.deleteModal = !this.deleteModal;
                    if (solution != null) {
                        this.currentSolution = solution;
                    }
                }
            },



            save: function (modal) {
                let vue = this;
                if (modal == 'create') {
                    this.error = {};
                    axios.post('/api/postamat/solutions/create', vue.newObject)
                        .then(function (response) {
                            if (response.data.status) {
                                vue.solutions = response.data.solutions;
                                vue.showModal(modal);
                                vue.newObject = {
                                    theme_id: null,
                                    title: null
                                };
                            }
                        })
                        .catch((error) => {
                            for (let field in error.response.data.errors) {
                                this.error[field] = error.response.data.errors[field][0];
                            };
                        });
                } else if (modal == 'edit') {
                    this.error = {};
                    axios.post('/api/postamat/solutions/edit', vue.currentSolution)
                        .then(function (response) {
                            if (response.data.status) {
                                vue.solutions = response.data.solutions;
                                vue.showModal(modal);
                            }
                        })
                        .catch((error) => {
                            for (let field in error.response.data.errors) {
                                this.error[field] = error.response.data.errors[field][0];
                            };
                        });
                } else if (modal == 'delete') {
                    axios.post('/api/postamat/solutions/delete', vue.currentSolution)
                        .then(function (response) {
                            if (response.data.status) {
                                vue.solutions = response.data.solutions;
                                vue.showModal(modal);
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            }
        }
    }

</script>
