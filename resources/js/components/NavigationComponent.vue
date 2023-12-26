<template>
    <div>
        <nav class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <router-link to="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <img src="/image/logo.png">
                </router-link>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="recycler" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Recycler
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <!-- <router-link class="nav-link" to="/recycler/active">Active</router-link> -->
                            </li>
                            <li>
                                <!-- <router-link class="nav-link" to="/recycler/defective">Defective</router-link> -->
                            </li>
                            <li>
                                <!-- <router-link class="nav-link" to="/recycler/solutions">Solutions</router-link> -->
                            </li>
                            <li>
                                <!-- <router-link class="nav-link" to="/recycler/deleted">Deleted Recycler</router-link> -->
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="terminal" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Terminal
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <!-- <router-link class="nav-link" to="/terminal/active">Active</router-link> -->
                            </li>
                            <li>
                                <!-- <router-link class="nav-link" to="/terminal/defective">Defective</router-link> -->
                            </li>
                            <li>
                                <!-- <router-link class="nav-link" to="/terminal/solutions">Solutions</router-link> -->
                            </li>
                            <li>
                                <!-- <router-link class="nav-link" to="/terminal/deleted">Deleted Terminal</router-link> -->
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="postamat" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Postamat
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <router-link class="nav-link" to="/postamat/active">Active</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/postamat/defective">Defective</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/postamat/solutions">Solutions</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/postamat/deleted">Deleted Postamat</router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="posterminal" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Posterminal
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <router-link class="nav-link" to="/posterminal/active">Active</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/posterminal/defective">Defective</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/posterminal/solutions">Solutions</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/posterminal/request">Request</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/posterminal/deleted">Deleted Posterminal</router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="cardomat" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cardomat
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <router-link class="nav-link" to="/cardomat/active">Active</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/cardomat/defective">Defective</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/cardomat/solutions">Solutions</router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="/cardomat/deleted">Deleted Cardomat</router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        </nav>
        <router-view></router-view>
    </div>
  </template>


<script>
    export default {
        name: 'NavigationComponent',
    }
</script>
