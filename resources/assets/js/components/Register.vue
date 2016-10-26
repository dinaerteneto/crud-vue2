<template>
    <section class="login-body">

      <section class="login-body">
        <div class="login-logo">
          <img src="img/login_logo.png" alt=""/>
      </div>

      <h2 class="form-heading">cadastre-se</h2>
      <div class="container log-row">

        <div class="alert alert-danger" v-if="error && !success">
            <p>Houve algum erro. Não foi possível completar seu cadastro</p>
        </div>
        <div class="alert alert-success" v-if="success">
            <p>Registro completo. Agora você já pode efetuar seu login. <a href="/#">Fazer login</a></p>
        </div>
        <form autocomplete="off" class="form-signin" v-on:submit="register" v-if="!success" >
            <div class="login-wrap">
                <p>Digite seus dados</p>
                <div class="form-group" v-bind:class="{ 'has-error': error && response.username }">
                    <input type="text" placeholder="Nome completo" id="name" class="form-control" v-model="name" required>
                    <span class="help-block" v-if="error && response.name">{{ response.name }}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': error && response.email }">
                    <input type="email" placeholder="Email" id="email" class="form-control" v-model="email" required>
                    <span class="help-block" v-if="error && response.email">{{ response.email }}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': error && response.password }">
                    <input type="password" placeholder="Senha" id="password" class="form-control" v-model="password" required>
                    <span class="help-block" v-if="error && response.password">{{ response.password }}</span>
                </div>
                <div class="registration m-t-20 m-b-20">
                    <button type="submit" class="btn btn-lg btn-success btn-block">Enviar</button>
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
                name: null,
                email: null,
                password: null,
                success: false,
                error: false,
                response: null
            }
        },
        methods: {
            register(event) {
                event.preventDefault();
                auth.register(this, this.name, this.email, this.password);
            }
        }
    }
</script>