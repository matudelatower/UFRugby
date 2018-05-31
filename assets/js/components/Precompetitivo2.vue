<template>
    <div>
        <h4>Seleccioná una opción *</h4>

        <div class="form-group" v-bind:class="{ 'has-error': $v.categoria.$error }">
            <div class="radio">
                <label>
                    <input name="categoria" required class="optionsRadios2" v-model="categoria"
                           value="infantil"
                           type="radio">
                    Infantil (no competitivo)
                </label>
            </div>

            <div class="radio">
                <label>
                    <input name="categoria" required class="optionsRadios2" v-model="categoria"
                           value="menor"
                           type="radio">
                    Menor de 18 años
                </label>
            </div>

            <div class="radio">
                <label>
                    <input name="categoria" required class="optionsRadios2" v-model="categoria"
                           value="mayor"
                           type="radio">
                    Mayor de 18 años
                </label>
            </div>

            <div class="radio">
                <label>
                    <input name="categoria" required class="optionsRadios2" v-model="categoria"
                           value="referee"
                           type="radio">
                    Referee (No jugador)
                </label>
            </div>

            <span class="help-block"
                  v-if="$v.categoria.$error && !$v.categoria.required">* Debe elegir una opcion</span>
        </div>
    </div>
</template>

<script>
    import {required, minLength, between} from 'vuelidate/lib/validators'

    export default {
        data: function () {
            return {
                categoria: null
            }
        },
        validations: {
            categoria: {
                required
            },

            form: ['categoria']
        },
        methods: {
            validate() {
                this.$v.form.$touch();
                var isValid = !this.$v.form.$invalid
                this.$emit('on-validate', this.$data, isValid)
                return isValid
            }
        }
    }
</script>
