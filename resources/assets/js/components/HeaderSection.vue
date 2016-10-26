<template>
    <div class="header-section">

        <!--logo and logo icon start-->
        <div class="logo dark-logo-bg hidden-xs hidden-sm">
            <a href="index.html">
                <img src="img/logo-icon.png" alt="">
                <!--<i class="fa fa-maxcdn"></i>-->
                <span class="brand-name">SlickLab</span>
            </a>
        </div>

        <div class="icon-logo dark-logo-bg hidden-xs hidden-sm">
            <a href="index.html">
                <img src="img/logo-icon.png" alt="">
                <!--<i class="fa fa-maxcdn"></i>-->
            </a>
        </div>
        <!--logo and logo icon end-->


        <!--mega menu start-->
            <!--mega menu end-->
            <div class="notification-wrap">
                <!--right notification start-->
                <div class="right-notification">
                    <ul class="notification-menu">
                        <li>
                            <a href="javascript:;" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <img src="img/avatar-mini.jpg" alt="">{{ auth.user.profile.name }}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu purple pull-right">
                                <li>
                                    <a href="javascript:void()" @click.prevent="signout()"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <!--right notification end-->
        </div>
    </div>
</template>
<script>
    import auth from '../auth.js';
    export default {
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
        ready() {
            auth.check();
        }
    }
</script>
