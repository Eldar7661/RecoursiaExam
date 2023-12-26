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
import PostamatDefectiveComponent from './components/postamat/PostamatDefectiveComponent.vue';
import PostamatSolutionsComponent from './components/postamat/PostamatSolutionsComponent.vue';
import PostamatDeletedComponent from './components/postamat/PostamatDeletedComponent.vue';

import PosterminalActiveComponent from './components/posterminal/PosterminalActiveComponent.vue';
import PosterminalDefectiveComponent from './components/posterminal/PosterminalDefectiveComponent.vue';
import PosterminalSolutionComponent from './components/posterminal/PosterminalSolutionComponent.vue';
import PosterminalRequestComponent from './components/posterminal/PosterminalRequestComponent.vue';
import PosterminalDeletedComponent from './components/posterminal/PosterminalDeletedComponent.vue';

import CardomatActiveComponent from './components/cardomat/CardomatActiveComponent.vue';
import CardomatDefectiveComponent from './components/cardomat/CardomatDefectiveComponent.vue';
import CardomatSolutionsComponent from './components/cardomat/CardomatSolutionsComponent.vue';
import CardomatDeletedComponent from './components/cardomat/CardomatDeletedComponent.vue';

export default createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: HomeComponent, alias: '/', meta:{aHref:'/',title: 'Recoursia 69'}},

        // { path: '/recycler/active',    component: RecyclerActiveComponent,    meta:{aHref:'recycler',title:'Recycler Active'}},
        // { path: '/recycler/defective', component: RecyclerDefectiveComponent, meta:{aHref:'recycler',title:'Recycler Defective'}},
        // { path: '/recycler/solutions', component: RecyclerSolutionsComponent, meta:{aHref:'recycler',title:'Recycler Solutions'}},
        // { path: '/recycler/deleted',   component: RecyclerDeletedComponent,   meta:{aHref:'recycler',title:'Recycler Deleted'}},

        // { path: '/terminal/active',    component: TerminalActiveComponent,    meta:{aHref:'terminal',title:'Terminal Active'}},
        // { path: '/terminal/defective', component: TerminalDefectiveComponent, meta:{aHref:'terminal',title:'Terminal Defective'}},
        // { path: '/terminal/solutions', component: TerminalSolutionsComponent, meta:{aHref:'terminal',title:'Terminal Solutions'}},
        // { path: '/terminal/deleted',   component: TerminalDeletedComponent,   meta:{aHref:'terminal',title:'Terminal Deleted'}},

        { path: '/postamat/active',    component: PostamatActiveComponent,    meta:{aHref:'postamat',title:'Postamat Active'}},
        { path: '/postamat/defective', component: PostamatDefectiveComponent, meta:{aHref:'postamat',title:'Postamat Defective'}},
        { path: '/postamat/solutions', component: PostamatSolutionsComponent, meta:{aHref:'postamat',title:'Postamat Solutions'}},
        { path: '/postamat/deleted',   component: PostamatDeletedComponent,   meta:{aHref:'postamat',title:'Postamat Deleted'}},

        { path: '/posterminal/active',    component: PosterminalActiveComponent,    meta:{aHref:'posterminal',title:'Posterminal | Active'}},
        { path: '/posterminal/defective', component: PosterminalDefectiveComponent, meta:{aHref:'posterminal',title:'Posterminal | Defective'}},
        { path: '/posterminal/solutions', component: PosterminalSolutionComponent, meta:{aHref:'posterminal',title:'Posterminal | Solutions'}},
        { path: '/posterminal/deleted',   component: PosterminalDeletedComponent,   meta:{aHref:'posterminal',title:'Posterminal | Deleted'}},
        { path: '/posterminal/request',   component: PosterminalRequestComponent,   meta:{aHref:'posterminal',title:'Posterminal | Request'}},

        { path: '/cardomat/active',    component: CardomatActiveComponent,    meta:{aHref:'cardomat',title:'Cardomat Active'}},
        { path: '/cardomat/defective', component: CardomatDefectiveComponent, meta:{aHref:'cardomat',title:'Cardomat Defective'}},
        { path: '/cardomat/solutions', component: CardomatSolutionsComponent, meta:{aHref:'cardomat',title:'Cardomat Solutions'}},
        { path: '/cardomat/deleted',   component: CardomatDeletedComponent,   meta:{aHref:'cardomat',title:'Cardomat Deleted'}},

    ]
});
