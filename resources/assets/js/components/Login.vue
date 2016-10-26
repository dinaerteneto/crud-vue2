<template>
  
  <section class="login-body">
    <div class="login-logo">
      <img src="img/login_logo.png" alt=""/>
    </div>

    <h2 class="form-heading">login</h2>
    <div class="container log-row">
      <form class="form-signin" autocomplete="off" v-on:submit="signin">
        <div class="login-wrap">

        <div class="alert alert-danger" v-if="error">
            Nome de usuário e/ou senha inválido
        </div>
        <div class="alert alert-success">
          usuario: admin@admin.com.br <br />
          senha: admin <br />
          ou <router-link to="/register">Cadastre-se</router-link>
        </div>

          <input type="text" class="form-control" v-model="email" placeholder="User ID" autofocus>
          <input type="password" class="form-control" placeholder="Password" v-model="password">
          <div class="registration m-t-20 m-b-20">
            <button class="btn btn-lg btn-success btn-block" type="submit">LOGIN</button>
          </div>

          <div class="registration">
            <router-link to="/register">Cadastre-se</router-link>
          </div>
        </div>

      </form>
    </div>
  </section>

</template>
<script>
import auth from '../auth.js';

export default {
    data() {
            return {
                email: null,
                password: null,
                error: false
            }
        },
        methods: {
            signin(event) {
                event.preventDefault();
                auth.signin(this, this.email, this.password);
            }
        }
}
</script>