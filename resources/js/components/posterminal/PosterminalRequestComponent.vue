<template>
    <main class="mt-5 d-flex flex-column align-items-center">
        <MDBModal
            id="posterminal_ModalInput"
            tabindex="-1"
            labelledby="ModalInputLabel"
            v-model="posterminal_ModalInput"
        >
            <MDBModalHeader>
                <MDBModalTitle id="ModalInputLabel">Create Request</MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <div class="row mt-4">
                    <label  class="col-sm-4 fs-5" for="sel1">Posterminal</label>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="form-control cursor-pointer" id="sel1" v-model="currenRequest.posterminal">
                                <option value="" disabled selected>fault posterminal</option>
                                <option v-for="posterminal in posterminals" :value="posterminal">
                                    {{ posterminal.system_id }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ errors.posterminal_id }}
                    </div>
                </div>

                <div class="row mt-4">
                    <label  class="col-sm-4 fs-5" for="sel2">Theme</label>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="form-control cursor-pointer" id="sel2" v-model="currenRequest.theme">
                                <option value="" disabled selected>fault theme</option>
                                <option v-for="theme in themes" :value="theme">
                                    {{ theme.title }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ errors.theme_id }}
                    </div>
                </div>

            </MDBModalBody>
            <MDBModalFooter>
                <div class="col">
                    <MDBBtn class="btn btn-dark" @click="create">
                        Create
                    </MDBBtn>
                </div>
            </MDBModalFooter>
        </MDBModal>
        <MDBModal
            id="ModalInputAddSolution"
            tabindex="-1"
            labelledby="ModalInputLabel"
            v-model="ModalInputAddSolution"
        >
            <MDBModalHeader>
                <MDBModalTitle id="ModalInputLabel">Close request</MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <div class="row mt-4">
                    <label  class="col-sm-4 fs-5" for="sel3">Solution</label>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="form-control cursor-pointer" id="sel3" v-model="currenRequest.solution">
                                <option value="" disabled selected>fault solution</option>
                                <option v-for="solution in currenRequest.theme.solutions" :value="solution">
                                    {{ solution.title }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ errors.solution_id }}
                    </div>
                </div>

            </MDBModalBody>
            <MDBModalFooter>
                <div class="col">
                    <MDBBtn class="btn btn-dark ms-2" @click="close">
                        Finish
                    </MDBBtn>
                </div>
            </MDBModalFooter>
        </MDBModal>
        <ModalErrorComponent ref="modalError"></ModalErrorComponent>
        <ModalConfirmComponent ref="modalConfirm"></ModalConfirmComponent>
        <div>
            <h2>Posterminal Request | {{ modeDisplay }}</h2>
            <div>
                <button type="button" class="btn m-2 btn-outline-warning" data-mdb-ripple-init
                    data-mdb-ripple-color="dark" @click="changeModeDisplay('Unfinished')">
                    Unfinished
                </button>
                <button type="button" class="btn m-2 btn-outline-dark" data-mdb-ripple-init
                    data-mdb-ripple-color="dark" @click="changeModeDisplay('Finished')">
                    Finished
                </button>
                <button type="button" class="btn m-2 btn-outline-danger" data-mdb-ripple-init
                    data-mdb-ripple-color="dark" @click="changeModeDisplay('Canceled')">
                    Canceled
                </button>
                <button type="button" class="btn m-2 btn-outline-primary" data-mdb-ripple-init
                    data-mdb-ripple-color="dark" @click="changeModeDisplay('All')">
                    All
                </button>
            </div>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">status</th>
                        <th scope="col">posterminal</th>
                        <th scope="col">theme</th>
                        <th scope="col">solution</th>
                        <th scope="col">created at</th>
                        <th scope="col">updated at</th>
                        <th scope="col">
                            <button :class="'btn-sm btn btn-light mt-1 me-2'+(userRoleDisplayBtn('create')?'':' d-none')" data-mdb-ripple-init
                                data-mdb-ripple-color="dark"
                                @click="openModalInput" title="Add">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button class="btn-sm btn btn-light mt-1 me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="showRequests" title="Update list">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="request in requests" :class="displayRequest(request.status)">
                        <th scope="row">{{ request.id }}</th>
                        <td :class="'fw-bold '+statusColor(request.status)">{{ convertStatus(request.status) }}</td>
                        <td>{{ request.posterminal.system_id }}</td>
                        <td>{{ request.theme.title }}</td>
                        <td>{{ request.solution==null?'- - - -':request.solution.title }}</td>
                        <td>{{ request.created_at }}</td>
                        <td>{{ request.updated_at }}</td>
                        <td>
                            <button :class="'btn-sm btn btn-dark mt-1 me-2'
                                +(request.status==0&&userRoleDisplayBtn('toWork')?'':' d-none')" data-mdb-ripple-init
                                @click="inWork(request.id)" title="To Work">
                                <i class="fa-solid fa-wrench"></i>
                            </button>
                            <button :class="'btn-sm btn btn-dark mt-1 me-2'
                                +(request.status==1&&userRoleDisplayBtn('finish')?'':' d-none')" data-mdb-ripple-init
                                @click="finish(request)" title="Finish">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button :class="'btn-sm btn btn-dark mt-1 me-2'
                                +((request.status==0||request.status==1)&&userRoleDisplayBtn('cancel')?'':' d-none')" data-mdb-ripple-init
                                @click="cancel(request)" title="Cancel">
                                <i class="fa-solid fa-ban"></i>
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
        name: 'PosterminalRequestComponent',
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
            this.showRequests();
            // this.getPosterminals();
            // this.getThemes();
        },
        data() {
            return {
                requests: [],
                posterminals: [],
                themes: [],
                solutions: [],
                currenRequest: {},
                posterminal_ModalInput: false,
                ModalInputAddSolution: false,
                errors: {},
                modeDisplay: 'Unfinished',
            }
        },
        methods: {
            // getPosterminals() {
            //     axios.post('/api/posterminal/lol')
            //     .then((data) => {
            //         if (data.data[0] == '200') {
            //             this.posterminals = data.data[1];
            //         } else {
            //             this.$refs.modalError.openModalError(data.data[1]);
            //         }
            //     });
            // },
            // getThemes() {
            //     axios.post('/api/posterminal/theme/show')
            //     .then((data) => {
            //         if (data.data[0] == '200') {
            //             this.themes = data.data[1];
            //         } else {
            //             this.$refs.modalError.openModalError(data.data[1]);
            //         }
            //     });
            // },
            showRequests() {
                axios.post('/api/posterminal/request/show')
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.requests = data.data[1];
                        this.posterminals = data.data[2];
                        this.themes = data.data[3];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                });
            },
            create() {
                axios.post('/api/posterminal/request/create', {
                    posterminal_id: this.currenRequest.posterminal.id,
                    theme_id: this.currenRequest.theme.id,
                })
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.closeModalInput();
                        this.requests = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                }).catch((errors) => {
                    for (let field in errors.response.data.errors) {
                        this.errors[field] = errors.response.data.errors[field][0];
                    }
                });
            },
            inWork(id) {
                let confirmationQuestion =  'To Work request with ID: '+id+' ?';
                this.$refs.modalConfirm.openModalConfirme(
                    confirmationQuestion,
                    function (arg) {
                        axios.post('/api/posterminal/request/inwork', {
                            id: arg.id,
                        })
                        .then((data) => {
                            if (data.data[0] == '200') {
                                arg.vue.requests = data.data[1];
                            } else {
                                arg.vue.$refs.modalError.openModalError(data.data[1]);
                            }
                        });
                    },
                    {
                        vue: this,
                        id: id
                    }
                );
            },
            finish(request) {
                this.resetCurrenRequest();
                this.currenRequest.id = request.id;
                this.themes.forEach((theme) => {
                if (theme.id == request.theme.id) {
                        this.currenRequest.theme = theme;
                    }
                });
                this.openModalInputAddSolution();
            },
            close() {
                axios.post('/api/posterminal/request/close', {
                    id: this.currenRequest.id,
                    solution_id: this.currenRequest.solution.id,
                })
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.requests = data.data[1];
                        this.closeModalInputAddSolution();
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                }).catch((errors) => {
                    for (let field in errors.response.data.errors) {
                        this.errors[field] = errors.response.data.errors[field][0];
                    }
                });
            },
            cancel(request) {
                let confirmationQuestion = 'Cancel request with ID: '+request.id+' ?';
                this.$refs.modalConfirm.openModalConfirme(
                    confirmationQuestion,
                    function (arg) {
                        axios.post('/api/posterminal/request/cancel', {
                            id: arg.request.id,
                        })
                        .then((data) => {
                            if (data.data[0] == '200') {
                                arg.vue.requests = data.data[1];
                            } else {
                                arg.vue.$refs.modalError.openModalError(data.data[1]);
                            }
                        });
                    },
                    {
                        vue: this,
                        request: request
                    }
                );
            },
            changeModeDisplay(mode) {
                this.modeDisplay = mode;
            },


            openModalInput() {
                this.errors = {};
                this.resetCurrenRequest();
                this.posterminal_ModalInput = true;
            },
            closeModalInput() {
                this.resetCurrenRequest();
                this.posterminal_ModalInput = false;
            },


            openModalInputAddSolution() {
                this.errors = {};
                this.ModalInputAddSolution = true;
            },
            closeModalInputAddSolution() {
                this.resetCurrenRequest();
                this.ModalInputAddSolution = false;
            },
            resetCurrenRequest() {
                this.currenRequest = {
                    id: 0,
                    posterminal: {},
                    theme: {},
                    solution: {}
                }
            },


            displayRequest(status) {
                if (  (this.modeDisplay == 'Unfinished' && (status == 0 || status == 1))
                    ||(this.modeDisplay == 'Finished' && status == 2)
                    ||(this.modeDisplay == 'Canceled' && status == 3)
                    ||(this.modeDisplay == 'All')
                ) {
                    return '';
                } else {
                    return 'd-none';
                }
            },
            statusColor(status) {
                if (status == 0) {
                    return 'text-success';
                } else if (status == 1) {
                    return 'text-warning'
                } else if (status == 3) {
                    return 'text-danger'
                }
            },
            convertStatus(status) {
                const decodeStatus = ['OPENED ', 'IN WORK', 'FINISHED', 'CANCELED'];
                return decodeStatus[status];
            },
            userRoleDisplayBtn(btn) {
                const role = this.$root.user.role;
                if (role == 'Admin') {
                    return true;
                } else if (role == 'Worker') {
                    if (btn == 'toWork') {
                        return true;
                    } else if (btn == 'finish') {
                        return true;
                    } else {
                        return false;
                    }
                } else if (role == 'Manager') {
                    if (btn == 'toWork') {
                        return false;
                    } else if (btn == 'finish') {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        }
    }
</script>
