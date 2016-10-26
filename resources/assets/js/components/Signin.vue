<template>
    <section>
        <div class="alert alert-danger" v-if="error">
            <p>Usuário e/ou senha inválidos(s)</p>
        </div>
        <form autocomplete="off" v-on:submit="signin">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="gavin.belson@hooli.com" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
            </div>
            <button type="submit" class="btn btn-default">Login</button>
        </form>
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