<template>
    <div>
        <div class="row">
            <div class="col-md-12" v-html="textoConsentimiento">
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="form-group" v-bind:class="{ 'has-error': $v.consentimiento.$error }">
                    <label>
                        ACEPTACIÓN <input type="checkbox" id="checkbox" v-model="consentimiento">
                    </label>
                    <span class="help-block" v-if="$v.consentimiento.$error && !$v.consentimiento.required">Debe aceptar el consentimiento para continuar</span>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
    import {required} from 'vuelidate/lib/validators'

    export default {
        data: function () {
            return {
                consentimiento: null,
                textoConsentimiento: null,
            }
        },
        validations: {
            consentimiento: {required},

            form: [
                'consentimiento'
            ]

        },
        methods: {
            validate() {
                this.$v.form.$touch();
                var isValid = !this.$v.form.$invalid
                this.$emit('on-validate', this.$data, isValid)
                return isValid
            },
            initialize() {
                axios.get(baseUrl + '/ajax-public/texto-consentimiento').then(response => {

                    this.textoConsentimiento = response.data;

                });
            }
        },
        mounted() {
            console.log('Component ready.')
            this.initialize();
        }
    }
</script>
