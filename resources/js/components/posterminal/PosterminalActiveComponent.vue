<template>
    <main class="mt-5 d-flex flex-column align-items-center">
        <MDBModal
            id="posterminal_ModalInput"
            tabindex="-1"
            labelledby="ModalInputLabel"
            v-model="posterminal_ModalInput"
        >
            <MDBModalHeader>
                <MDBModalTitle id="ModalInputLabel">{{ mode + ' Posterminal' }}</MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <div :class="'row mt-4'+(currentPosterminal.id!='0'?'':' d-none')">
                    <span class="col-sm-4 fs-5">ID</span>
                    <div class="col-sm-4">
                        {{ currentPosterminal.id }}
                    </div>
                </div>

                <fieldset class="row mt-4">
                    <legend class="col-form-label col-sm-4 pt-0 fs-5">Status</legend>
                    <div class="col-sm d-flex">
                        <div class="form-check m-2">
                            <input class="form-check-input" type="radio"
                                name="status" id="posterminal_statusOff" value="0" v-model="currentPosterminal.status" checked>
                            <label class="form-check-label fs-6" role="button" for="posterminal_statusOff">OFF</label>
                        </div>
                        <div class="form-check m-2">
                            <input class="form-check-input" type="radio"
                                name="status" id="posterminal_statusOn" value="1" v-model="currentPosterminal.status">
                            <label class="form-check-label fs-6" role="button" for="posterminal_statusOn">ON</label>
                        </div>
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ error.status }}
                    </div>
                </fieldset>

                <div class="row mt-4">
                    <label for="posterminal_system_id" class="col-sm-4
                    col-form-label fs-5">System id</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" maxlength="8"
                            id="posterminal_system_id" v-model="currentPosterminal.system_id">
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ error.system_id }}
                    </div>
                </div>

                <div class="row mt-4">
                    <label for="posterminal_address" class="col-sm-4
                    col-form-label fs-5">Address</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" rows="3" maxlength="255"
                            id="posterminal_address" v-model="currentPosterminal.address">
                        </textarea>
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ error.address }}
                    </div>
                </div>

                <div class="row mt-4 mb-4">
                    <label for="posterminal_serial_number" class="col-sm-4
                    col-form-label fs-5">Serial number</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" maxlength="10"
                            id="posterminal_serial_number" v-model="currentPosterminal.serial_number">
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ error.serial_number }}
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
            <h2>Posterminal Active</h2>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">status</th>
                        <th scope="col">system id</th>
                        <th scope="col">address</th>
                        <th scope="col">serial number</th>
                        <th scope="col">created at</th>
                        <th scope="col">updated at</th>
                        <th>
                            <button class="btn-sm btn btn-light mt-1 me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="openModalInput('Add')" title="Add">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button class="btn-sm btn btn-light mt-1 me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="showPosterminals" title="Update list">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="posterminal in posterminals">
                        <th scope="row">{{ posterminal.id }}</th>
                        <td :class="'fw-bold'+(posterminal.status == '1'? ' text-success':' text-danger')">
                            {{ posterminal.status == '1'? 'ON':'OFF' }}
                        </td>
                        <td>{{ posterminal.system_id }}</td>
                        <td>{{ posterminal.address }}</td>
                        <td>{{ posterminal.serial_number }}</td>
                        <td>{{ posterminal.created_at }}</td>
                        <td>{{ posterminal.updated_at }}</td>
                        <td>
                            <button class="btn-sm btn btn-dark mt-1 me-2" data-mdb-ripple-init
                                @click="openModalInput('Edit', posterminal)" title="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="btn-sm btn btn-dark mt-1 me-2" data-mdb-ripple-init
                                @click="remove(posterminal.id)" title="Delete">
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
        name: 'PosterminalActiveComponent',
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
            this.showPosterminals();
        },
        data() {
            return {
                posterminals: [],
                posterminal_ModalInput: false,
                mode: '',
                currentPosterminal: {},
                error: {},
            }
        },
        methods: {
            showPosterminals(){
                axios.post('/api/posterminal/lol')
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.posterminals = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                });
            },
            createOrUpdate(){
                this.error = {};
                let url = '/api/posterminal/'
                    +(this.mode == 'Add'?'create':'update');
                axios.post(url, this.currentPosterminal)
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.closeModalInput();
                        this.posterminals = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                }).catch((error) => {
                    for (let field in error.response.data.errors) {
                        this.error[field] = error.response.data.errors[field][0];
                    }
                });
            },
            remove(posterminalId) {
                let confirmationQuestion = 'Delete posterminal with ID: '+posterminalId+' ?';
                this.$refs.modalConfirm.openModalConfirme(
                    confirmationQuestion,
                    function (arg) {
                        axios.post('/api/posterminal/delete', {
                            id: arg.id
                        })
                        .then((data) => {
                            if (data.data[0] == '200') {
                                arg.vue.posterminals = data.data[1];
                            } else {
                                arg.vue.$refs.modalError.openModalError(data.data[1]);
                            }
                        });
                    },
                    {
                        id: posterminalId,
                        vue: this
                    }
                );
            },
            openModalInput(mode, posterminal=null) {
                this.posterminal_ModalInput = true;
                this.mode = mode;
                if (posterminal==null) {
                    this.currentPosterminal = {
                        id: '0',
                        status: '0',
                        system_id: '',
                        address: '',
                        serial_number: ''
                    };
                } else {
                    this.currentPosterminal = {
                        id: posterminal.id,
                        status: posterminal.status,
                        system_id:posterminal.system_id,
                        address:posterminal.address,
                        serial_number:posterminal.serial_number
                    };
                }
            },
            closeModalInput() {
                this.posterminal_ModalInput = false;
                this.mode = '';
                this.error = {};
            },
        },
    }
</script>
