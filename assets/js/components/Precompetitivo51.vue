<template>
    <div>
        <h4>RESPONSABLE</h4>
        <h3>Completá tus datos como responsable de inscribir al menor</h3>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.responsableApellido.$error }">
                    <label
                            class="control-label required" for="appbundle_precompetitivo_responsableApellido">Apellido</label>
                    <input v-model="responsableApellido"
                           id="appbundle_precompetitivo_responsableApellido" name="appbundle_precompetitivo[responsableApellido]"
                           required="required" maxlength="255" class="form-control" type="text">
                    <span class="help-block" v-if="$v.responsableApellido.$error && !$v.responsableApellido.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.responsableNombre.$error }"><label
                        class="control-label required" for="appbundle_precompetitivo_responsableNombre">Nombre</label>
                    <input v-model="responsableNombre"
                           id="appbundle_precompetitivo_responsableNombre" name="appbundle_precompetitivo[responsableNombre]"
                           required="required"
                           maxlength="255" class="form-control" type="text">
                    <span class="help-block" v-if="$v.responsableNombre.$error && !$v.responsableNombre.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.responsableRelacion.$error }"><label
                        class="control-label required" for="appbundle_precompetitivo_responsableRelacion">Relación *</label>
                    <select v-model="responsableRelacion" id="appbundle_precompetitivo_responsableRelacion" name="appbundle_precompetitivo[responsableRelacion]"
                            required="required" class="form-control">
                        <option value="" selected="selected">Seleccionar</option>
                        <option :value="tr" v-for="tr in tiposRelacion">{{ tr.nombre }}</option>
                    </select>
                    <span class="help-block" v-if="$v.responsableRelacion.$error && !$v.responsableRelacion.required">Campo Requerido</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.responsableTipoIdentificacion.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_responsableTipoIdentificacion">Tipo de Identificación
                    *</label>
                    <select v-model="responsableTipoIdentificacion" id="appbundle_precompetitivo_responsableTipoIdentificacion"
                            name="appbundle_precompetitivo[responsableTipoIdentificacion]" required="required"
                            class="form-control">
                        <option value="" selected="selected">Seleccionar</option>
                        <option :value="ti" v-for="ti in tiposIdentificacion">{{ ti.nombre }}</option>

                    </select>
                    <span class="help-block" v-if="$v.responsableTipoIdentificacion.$error && !$v.responsableTipoIdentificacion.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.responsableNumeroIdentificacion.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_responsableNumeroIdentificacion">Nº
                    identificación</label>
                    <input v-model="responsableNumeroIdentificacion" id="appbundle_precompetitivo_responsableNumeroIdentificacion"
                           name="appbundle_precompetitivo[responsableNumeroIdentificacion]"
                           required="required" class="form-control" type="text">

                    <span class="help-block" v-if="$v.responsableNumeroIdentificacion.$error && !$v.responsableNumeroIdentificacion.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group" v-bind:class="{ 'has-error': $v.responsableTelefono.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_contacto_responsableTelefono">Teléfono</label>
                    <input v-model="responsableTelefono"
                           id="appbundle_precompetitivo_contacto_responsableTelefono"
                           name="appbundle_precompetitivo[contacto][responsableTelefono]" required="required" maxlength="255"
                           class="form-control" type="text">
                    <span class="help-block" v-if="$v.responsableTelefono.$error && !$v.responsableTelefono.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group" v-bind:class="{ 'has-error': $v.responsableMail.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_contacto_responsableMail">Mail</label>
                    <input v-model="responsableMail"
                           id="appbundle_precompetitivo_contacto_responsableMail" name="appbundle_precompetitivo[contacto][responsableMail]"
                           required="required" class="form-control" type="mail">

                    <span class="help-block" v-if="$v.responsableMail.$error && !$v.responsableMail.required">Campo Requerido</span>
                    <span class="help-block" v-if="$v.responsableMail.$error && !$v.responsableMail.email">El mail no es valido</span>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>
</template>

<script>
    import {required, email} from 'vuelidate/lib/validators'
    export default {
        data: function () {
            return {
                responsableApellido: null,
                responsableNombre: null,
                responsableTipoIdentificacion: null,
                responsableNumeroIdentificacion: null,
                responsableTelefono: null,
                responsableMail: null,
                responsableRelacion: null,

                tiposIdentificacion:[],
                tiposRelacion: []
            }
        },
        validations: {
            responsableApellido: {required},
            responsableNombre: {required},
            responsableTipoIdentificacion: {required},
            responsableNumeroIdentificacion: {required},
            responsableTelefono: {required},
            responsableMail: {required, email},
            responsableRelacion: {required},

            form: [
                'responsableApellido',
                'responsableNombre',
                'responsableTipoIdentificacion',
                'responsableNumeroIdentificacion',
                'responsableTelefono',
                'responsableMail',
                'responsableRelacion'
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


                axios.get(baseUrl + '/ajax-public/tipos-identificacion').then(response => {

                    this.tiposIdentificacion = response.data;

                });

                axios.get(baseUrl + '/ajax-public/tipo-relacion').then(response => {

                    this.tiposRelacion = response.data;

                });


            }
        },
        mounted() {
            console.log('Component ready.')
            this.initialize();
        }
    }
</script>
