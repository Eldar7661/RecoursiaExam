<template>
    <main class="mt-5 d-flex flex-column align-items-center">
        <div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input v-model="user.email" @focus="changeValueinput"
                    type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input v-model="user.password" @focus="changeValueinput"
                    type="password" class="form-control" id="exampleInputPassword1">
            </div>

            <div :class="'mb-3 text-danger'+(incorrectUser?'':' d-none')">
                incorrect login or password
            </div>

            <button class="btn btn-primary" @click="singin">Sing in</button>
        </div>
    </main>
</template>

<script>
import axios from 'axios';
    window.genAdmin = function () {
        let status = 200;
        axios.post('/api/user/deleteMe')
        .then((data) => {
            console.log(data.data[1]);
        })
        .catch((data) => {
            status = 95;
        });

        return status==200?'geniration':'error gen.';
    };
    export default {
        name: 'LoginComponent',
        data() {
            return {
                user: {
                    email: '',
                    password: ''
                },
                incorrectUser: false,
            }
        },
        methods: {
            singin() {
                axios.post('/api/auth/login', this.user)
                .then((data) => {
                    const token = data.data.access_token;
                    localStorage.setItem('access_token', token);
                    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
                    this.$root.me();
                    this.$router.push('/');
                }).catch((data) => {
                    if (data.response.status == 401) {
                        this.incorrectUser = true;
                    }
                });
            },
            changeValueinput() {
                this.incorrectUser = false;
            }
        }
    }
</script>
