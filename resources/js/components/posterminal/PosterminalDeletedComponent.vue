<template>
    <main class="mt-5 d-flex flex-column align-items-center">
        <ModalErrorComponent ref="modalError"></ModalErrorComponent>
        <ModalConfirmComponent ref="modalConfirm"></ModalConfirmComponent>
        <div>
            <h2>Posterminal Deleted</h2>
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
                        <th scope="col">
                            <button class="btn-sm btn btn-light me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                                @click="showPosterminals" title="Update list">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="posterminal in posterminals">
                        <th scope="row">{{ posterminal.id }}</th>
                        <td class="fw-bold text-danger">
                            {{ posterminal.status == '1'? 'ON':'OFF' }}
                        </td>
                        <td class="text-danger">{{ posterminal.system_id }}</td>
                        <td class="text-danger">{{ posterminal.address }}</td>
                        <td class="text-danger">{{ posterminal.serial_number }}</td>
                        <td class="text-danger">{{ posterminal.created_at }}</td>
                        <td class="text-danger">{{ posterminal.updated_at }}</td>
                        <td>
                            <button class="btn-sm btn btn-dark me-2" data-mdb-ripple-init
                                @click="restore(posterminal.id)" title="Restore">
                                <i class="fa-solid fa-trash-can-arrow-up"></i>
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

    export default {
        name: 'PosterminalDeletedComponent',
        components: {
            ModalErrorComponent,
            ModalConfirmComponent,
        },
        mounted() {
            this.showPosterminals();
        },
        data() {
            return {
                posterminals: null,
            }
        },
        methods: {
            showPosterminals(){
                axios.post('/api/posterminal/deleted/show')
                .then((data) => {
                    if (data.data[0] == '200') {
                        this.posterminals = data.data[1];
                    } else {
                        this.$refs.modalError.openModalError(data.data[1]);
                    }
                });
            },
            restore(posterminalId) {
                let confirmationQuestion = 'Restore posterminal with ID: '+posterminalId+' ?';
                this.$refs.modalConfirm.openModalConfirme(
                    confirmationQuestion,
                    function (arg) {
                        axios.post('/api/posterminal/restore', {
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
            }
        },
    }
</script>
