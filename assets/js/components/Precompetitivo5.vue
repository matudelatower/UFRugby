<template>
    <div>
        <h4>Datos Médicos</h4>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group" v-bind:class="{ 'has-error': $v.tieneCobertura.$error }">
                    <label class="control-label required">Tiene Cobertura Médica?</label>
                    <div id="appbundle_fichamedica_tieneCobertura">
                        <div class="radio">
                            <label class="required">
                                <input v-model="tieneCobertura" id="appbundle_fichamedica_tieneCobertura_0"
                                       name="appbundle_fichamedica[tieneCobertura]"
                                       required="required" value="1" type="radio"> Sí
                            </label>
                        </div>
                        <div class="radio">
                            <label class="required">
                                <input v-model="tieneCobertura" id="appbundle_fichamedica_tieneCobertura_1"
                                       name="appbundle_fichamedica[tieneCobertura]"
                                       required="required" value="0" type="radio"> No
                            </label>
                        </div>
                    </div>
                    <span class="help-block" v-if="$v.tieneCobertura.$error && !$v.tieneCobertura.required">Campo Requerido</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" v-bind:class="{ 'has-error': $v.prestador.$error }"
                     v-if="tieneCobertura == '1'">
                    <label class="control-label required" for="appbundle_fichamedica_prestador">Prestador</label>
                    <input v-model="prestador"
                           id="appbundle_fichamedica_prestador" name="appbundle_fichamedica[prestador]"
                           required="required"
                           class="tieneCobertura form-control" type="text">
                    <span class="help-block" v-if="$v.prestador.$error && !$v.prestador.required">Campo Requerido</span>
                </div>
                <div class="form-group" v-else>
                    <label class="control-label required" for="appbundle_fichamedica_prestador">Prestador</label>
                    <input v-model="prestador"
                           id="appbundle_fichamedica_prestador" name="appbundle_fichamedica[prestador]"
                           required="required"
                           class="tieneCobertura form-control" type="text">
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group" v-bind:class="{ 'has-error': $v.numeroAfiliado.$error }"
                     v-if="tieneCobertura == '1'">
                    <label class="control-label required"
                           for="appbundle_fichamedica_numeroAfiliado">Nº Afiliado</label>
                    <input v-model="numeroAfiliado"
                           id="appbundle_fichamedica_numeroAfiliado" name="appbundle_fichamedica[numeroAfiliado]"
                           required="required" class="tieneCobertura form-control" type="text">
                    <span class="help-block" v-if="$v.numeroAfiliado.$error && !$v.numeroAfiliado.required">Campo Requerido</span>
                </div>
                <div class="form-group" v-else>
                    <label class="control-label required"
                           for="appbundle_fichamedica_numeroAfiliado">Nº Afiliado</label>
                    <input v-model="numeroAfiliado"
                           id="appbundle_fichamedica_numeroAfiliado" name="appbundle_fichamedica[numeroAfiliado]"
                           required="required" class="tieneCobertura form-control" type="text">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="appbundle_precompetitivo_jugador_altura">Altura</label>
                    <input v-model="altura"
                           id="appbundle_precompetitivo_jugador_altura"
                           name="appbundle_precompetitivo[jugador][altura]"
                           maxlength="255" class="form-control" type="text">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"
                           for="appbundle_precompetitivo_jugador_peso">Peso</label>
                    <input v-model="peso"
                           id="appbundle_precompetitivo_jugador_peso" name="appbundle_precompetitivo[jugador][peso]"
                           maxlength="255" class="form-control" type="text"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" v-bind:class="{ 'has-error': $v.grupoSanguineo.$error }">
                    <label class="control-label required"
                           for="appbundle_fichamedica_grupoSanguineo">Grupo Sanguíneo
                        *</label>
                    <select v-model="grupoSanguineo" id="appbundle_fichamedica_grupoSanguineo"
                            name="appbundle_fichamedica[grupoSanguineo]" required="required"
                            class="form-control">
                        <option value="" selected="selected">Seleccionar</option>
                        <option :value="gs" v-for="gs in grupoSanguineos">{{ gs.nombre }}</option>

                    </select>
                    <span class="help-block" v-if="$v.grupoSanguineo.$error && !$v.grupoSanguineo.required">Campo Requerido</span>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {required} from 'vuelidate/lib/validators'

    export default {
        props: ['categoria'],
        data: function () {
            return {
                tieneCobertura: null,
                numeroAfiliado: null,
                altura: null,
                peso: null,
                prestador: null,
                grupoSanguineo: null,
                grupoSanguineos:[]
            }
        },
        validations() {
            if (this.tieneCobertura == "1") {
                return {
                    tieneCobertura: {required},
                    numeroAfiliado: {required},
                    prestador: {required},
                    grupoSanguineo: {required},

                    form: [
                        'tieneCobertura',
                        'numeroAfiliado',
                        'prestador',
                        'grupoSanguineo'
                    ]
                }
            } else {
                return {
                    tieneCobertura: {required},
                    grupoSanguineo: {required},
                    form: [
                        'tieneCobertura',
                        'grupoSanguineo'
                    ]
                }
            }

        },
        methods: {
            validate() {
                this.$v.form.$touch();
                var isValid = !this.$v.form.$invalid
                this.$emit('on-validate', this.$data, isValid)
                return isValid
            },
            initialize() {
                axios.get(baseUrl + '/ajax-public/grupo-sanguineo').then(response => {

                    this.grupoSanguineos = response.data;

                });
            }
        },
        mounted() {
            console.log('Component ready.')
            this.initialize();
        }
    }
</script>
