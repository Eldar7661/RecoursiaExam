<template>
    <div class="container">
        <h3 class="text mt-4 mb-3">Deleted Card</h3>
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
                    <th scope="col">Deleted</th>
                    <th scope="col">Activity</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(deletedCard, key) of deletedCards" :key="key">
                    <td>{{ deletedCard.id }}</td>
                    <td>
                        {{ deletedCard.status === 0 ? 'active' : (deletedCard.status === 1 ? 'inactive' : '') }}
                    </td>
                    <td>{{ deletedCard.system_id }}</td>
                    <td>{{ deletedCard.address }}</td>
                    <td>{{ deletedCard.serial_number }}</td>
                    <td>{{ deletedCard.created_at }}</td>
                    <td>{{ deletedCard.updated_at }}</td>
                    <td>{{ deletedCard.deleted_at }}</td>
                    <td style="display: flex; gap: 3px;">
                        <button type="button" class="btn btn-sm btn-dark" @click="restoredeletedCard(deletedCard)"><i class="fa-solid fa-trash-arrow-up"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                deletedCards: [],
            };
        },

        mounted() {
            let vue = this;
            axios.get('/api/cardomat/deleted')
            .then((response) => {
                if (response.data.status) {
                    vue.deletedCards = response.data.deletedCards;
                }
            })
            .catch((error) => {
                console.error('Error fetching deleted cards', error);
            });
        },

        methods: {
            restoredeletedCard(deletedCard) {
                axios
                .post(`/api/cardomat/restore/${deletedCard.id}`)
                .then((response) => {
                if (response.data.status) {
                    this.deletedCards = response.data.deletedCards;
                }
                })
                .catch((error) => {
                console.log(error);
                });
            },
        }
    }

</script>
