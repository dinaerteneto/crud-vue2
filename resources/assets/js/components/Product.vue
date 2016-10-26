<template>
    <section>
        <div class="wrapper">
            <div class="modal fade" id="modal-form-product" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Formulário</h4>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-danger alert-dismissible" role="alert" v-if="formErrors">
                              <p v-for="formError in formErrors">
                                {{ formError }}
                            </p>
                        </div>

                        <form class="" enctype="multipart/form-data">
                            <div class="">
                                <div class="form-group">
                                    <label class="" for="image">Imagem</label> 
                                    <input type="file" name="image" class="form-control" id="image" @change="processFile($event)" />
                                </div>
                                <div class="form-group">
                                    <!--<a href="javascript:void()" @click.prevent="addCategoria" class="pull-right">add categoria</a> -->
                                    <label class="" for="image">Categorias</label> 
                                    <select class="form-control" id="categoria" multiple="multiple" style="width: 100%" v-model="selected" placeholder="Seleciona a imagem">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input id="product_name" type="text" class="form-control" placeholder="Nome" v-model="record.name">
                                </div>
                                <div class="form-group">
                                    <textarea id="product_description" class="form-control" placeholder="Descrição" v-model="record.description"></textarea>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" @click.prevent="save()">Enviar</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading head-border">Produtos <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#modal-form-product" @click.prevent="create()">Adicionar</button></header>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th width="10%">Imagem</th>
                                <th>Categorias</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Ações</th>
                            </thead>
                            <tbody>
                                <tr v-for="record in records">
                                    <td>{{ record.id }}</td>
                                    <td><img :src=record.image></td>
                                    <td width="20%">
                                        <span v-for="category in record.categories" class="label label-info label-mini">
                                            {{ category.name }}
                                        </span>
                                    </td>
                                    <td>{{ record.name }}</td>
                                    <td>{{ record.description }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" href="javascript:void()" @click.prevent="edit(record)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        <button class="btn btn-danger btn-xs" href="javascript:void()" @click.prevent="remove(record)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </section>
    </template>
    <script>

        require('block-ui');

        export default {
            data() {
                return {
                    title: 'Produtos',
                    record: {
                        categories: [],
                    },
                    records: [],
                    formErrors: null,
                    categories: [],
                    selected: [],
                    image: null
                }
            },
            methods: {

              processFile: function(event) {
                this.image = event.target.files[0];
            },

            save: function() {
                $.blockUI({ message: '<h1>Carregando...</h1>' });
                if(this.record.id!= null) {
                    //update
                    var formData = this.formSerialize();
                    this.$http.post(`http://localhost:8000/api/product/update/${this.record.id}`, formData, {
                        emulateHTTP: true
                    }).then(
                    (response)=>{
                        this.formErrors = response.data.error.dev;
                        if(this.formErrors === ''){
                            $('#modal-form-product').modal('hide');
                            this.record = {};
                        }
                    },
                    error => {
                        console.log(error);
                    }).finally(function(){
                        this.load();
                        $('#modal-form-product').modal('hide');
                        $.unblockUI();
                    });
                } else {
                    //insert
                    var formData = this.formSerialize();
                    this.$http.post(`http://localhost:8000/api/product`,formData, {
                        emulateHTTP: true
                    }).then(
                    (response) => {
                        this.formErrors = response.data.error.dev;
                        if(this.formErrors === ''){
                            $('#modal-form-product').modal('hide');
                        }
                    },
                    error => {
                    }).finally(
                    function() {
                        this.load();
                        $('#modal-form-product').modal('hide');
                        $.unblockUI();
                    });
            }
        },
        remove: function(record) {
            $.blockUI({ message: '<h1>Carregando...</h1>' });
            this.$http.delete(`http://localhost:8000/api/product/${record.id}`).then(
                (response) => {
                    this.record = {};
                    alert('produto excluído com sucesso.');
                },
                error => {
                    console.log(error);
                }).finally(function(){
                    this.load();
                    $.unblockUI();
                }
                );
            },
            create: function() {
                this.record = {};
                this.selected = [];
                categories: [];
                this.formErrors = null;
            },
            edit: function(record) {
                this.formErrors = null;
                this.record = record;
                var categories = [];
                for(var x in record.categories) {
                    categories.push(record.categories[x]['id_product_category']);
                }
                this.selected = categories;
                $("#categoria").select2().val(categories).trigger('change');
                $('#modal-form-product').modal('show');
            },
            getCategories: function() {
                this.$http.get(`http://localhost:8000/api/product-category/get-data`).then(
                    (response)=>{
                        this.categories = response.data;
                        $('#categoria').select2({data: response.data});
                    },
                    error=>{
                        console.log(error);
                    });
            },
            formSerialize: function() {
                var categories = $('#categoria').select2('val');
                var formData = new FormData();
                for (var keyA in categories) {
                    formData.append('ProductCategory['+keyA+']', categories[keyA]);
                }
                for(var keyB in this.record) {
                    formData.append('Product['+keyB+']', this.record[keyB]);
                }
                formData.append('Image', this.image);
                return formData;
            },
            load: function() {
                $.blockUI({ message: '<h1>Carregando...</h1>' });
                this.$http.get(`http://localhost:8000/api/product`).then(
                    (response)=>{
                        this.records = response.data.response.data;
                    },
                    error=>{
                        console.log(error);
                    }).finally(
                    function() {
                         $.unblockUI();
                    });
                }
            },
            created: function() {
                this.load();
                this.getCategories();
                $(document).ready(function($){
                    $("#categoria").select2({
                        theme: 'classic',
                        placeholder: "Selecione as categorias",
                        allowClear: true
                    });
                });
            }
        }
    </script>