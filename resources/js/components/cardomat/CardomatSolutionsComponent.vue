<template>
    <div class="container">
        <h3 class="text mt-4 mb-3">Solutions</h3>
    <table class="table align-middle mb-0 bg-white mt-2">
        <thead class="table-dark">
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Theme title</th>
            <th scope="col">Title</th>
            <th scope="col">Created</th>
            <th scope="col">Updated</th>
            <th>
                <div>
                    <button type="button" class="btn-sm btn btn-light m-1" @click="showModal('create')" data-mdb-ripple-init>
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn-sm btn btn-light m-1" @click="refreshData" data-mdb-ripple-init>
                        <i class="fa-solid fa-rotate"></i>
                    </button>
                </div>
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
                    <div style="display: flex; gap: 3px;">
                        <button type="button" class="btn btn-sm btn-dark" @click="showModal('edit', solution)"><i class="fa-regular fa-pen-to-square"></i></button>
                        <button type="button" class="btn btn-sm btn-dark" @click="confirmDelete(solution)"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>

    </table>
    </div>
        <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
            <MDBModalHeader>
                <MDBModalTitle id="createModalLabel"  class="text-center">  Add Solution </MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <form>
                    <div class="row mt-4">
                        <label for="createtheme_id" class="col-sm-4 col-form-label fs-5">Theme ID</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="createtheme_id" v-model="newSolution.theme_id">
                                <option v-for="theme in themes" :key="theme.id" :value="theme.id">{{ theme.title }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <label for="createtitle" class="col-sm-4 col-form-label fs-5">title</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="createtitle" v-model="newSolution.title" style="height: 100px;"></textarea>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-8">
                            <button type="button" class="btn btn-dark" data-mdb-ripple-init @click="save('create')">Create</button>
                            <button type="button" class="btn btn-secondary" data-mdb-ripple-init @click="showModal('create')">Close</button>
                        </div>
                    </div>
                </form>
            </MDBModalBody>
        </MDBModal>
        <MDBModal id="editModal" tabindex="-1" labelledby="createModalLabel" v-model="editModal">
            <MDBModalHeader>
                <MDBModalTitle id="createModalLabel">  Edit Solution </MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <form>
                    <div class="row mt-4">
                        <label for="edittheme_id" class="col-sm-4 col-form-label fs-5">Theme ID</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="edittheme_id" v-model="currentSolution.theme_id">
                                <option v-for="theme in themes" :key="theme.id" :value="theme.id">{{ theme.title }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <label for="edittitle" class="col-sm-4 col-form-label fs-5">title</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="edittitle" v-model="currentSolution.title" style="height: 100px;"></textarea>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-8">
                            <button type="button" class="btn btn-dark" data-mdb-ripple-init @click="save('edit')">Update</button>
                            <button type="button" class="btn btn-secondary" data-mdb-ripple-init @click="showModal('edit')">Close</button>
                        </div>
                    </div>
                </form>
            </MDBModalBody>
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
            themes: [],
            solutions: [],
            createModal: false,
            editModal: false,
            newSolution: {
                theme_id: null,
                title: null,
            },
            currentSolution: {},
        };
    },

    mounted() {
        this.loadThemes();

        let vue = this;
        axios.get('/api/cardomat/solutions/all')
        .then(function (response) {
            if (response.data.status) {
                vue.solutions = response.data.solutions;
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
                }
            },

        loadThemes() {
            axios.get('/api/cardomat/themes/find')
            .then(response => {
                this.themes = response.data.themes;
            })
            .catch(error => {
                console.error('Error loading themes', error);
            });
        },

        save: function (modal) {
            let vue = this;
            if (modal === 'create') {
                axios.post('/api/cardomat/solutions/create', vue.newSolution)
                .then(function (response) {
                    if (response.data.status) {
                        vue.solutions = response.data.solutions;
                        vue.showModal(modal);
                        vue.newSolution = {
                            theme_id: null,
                            title: null,
                        };
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            } else if (modal === 'edit') {
                axios.post('/api/cardomat/solutions/edit', vue.currentSolution)
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
        },

        confirmDelete: function (solution) {
            if (confirm("Вы уверены, что хотите удалить эту карту?")) {
                this.deleteSolution(solution);
            }
        },

        deleteSolution: function (solution) {
            axios.delete(`/api/cardomat/solutions/delete/${solution.id}`)
            .then(response => {
                if (response.data.status) {
                    this.solutions = response.data.solutions;
                }
            })
            .catch(error => {
                console.log(error);
            });
        },

        refreshData: function () {
            let vue = this;
            axios.get('/api/cardomat/solutions/all')
            .then(function (response) {
                if (response.data.status) {
                    vue.solutions = response.data.solutions;
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
    },
};
</script>
