<template>
    <title>Cardomat</title>
    <div>
        <div class="container">
            <h3 class="text mt-4 mb-3">Cardomat</h3>
        <table class="table align-middle mb-0 bg-white mt-2">
            <thead class="table-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Status</th>
                <th scope="col">System ID</th>
                <th scope="col">Address</th>
                <th scope="col">Serial number</th>
                <th scope="col">Created</th>
                <th scope="col">Updated</th>
                <th scope="col">
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
                <tr v-for="(card, key) of cards" :key="key">
                    <td>{{ card.id }}</td>
                    <td>
                        {{ card.status === 0 ? 'active' : (card.status === 1 ? 'inactive' : '') }}
                    </td>
                    <td>{{ card.system_id }}</td>
                    <td>{{ card.address }}</td>
                    <td>{{ card.serial_number }}</td>
                    <td>{{ card.created_at }}</td>
                    <td>{{ card.updated_at }}</td>
                    <td>
                        <div style="display: flex; gap: 3px;">
                            <button type="button" class="btn btn-sm btn-dark" @click="showModal('edit', card)"><i class="fa-regular fa-pen-to-square"></i></button>
                            <button type="button" class="btn btn-sm btn-dark" @click="confirmDelete(card)"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        <MDBModal id="createModal" tabindex="-1" labelledby="createModalLabel" v-model="createModal">
            <MDBModalHeader>
                <MDBModalTitle id="createModalLabel"  class="text-center">  Add Posterminal </MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <form>
                    <div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label fs-5">Status</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="createstatusOff" value="1" v-model="newObject.status" checked>
                                    <label class="form-check-label fs-6" for="createstatusOff">OFF</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="createstatusOn" value="0" v-model="newObject.status">
                                    <label class="form-check-label fs-6" for="createstatusOn">ON</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <label for="createsystem_id" class="col-sm-4 col-form-label fs-5">System id</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="createsystem_id" v-model="newObject.system_id">
                                <div class="row-sm-4 text-danger" > {{ error.system_id}} </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <label for="createaddress" class="col-sm-4 col-form-label fs-5">Address</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="createaddress" v-model="newObject.address">
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            <label for="createserial_number" class="col-sm-4 col-form-label fs-5">Serial number</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="createserial_number" v-model="newObject.serial_number">
                                <div class="row-sm-4 text-danger" > {{ error.serial_number}} </div>
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
                <MDBModalTitle id="createModalLabel">  Add Posterminal </MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <form>
                    <div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label fs-5">Status</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="editstatusOff" value="1" v-model="currentCard.status" checked>
                                    <label class="form-check-label fs-6" for="editstatusOff">OFF</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="editstatusOn" value="0" v-model="currentCard.status">
                                    <label class="form-check-label fs-6" for="editstatusOn">ON</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <label for="editsystem_id" class="col-sm-4 col-form-label fs-5">System id</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="editsystem_id" v-model="currentCard.system_id">
                                <div class="row-sm-4 text-danger" > {{ error.system_id}} </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <label for="editaddress" class="col-sm-4 col-form-label fs-5">Address</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="editaddress" v-model="currentCard.address">
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            <label for="editserial_number" class="col-sm-4 col-form-label fs-5">Serial number</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="editserial_number" v-model="currentCard.serial_number">
                                <div class="row-sm-4 text-danger" > {{ error.serial_number}} </div>
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
                cards: [],
                createModal: false,
                editModal: false,
                newObject: {
                    serial_number: null,
                    system_id: null,
                    address: null,
                    status: 0
                },
                currentCard: {},
                error: {}
            };
        },

        mounted() {
            let vue = this;
            axios.get('/api/cardomat/all')
            .then(function (response) {
                if (response.data.status) {
                    vue.cards = response.data.cards;
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        methods: {
            showModal: function (modal, card = null) {
                if (modal == 'create') {
                    this.createModal = !this.createModal;
                } else if (modal == 'edit') {
                    this.editModal = !this.editModal;
                    if (card != null) {
                        this.currentCard = card;
                    }
                }
            },

            save: function (modal) {
                let vue = this;
                if (modal == 'create') {
                    axios.post('/api/cardomat/create', vue.newObject)
                    .then(function (response) {
                        if (response.data.status) {
                            vue.cards = response.data.cards;
                            vue.showModal(modal);
                            vue.newObject = {
                                system_id: null,
                                serial_number: null,
                                address: null,
                                status: 0
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
                    axios.post('/api/cardomat/edit', vue.currentCard)
                    .then(function(response) {
                        if (response.data.status) {
                            vue.cards = response.data.cards;
                            vue.showModal(modal);
                        }
                    })
                    .catch((error) => {
                            for (let field in error.response.data.errors) {
                                this.error[field] = error.response.data.errors[field][0];
                            };
                            console.log(error);
                    });
                }
            },

            confirmDelete: function (card) {
                if (confirm("Вы уверены, что хотите удалить эту карту?")) {
                    this.deleteCard(card);
                }
            },

            deleteCard: function (card) {
                axios.delete(`/api/cardomat/delete/${card.id}`)
                .then(response => {
                    if (response.data.status) {
                        this.cards = response.data.cards;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },

            refreshData: function () {
                 let vue = this;
                 axios.get('/api/cardomat/all')
                 .then(function (response) {
                    if (response.data.status) {
                        vue.cards = response.data.cards;
                    }
                })
                .catch(function (error) {
                    console.log("Error refreshing data:", error);
                });
            },
        }
    }

</script>
