import { createRouter, createWebHistory} from 'vue-router';

import HomeComponent from './components/home/HomeComponent.vue';


// import RecyclerActiveComponent from './components/recycler/RecyclerActiveComponent.vue';
// import RecyclerDefectiveComponent from './components/recycler/RecyclerDefectiveComponent.vue';
// import RecyclerSolutionsComponent from './components/recycler/RecyclerSolutionsComponent.vue';
// import RecyclerDeletedComponent from './components/recycler/RecyclerDeletedComponent.vue';

// import TerminalActiveComponent from './components/terminal/TerminalActiveComponent.vue';
// import TerminalDefectiveComponent from './components/terminal/TerminalDefectiveComponent.vue';
// import TerminalSolutionsComponent from './components/terminal/TerminalSolutionsComponent.vue';
// import TerminalDeletedComponent from './components/terminal/TerminalDeletedComponent.vue';

import PostamatActiveComponent from './components/postamat/PostamatActiveComponent.vue';
import PostamatThemesComponent from './components/postamat/PostamatThemesComponent.vue';
import PostamatSolutionsComponent from './components/postamat/PostamatSolutionsComponent.vue';
import PostamatDeletedComponent from './components/postamat/PostamatDeletedComponent.vue';
import PostamatRequestsComponent from './components/postamat/PostamatRequestsComponent.vue';

import PosterminalActiveComponent from './components/posterminal/PosterminalActiveComponent.vue';
import PosterminalDefectiveComponent from './components/posterminal/PosterminalDefectiveComponent.vue';
import PosterminalSolutionComponent from './components/posterminal/PosterminalSolutionComponent.vue';
import PosterminalRequestComponent from './components/posterminal/PosterminalRequestComponent.vue';
import PosterminalDeletedComponent from './components/posterminal/PosterminalDeletedComponent.vue';

import CardomatActiveComponent from './components/cardomat/CardomatActiveComponent.vue';
import CardomatDefectiveComponent from './components/cardomat/CardomatDefectiveComponent.vue';
import CardomatSolutionsComponent from './components/cardomat/CardomatSolutionsComponent.vue';
import CardomatDeletedComponent from './components/cardomat/CardomatDeletedComponent.vue';
import CardomatRequestsComponent from './components/cardomat/CardomatRequestsComponent.vue';

import UserLoginComponent from './components/user/LoginComponent.vue';
import UserComponent from './components/user/UserComponent.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        // { path: '/recycler/active',    name: 'recycler.active',      component: RecyclerActiveComponent,      meta:{aHref:'recycler',title:'Recycler Active'}},
        // { path: '/recycler/defective', name: 'recycler.defective',   component: RecyclerDefectiveComponent,   meta:{aHref:'recycler',title:'Recycler Defective'}},
        // { path: '/recycler/solutions', name: 'recycler.solutions',   component: RecyclerSolutionsComponent,   meta:{aHref:'recycler',title:'Recycler Solutions'}},
        // { path: '/recycler/deleted',   name: 'recycler.deleted',     component: RecyclerDeletedComponent,     meta:{aHref:'recycler',title:'Recycler Deleted'}},

        // { path: '/terminal/active',    name: 'terminal.active',      component: TerminalActiveComponent,      meta:{aHref:'terminal',title:'Terminal Active'}},
        // { path: '/terminal/defective', name: 'terminal.defective',   component: TerminalDefectiveComponent,   meta:{aHref:'terminal',title:'Terminal Defective'}},
        // { path: '/terminal/solutions', name: 'terminal.solutions',   component: TerminalSolutionsComponent,   meta:{aHref:'terminal',title:'Terminal Solutions'}},
        // { path: '/terminal/deleted',   name: 'terminal.deleted',     component: TerminalDeletedComponent,     meta:{aHref:'terminal',title:'Terminal Deleted'}},

        { path: '/postamat/active',       name: 'postamat.active',      component: PostamatActiveComponent,      meta:{aHref:'postamat',title:'Postamat Active'}},
        { path: '/postamat/defective',    name: 'postamat.defective',   component: PostamatDefectiveComponent,   meta:{aHref:'postamat',title:'Postamat Defective'}},
        { path: '/postamat/solutions',    name: 'postamat.solutions',   component: PostamatSolutionsComponent,   meta:{aHref:'postamat',title:'Postamat Solutions'}},
        { path: '/postamat/deleted',      name: 'postamat.deleted',     component: PostamatDeletedComponent,     meta:{aHref:'postamat',title:'Postamat Deleted'}},
        { path: '/postamat/requests',     name: 'postamat.requests',    component: PostamatRequestsComponent,    meta:{aHref:'postamat',title:'Postamat Requests'}},

        { path: '/posterminal/active',    name: 'posterminal.active',   component: PosterminalActiveComponent,   meta:{aHref:'posterminal',title:'Posterminal | Active'}},
        { path: '/posterminal/defective', name: 'posterminal.defective',component: PosterminalDefectiveComponent,meta:{aHref:'posterminal',title:'Posterminal | Defective'}},
        { path: '/posterminal/solutions', name: 'posterminal.solutions',component: PosterminalSolutionComponent, meta:{aHref:'posterminal',title:'Posterminal | Solutions'}},
        { path: '/posterminal/deleted',   name: 'posterminal.deleted',  component: PosterminalDeletedComponent,  meta:{aHref:'posterminal',title:'Posterminal | Deleted'}},
        { path: '/posterminal/request',   name: 'posterminal.request',  component: PosterminalRequestComponent,  meta:{aHref:'posterminal',title:'Posterminal | Request'}},

        { path: '/cardomat/active',       name: 'cardomat.active',      component: CardomatActiveComponent,      meta:{aHref:'cardomat',title:'Cardomat Active'}},
        { path: '/cardomat/defective',    name: 'cardomat.defective',   component: CardomatDefectiveComponent,   meta:{aHref:'cardomat',title:'Cardomat Defective'}},
        { path: '/cardomat/solutions',    name: 'cardomat.solutions',   component: CardomatSolutionsComponent,   meta:{aHref:'cardomat',title:'Cardomat Solutions'}},
        { path: '/cardomat/deleted',      name: 'cardomat.deleted',     component: CardomatDeletedComponent,     meta:{aHref:'cardomat',title:'Cardomat Deleted'}},
        { path: '/cardomat/requests',     name: 'cardomat.requests',    component: CardomatRequestsComponent,    meta:{aHref:'cardomat',title:'Cardomat Requests'}},

        { path: '/user/login',            name: 'user.login',           component: UserLoginComponent,           meta:{aHref:'user',title:'User | Log in'}},
        { path: '/users',                 name: 'users',                component: UserComponent,                meta:{aHref:'user',title:'User | table'}},

        { path: '/', name: 'home', component: HomeComponent, meta:{aHref:'/',title: 'Recoursia 69', alias: '/'}},
        // { path: '/*', component: HomeComponent, meta:{aHref:'/',title: 'Recoursia 69'}}
    ]
});

router.beforeEach((to, from, next) => {
    const access_token = localStorage.getItem('access_token');

    let toName = to.name;
    const formName = from.name;

    go();

    async function go() {
        await posterminal();
        await nextPage();
    }

    async function posterminal() {
        if (to.meta.aHref == 'posterminal' || to.meta.aHref == 'user') {
            if (access_token) {
                await axios.post('/api/auth/me')
                .then((data) => {
                    const role = data.data.role;
                    if (to.name == 'user.login') {
                        toName = formName;
                        return 0;
                    }
                    if (role == 'Manager' && to.name == 'users') {
                        toName = formName;
                    } else if (role == 'Worker' && !(to.name == 'posterminal.request')) {
                        toName = formName;
                    }
                })
                .catch((data) => {
                    if (data.response.status == 401) {
                        toName = 'user.login';
                    }
                });
            } else {
                toName = 'user.login';
            }
        }
    }

    async function nextPage() {
        if (to.name == toName) {
            document.title = to.meta.title || 'Recoursia 69';
            const selectorAFrom = document.querySelector(`a[href="${from.meta.aHref}"]`);
            const selectorATo = document.querySelector(`a[href="${to.meta.aHref}"]`);
            navButtonColor(selectorATo, selectorAFrom);
            next();
        } else {
            router.options.routes.forEach(route => {
                if (route.name == toName) {
                    document.title = route.meta.title || 'Recoursia 69';
                }
            });
            return next({
                name: toName
            });
        }
    }

    function navButtonColor(toButton, fromButton) {
        if (toButton) {
            toButton.classList.add('nav-btn-active');
        }
        if (fromButton && fromButton != toButton) {
            fromButton.classList.remove('nav-btn-active');
        }
    }

});

export default router;
