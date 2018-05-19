<template>
    <div v-html="texto">
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                texto: null,
            }
        },
        mounted() {
            console.log('Component ready.')
            this.initialize();
        },
        methods: {
            initialize() {
                axios.get(baseUrl + '/ajax-public/texto-ficha-medica').then(response => {

                    this.texto = response.data;

                });
            }
        }
    }
</script>
