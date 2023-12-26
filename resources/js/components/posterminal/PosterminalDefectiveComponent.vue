<template>
    <main class="mt-5 d-flex flex-column align-items-center">
        <MDBModal
            id="posterminal_ModalInput"
            tabindex="-1"
            labelledby="ModalInputLabel"
            v-model="posterminal_ModalInput"
        >
            <MDBModalHeader>
                <MDBModalTitle id="ModalInputLabel">{{ mode + ' Theme' }}</MDBModalTitle>
            </MDBModalHeader>
            <MDBModalBody>
                <div :class="'row mt-4'+(currentTheme.id!='0'?'':' d-none')">
                    <span class="col-sm-4 fs-5">ID</span>
                    <div class="col-sm-4">
                        {{ currentTheme.id }}
                    </div>
                </div>

                <div class="row mt-4">
                    <label for="posterminal_title" class="col-sm-3
                    col-form-label fs-5">Title</label>
                    <div class="col-sm-5">
                        <textarea class="form-control" rows="2" maxlength="50"
                            id="posterminal_title" v-model="currentTheme.title">
                        </textarea>
                    </div>
                    <div class="col-sm-4 text-danger">
                        {{ errors.title }}
                    </div>
                </div>

                <div class="row mt-4">
                    <label for="posterminal_description" class="col-sm-3
                    col-form-label fs-5">Description</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" rows="3" maxlength="255"
                            id="posterminal_description" v-model="currentTheme.description">
                        </textarea>
                    </div>
                    <div class="col-sm-3 text-danger">
                        {{ errors.description }}
                    </div>
                </div>

            </MDBModalBody>
            <MDBModalFooter>
                <div class="col">
                    <MDBBtn class="btn btn-dark"
                        @click="createOrUpdateTheme">
                        {{ mode == 'Add'?'Create':'Update' }}
                    </MDBBtn>
                </div>
            </MDBModalFooter>
        </MDBModal>
        <ModalErrorComponent ref="modalError"></ModalErrorComponent>
        <ModalConfirmComponent ref="modalConfirm"></ModalConfirmComponent>
        <div>
            <h2>Posterminal Defective</h2>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col">
                            <button class="btn-sm btn btn-light mt-1 me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="openModalInput('Add')" title="Add">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button class="btn-sm btn btn-light mt-1 me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="showThemes" title="Update list">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="theme in themes">
                        <th scope="row">{{ theme.id }}</th>
                        <td>{{ theme.title }}</td>
                        <td>{{ theme.description }}</td>
                        <td>{{ theme.created_at }}</td>
                        <td>{{ theme.updated_at }}</td>
                        <td>
                            <button class="btn-sm btn btn-dark mt-1 me-2" data-mdb-ripple-init
                                @click="openModalInput('Edit', theme)" title="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="btn-sm btn btn-dark mt-1 me-2" data-mdb-ripple-init
                                @click="remove(theme.id)" title="Delete">
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
        name: 'PosterminalDefectiveComponent',
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
            this.showThemes();
        },
        data() {
            return {
                themes: [],
                posterminal_ModalInput: false,
                mode: '',
                currentTheme: {},
                errors: {},
            }
        },
        methods: {
            showThemes() {
                axios.post('/api/posterminal/theme/show')
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.themes = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                });
            },
            createOrUpdateTheme() {
                this.errors = {};
                let url = '/api/posterminal/theme/'
                    +(this.mode == 'Add'?'create':'update');
                axios.post(url, this.currentTheme)
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.closeModalInput();
                        this.themes = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                }).catch((errors) => {
                    for (let field in errors.response.data.errors) {
                        this.errors[field] = errors.response.data.errors[field][0];
                    }
                });
            },
            remove(themeId) {
                let confirmationQuestion = 'Delete theme with ID: '+themeId+' ?';
                this.$refs.modalConfirm.openModalConfirme(
                    confirmationQuestion,
                    function (arg) {
                        axios.post('/api/posterminal/theme/delete', {
                            id: arg.id
                        })
                        .then((data) => {
                            if (data.data[0] == '200') {
                                arg.vue.themes = data.data[1];
                            } else {
                                arg.vue.$refs.modalError.openModalError(data.data[1]);
                            }
                        });
                    },
                    {
                        id: themeId,
                        vue: this
                    }
                );
            },
            openModalInput(mode, theme=null) {
                this.errors = {};
                this.posterminal_ModalInput = true;
                this.mode = mode;
                if (theme == null) {
                    this.currentTheme = {
                        id: '0',
                        title: '',
                        description: '',
                    };
                } else {
                    this.currentTheme = {
                        id: theme.id,
                        title: theme.title,
                        description: theme.description,
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
