<template>
    <section>
        <section v-if="auth.user.authenticated">
            <side-bar-left></side-bar-left>
            <div class="body-content">
                <header-section></header-section>
                <page-head></page-head>
                <router-view></router-view>
                <footer>
                    2016 © Dinaerte Neto
                </footer>
            </div>
        </section>
        <section v-if="!auth.user.authenticated">
            <router-view></router-view>
        </section>
    </section>
</template>
<script>
    import SideBarLeft from './SideBarLeft.vue';
    import HeaderSection from './HeaderSection.vue';
    import PageHead from './PageHead.vue';
    import Login from './Login.vue';
    import auth from '../auth.js';

    export default {
        components: {
            login: Login,
            sideBarLeft: SideBarLeft,
            headerSection: HeaderSection,
            pageHead: PageHead
        },
        data() {
            return {
                auth: auth
            }
        },
        methods: {
            signout() {
                auth.signout();
            }
        },
        created() {
            auth.check();
        }
    }
</script>
