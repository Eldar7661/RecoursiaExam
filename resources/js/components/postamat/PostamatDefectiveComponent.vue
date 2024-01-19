<template>
    <h1 class="h1">Postamats defects</h1>
    <main class="mt-4 d-flex flex-column align-items-center">
        <div class="col-sm-12">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="col-sm">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
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
                    <tr v-for="(defective, key) of defectives" :key="key">
                        <td>{{ defective.id }}</td>
                        <td>{{ defective.title }}</td>
                        <td>{{ defective.description }}</td>
                        <td>{{ defective.created_at }}</td>
                        <td>{{ defective.updated_at }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-dark" @click="showModal('edit', defective)"> <i
                                    class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" class="btn btn-sm btn-dark" @click="showModal('delete', defective)"><i
                                    class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
        <MDBModalHeader>
            <MDBModalTitle id="createModalLabel"> Add defect </MDBModalTitle>
        </MDBModalHeader>
        <MDBModalBody>
            <form id="form">
                <div class="mb-3">
                    <div class="row mt-4">
                        <label for="title" class="col-sm-4 col-form-label fs-5">Title</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="title" v-model="newObject.title">
                            <div class="row-sm-4 text-danger" > {{ error.title }} </div>
                        </div>
                    </div>

                    <div class="row mt-4 mb-4">
                        <label for="description" class="col-sm-4 col-form-label fs-5">Description</label>
                        <div class="col-sm-8">
                            <textarea type="text" class="form-control textarea1" id="description" v-model="newObject.description"></textarea>
                            <div class="row-sm-4 text-danger" > {{ error.description }} </div>
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
            <MDBModalTitle id="editModalLabel"> Edit defect </MDBModalTitle>
        </MDBModalHeader>
        <MDBModalBody>

            <form id="form">
                <div class="mb-3">
                    <div class="row mt-4">
                        <label for="title" class="col-sm-4 col-form-label fs-5">Title</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="title" v-model="currentDefective.title">
                            <div class="row-sm-4 text-danger" > {{ error.title }} </div>
                        </div>
                    </div>

                    <div class="row mt-4 mb-4">
                        <label for="description" class="col-sm-4 col-form-label fs-5">Description</label>
                        <div class="col-sm-8">
                            <textarea type="text" class="form-control textarea1" id="description" v-model="currentDefective.description"></textarea>
                            <div class="row-sm-4 text-danger" > {{ error.description }} </div>
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
            <MDBModalTitle id="deleteModalLabel"> Delete defect </MDBModalTitle>
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
                defectives: [],
                createModal: false,
                editModal: false,
                deleteModal: false,
                newObject: {
                    status: 0,
                    title: null,
                    description: null
                },
                currentDefective: {},
                error: {}
            };
        },

        mounted() {
            let vue = this;
            axios.get('/api/postamat/defective/index')
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
                } else if (modal == 'delete') {
                    this.deleteModal = !this.deleteModal;
                    if (defective != null) {
                        this.currentDefective = defective;
                    }
                }
            },



            save: function (modal) {
                let vue = this;
                if (modal == 'create') {
                    this.error = {};
                    axios.post('/api/postamat/defective/create', vue.newObject)
                        .then(function (response) {
                            if (response.data.status) {
                                vue.defectives = response.data.defectives;
                                vue.showModal(modal);
                                vue.newObject = {
                                    status: 0,
                                    title: null,
                                    description: null
                                };
                            }
                        })
                        .catch((error) => {
                            for (let field in error.response.data.errors) {
                                this.error[field] = error.response.data.errors[field][0];
                            };
                            console.log(error);
                        });
                } else if (modal == 'edit') {
                    this.error = {};
                    axios.post('/api/postamat/defective/edit', vue.currentDefective)
                        .then(function (response) {
                            if (response.data.status) {
                                vue.defectives = response.data.defectives;
                                vue.showModal(modal);
                            }
                        })
                        .catch((error) => {
                            for (let field in error.response.data.errors) {
                                this.error[field] = error.response.data.errors[field][0];
                            };
                            console.log(error);
                        });
                } else if (modal == 'delete') {
                    console.log(this.currentDefective);
                    axios.post('/api/postamat/defective/delete', vue.currentDefective)
                        .then(function (response) {
                            if (response.data.status) {
                                vue.defectives = response.data.defectives;
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
