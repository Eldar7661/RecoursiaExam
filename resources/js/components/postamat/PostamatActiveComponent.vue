<template>
    <h1 class="h1">Active postamats</h1>
    <main class="mt-4 d-flex flex-column align-items-center">
        <div class="col-sm-12">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="col-sm">ID</th>
                        <th scope="col" class="col-sm">Status</th>
                        <th scope="col">System ID</th>
                        <th scope="col">Address</th>
                        <th scope="col">Serial number</th>
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
                    <tr v-for="(postamat, key) of postamats" :key="key">
                        <td>{{ postamat.id }}</td>
                        <td>{{ postamat.status }}</td>
                        <td>{{ postamat.system_id }}</td>
                        <td>{{ postamat.address }}</td>
                        <td>{{ postamat.serial_number }}</td>
                        <td>{{ postamat.created_at }}</td>
                        <td>{{ postamat.updated_at }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-dark" @click="showModal('edit', postamat)"> <i
                                    class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" class="btn btn-sm btn-dark" @click="showModal('delete', postamat)"><i
                                    class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
        <MDBModalHeader>
            <MDBModalTitle id="createModalLabel"> Add Postamat </MDBModalTitle>
        </MDBModalHeader>
        <MDBModalBody>
            <form id="form">
                <div class="mb-3">
                    <fieldset class="row">
                        <legend class="col-form-label col-sm-4 pt-0 fs-5">Status</legend>
                        <div class="col-sm d-flex">
                            <div class="form-check m-2">
                                <input class="form-check-input" type="radio" name="status" id="statusOff" value="0"
                                    checked v-model="newObject.status">
                                <label class="form-check-label fs-6" for="statusOff">OFF</label>
                            </div>
                            <div class="form-check m-2">
                                <input class="form-check-input" type="radio" name="status" id="statusOn" value="1"
                                    v-model="newObject.status">
                                <label class="form-check-label fs-6" for="statusOn">ON</label>
                            </div>
                        </div>
                    </fieldset>

                    <div class="row mt-4">
                        <label for="system_id" class="col-sm-4 col-form-label fs-5">System
                            id</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="system_id" v-model="newObject.system_id">
                            <div class="row-sm-4 text-danger" > {{ error.system_id}} </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <label for="address" class="col-sm-4 col-form-label fs-5">Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="address" v-model="newObject.address">
                            <div class="row-sm-2 text-danger" > {{ error.address}} </div>
                        </div>
                    </div>

                    <div class="row mt-4 mb-4">
                        <label for="serial_number" class="col-sm-4 col-form-label fs-5">Serial number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="serial_number"
                                v-model="newObject.serial_number">
                            <div class="row-sm-2 text-danger" > {{ error.serial_number}} </div>
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
            <MDBModalTitle id="editModalLabel"> Edit Postamat </MDBModalTitle>
        </MDBModalHeader>
        <MDBModalBody>
            <form>
                <div class="mb-3">
                    <fieldset class="row">
                        <legend class="col-form-label col-sm-4 pt-0 fs-5">Status</legend>
                        <div class="col-sm d-flex">
                            <div class="form-check m-2">
                                <input class="form-check-input" type="radio" name="status" id="statusOff" value="0"
                                    checked v-model="currentPostamat.status">
                                <label class="form-check-label fs-6" for="statusOff">OFF</label>
                            </div>
                            <div class="form-check m-2">
                                <input class="form-check-input" type="radio" name="status" id="statusOn" value="1"
                                    v-model="currentPostamat.status">
                                <label class="form-check-label fs-6" for="statusOn">ON</label>
                            </div>
                        </div>
                    </fieldset>

                    <div class="row mt-4">
                        <label for="system_id" class="col-sm-4 col-form-label fs-5">System
                            id</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="system_id" v-model="currentPostamat.system_id">
                            <div class="row-sm-4 text-danger" > {{ error.system_id }} </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <label for="address" class="col-sm-4 col-form-label fs-5">Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="address" v-model="currentPostamat.address">
                            <div class="row-sm-4 text-danger" > {{ error.address }} </div>
                        </div>
                    </div>

                    <div class="row mt-4 mb-4">
                        <label for="serial_number" class="col-sm-4 col-form-label fs-5">Serial number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="serial_number"
                                v-model="currentPostamat.serial_number">
                                <div class="row-sm-4 text-danger" > {{ error.serial_number }} </div>
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
            <MDBModalTitle id="deleteModalLabel"> Delete postamat </MDBModalTitle>
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
                postamats: [],
                createModal: false,
                editModal: false,
                deleteModal: false,
                newObject: {
                    status: 0,
                    system_id: null,
                    address: null,
                    serial_number: null
                },
                currentPostamat: {},
                error: {},
            };
        },

        mounted() {
            let vue = this;
            axios.get('/api/postamat/index')
                .then(function (response) {
                    if (response.data.status) {
                        vue.postamats = response.data.postamats;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        methods: {
            showModal: function (modal, postamat = null) {
                if (modal == 'create') {
                    this.createModal = !this.createModal;
                } else if (modal == 'edit') {
                    this.editModal = !this.editModal;
                    if (postamat != null) {
                        this.currentPostamat = postamat;
                    }
                } else if (modal == 'delete') {
                    this.deleteModal = !this.deleteModal;
                    if (postamat != null) {
                        this.currentPostamat = postamat;
                    }
                }
            },



            save: function (modal) {
                let vue = this;
                if (modal == 'create') {
                    this.error = {};
                    axios.post('/api/postamat/create', vue.newObject)
                        .then(function (response) {
                            if (response.data.status) {
                                vue.postamats = response.data.postamats;
                                vue.showModal(modal);
                                vue.newObject = {
                                    status: 0,
                                    system_id: null,
                                    address: null,
                                    serial_number: null
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
                    axios.post('/api/postamat/edit', vue.currentPostamat)
                    .then(function(response) {
                        if (response.data.status) {
                            vue.postamats = response.data.postamats;
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
                    console.log(this.currentPostamat);
                    axios.post('/api/postamat/delete', vue.currentPostamat)
                        .then(function (response) {
                            if (response.data.status) {
                                vue.postamats = response.data.postamats;
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
