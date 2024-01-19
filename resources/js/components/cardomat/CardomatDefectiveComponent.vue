<template>
    <div>
        <div class="container">
            <h3 class="text mt-4 mb-3">Defective</h3>
        <table class="table align-middle mb-0 bg-white mt-2">
            <thead class="table-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
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
                <tr v-for="(defective, key) of defectives" :key="key">
                    <td>{{ defective.id }}</td>
                    <td>{{ defective.title }}</td>
                    <td>{{ defective.description }}</td>
                    <td>{{ defective.created_at }}</td>
                    <td>{{ defective.updated_at }}</td>
                    <td>
                        <div style="display: flex; gap: 3px;">
                            <button type="button" class="btn btn-sm btn-dark" @click="showModal('edit', defective)"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" class="btn btn-sm btn-dark" @click="confirmDelete(defective)"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
            <MDBModalHeader>
                <MDBModalTitle id="createModalLabel"  class="text-center">  Add Defective </MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <form>
                    <div>
                        <div class="row mt-4">
                            <label for="createtitle" class="col-sm-4 col-form-label fs-5">Title</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="createtitle" v-model="newDefective.title">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <label for="createdescription" class="col-sm-4 col-form-label fs-5">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="createdescription" v-model="newDefective.description" style="height: 100px;"></textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-dark" data-mdb-ripple-init @click="save('create')">Create</button>
                            <button type="button" class="btn btn-secondory" data-mdb-ripple-init @click="showModal('create')">close</button>
                    </div>
                </form>
            </MDBModalBody>
        </MDBModal>
        <MDBModal id="editModal" tabindex="-1" labelledby="createModalLabel" v-model="editModal">
            <MDBModalHeader>
                <MDBModalTitle id="createModalLabel">  Edit Defective </MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <form>
                    <div>
                        <div class="row mt-4">
                            <label for="edittitle" class="col-sm-4 col-form-label fs-5">Title</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="edittitle" v-model="currentDefective.title">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <label for="editdescription" class="col-sm-4 col-form-label fs-5">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="editdescription" v-model="currentDefective.description" style="height: 100px;"></textarea>
                            </div>
                        </div>
                            <button type="button" class="btn btn-dark" data-mdb-ripple-init  @click="save('edit')">Update</button>
                            <button type="button" class="btn btn-secondory" data-mdb-ripple-init @click="showModal('edit')">Close</button>
                    </div>
                </form>
            </MDBModalBody>
        </MDBModal>
    </div>
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
                defectives: [],
                createModal: false,
                editModal: false,
                newDefective: {
                    title: null,
                    description: null,
                },
                currentDefective: {}
            };
        },
        mounted() {
            let vue = this;
            axios.get('/api/cardomat/theme/all')
            .then(function (response) {
                if (response.data.status) {
                    vue.defectives = response.data.defectives;
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        methods: {
            showModal: function (modal, defective = null) {
                if (modal == 'create') {
                    this.createModal = !this.createModal;
                } else if (modal == 'edit') {
                    this.editModal = !this.editModal;
                    if (defective != null) {
                        this.currentDefective = defective;
                    }
                }
            },

            save: function (modal) {
                let vue = this;
                if (modal == 'create') {
                    axios.post('/api/cardomat/theme/create', vue.newDefective)
                    .then(function (response) {
                        if (response.data.status) {
                            vue.defectives = response.data.defectives;
                            vue.showModal(modal);
                            vue.newDefective = {
                                title: null,
                                description: null,
                            };
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                } else if (modal == 'edit') {
                    axios.post('/api/cardomat/theme/edit', vue.currentDefective)
                    .then(function(response) {
                        if (response.data.status) {
                            vue.defectives = response.data.defectives;
                            vue.showModal(modal);
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                }
            },

            confirmDelete: function (defective) {
                if (confirm("Вы уверены, что хотите удалить эту карту?")) {
                    this.deleteDefective(defective);
                }
            },

            deleteDefective: function (defective) {
                axios.delete(`/api/cardomat/theme/delete/${defective.id}`)
                .then(response => {
                    if (response.data.status) {
                        this.defectives = response.data.defectives;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },

            refreshData: function () {
                let vue = this;
                axios.get('/api/cardomat/theme/all')
                .then(function (response) {
                    if (response.data.status) {
                        vue.defectives = response.data.defectives;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
        },
    };
</script>
