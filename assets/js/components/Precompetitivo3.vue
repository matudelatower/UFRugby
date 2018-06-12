<template>
    <div>

        <h4>Completá tus datos personales</h4>


        <div class="row">
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.tipoIdentificacion.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_tipoIdentificacion">Tipo de Identificación
                    *</label>
                    <select v-model="tipoIdentificacion" id="appbundle_precompetitivo_tipoIdentificacion"
                            name="appbundle_precompetitivo[tipoIdentificacion]" required="required"
                            class="form-control">
                        <option value="" selected="selected">Seleccionar</option>
                        <option :value="ti" v-for="ti in tiposIdentificacion">{{ ti.nombre }}</option>

                    </select>
                    <span class="help-block" v-if="$v.tipoIdentificacion.$error && !$v.tipoIdentificacion.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.numeroIdentificacion.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_numeroIdentificacion">Nº
                    identificación</label>
                    <input v-model="numeroIdentificacion" id="appbundle_precompetitivo_numeroIdentificacion"
                           name="appbundle_precompetitivo[numeroIdentificacion]"
                           required="required" class="form-control" type="text" @blur="buscarPersona">

                    <span class="help-block" v-if="$v.numeroIdentificacion.$error && !$v.numeroIdentificacion.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.sexo.$error }"><label
                        class="control-label required" for="appbundle_precompetitivo_sexo">Sexo
                    *</label>
                    <select v-model="sexo" id="appbundle_precompetitivo_sexo" name="appbundle_precompetitivo[sexo]"
                            :disabled="disableFields"
                            required="required" class="form-control">
                        <option value="" selected="selected">Seleccionar</option>
                        <option :value="s" v-for="s in sexos">{{ s.nombre }}</option>
                    </select>
                    <span class="help-block" v-if="$v.sexo.$error && !$v.sexo.required">Campo Requerido</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.apellido.$error }">
                    <label
                            class="control-label required" for="appbundle_precompetitivo_apellido">Apellido</label>
                    <input v-model="apellido"
                           :disabled="disableFields"
                           id="appbundle_precompetitivo_apellido" name="appbundle_precompetitivo[apellido]"
                           required="required" maxlength="255" class="form-control" type="text">
                    <span class="help-block" v-if="$v.apellido.$error && !$v.apellido.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.nombre.$error }"><label
                        class="control-label required" for="appbundle_precompetitivo_nombre">Nombre</label>
                    <input v-model="nombre"
                           :disabled="disableFields"
                           id="appbundle_precompetitivo_nombre" name="appbundle_precompetitivo[nombre]"
                           required="required"
                           maxlength="255" class="form-control" type="text">
                    <span class="help-block" v-if="$v.nombre.$error && !$v.nombre.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" v-bind:class="{ 'has-error': $v.fechaNacimiento.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_fechaNacimiento">Fecha
                    nacimiento</label>
                    <input v-model="fechaNacimiento" id="appbundle_precompetitivo_fechaNacimiento"
                           :disabled="disableFields"
                           autocomplete="off"
                           name="appbundle_precompetitivo[fechaNacimiento]" required="required"
                           class="form-control" type="date">

                    <span class="help-block" v-if="$v.fechaNacimiento.$error && !$v.fechaNacimiento.required">Campo Requerido</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" v-bind:class="{ 'has-error': $v.direccion.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_contacto_direccion">Direccion</label>
                    <input v-model="direccion"
                           :disabled="disableFields"
                           id="appbundle_precompetitivo_contacto_direccion"
                           name="appbundle_precompetitivo[contacto][direccion]" required="required" maxlength="255"
                           class="form-control" type="text">
                    <span class="help-block" v-if="$v.direccion.$error && !$v.direccion.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group" v-bind:class="{ 'has-error': $v.telefono.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_contacto_telefono">Telefono</label>
                    <input v-model="telefono"
                           :disabled="disableFields"
                           id="appbundle_precompetitivo_contacto_telefono"
                           name="appbundle_precompetitivo[contacto][telefono]" required="required" maxlength="255"
                           class="form-control" type="text">
                    <span class="help-block" v-if="$v.telefono.$error && !$v.telefono.required">Campo Requerido</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label"
                           for="appbundle_precompetitivo_contacto_telefonoAlternativo">Teléfono alternativo</label>
                    <input v-model="telefonoAlternativo" id="appbundle_precompetitivo_contacto_telefonoAlternativo"
                           :disabled="disableFields"
                           name="appbundle_precompetitivo[contacto][telefonoAlternativo]"
                           maxlength="255" class="form-control" type="text">

                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" v-bind:class="{ 'has-error': $v.mail.$error }"><label
                        class="control-label required"
                        for="appbundle_precompetitivo_contacto_mail">Mail</label>
                    <input v-model="mail"
                           :disabled="disableFields"
                           id="appbundle_precompetitivo_contacto_mail" name="appbundle_precompetitivo[contacto][mail]"
                           required="required" class="form-control" type="email">

                    <span class="help-block" v-if="$v.mail.$error && !$v.mail.required">Campo Requerido</span>
                    <span class="help-block" v-if="$v.mail.$error && !$v.mail.email">El mail no es valido</span>
                </div>
                <span class="text-yellow">Este mail se utilizará para enviar la confirmación</span>
            </div>
            <div class="col-md-6"></div>
        </div>

        <template v-if="finalModel.categoria !== 'referee'">

            <h3>Datos de Juego</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" v-bind:class="{ 'has-error': $v.club.$error }"><label
                            class="control-label required"
                            for="appbundle_precompetitivo_jugador_clubJugador_0_club">Club
                        *</label>
                        <select v-model="club" id="appbundle_precompetitivo_jugador_clubJugador_0_club"
                                name="appbundle_precompetitivo[jugador][clubJugador][0][club]" required="required"
                                class="form-control">
                            <option value="" selected="selected">Seleccionar Club</option>
                            <option :value="c" v-for="c in clubs">{{ c.nombre }}</option>
                        </select>

                        <span class="help-block" v-if="$v.club.$error && !$v.club.required">Campo Requerido</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" v-bind:class="{ 'has-error': $v.posicionHabitual.$error }"><label
                            class="control-label required"
                            for="appbundle_precompetitivo_jugador_posicionHabitual">Posición Habitual
                        *</label>
                        <select v-model="posicionHabitual" id="appbundle_precompetitivo_jugador_posicionHabitual"
                                name="appbundle_precompetitivo[jugador][posicionHabitual]" required="required"
                                class="form-control">
                            <option value="" selected="selected">Seleccionar Posición</option>
                            <option :value="p" v-for="p in posiciones">{{ p.numero }} - {{ p.nombre }}</option>
                        </select>
                        <span class="help-block" v-if="$v.posicionHabitual.$error && !$v.posicionHabitual.required">Campo Requerido</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group"><label
                            class="control-label"
                            for="appbundle_precompetitivo_jugador_posicionAlternativa">Posicion
                        alternativa</label>
                        <select v-model="posicionAlternativa" id="appbundle_precompetitivo_jugador_posicionAlternativa"
                                name="appbundle_precompetitivo[jugador][posicionAlternativa]"
                                class="form-control">
                            <option value=""></option>
                            <option :value="p" v-for="p in posiciones">{{ p.numero }} - {{ p.nombre }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label"
                               for="appbundle_precompetitivo_jugador_segundaPosicionAlternativa">Segunda
                            posicion alternativa</label>
                        <select v-model="segundaPosicionAlternativa"
                                id="appbundle_precompetitivo_jugador_segundaPosicionAlternativa"
                                name="appbundle_precompetitivo[jugador][segundaPosicionAlternativa]"
                                class="form-control">
                            <option value=""></option>
                            <option :value="p" v-for="p in posiciones">{{ p.numero }} - {{ p.nombre }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </template>

        <BlockUI message="Buscando Persona..." v-show="cargando"></BlockUI>

    </div>
</template>

<script>
    import {required, email} from 'vuelidate/lib/validators'

    export default {
        props: [
            'finalModel'
        ],
        data: function () {
            return {
                apellido: null,
                nombre: null,
                sexo: null,
                tipoIdentificacion: null,
                numeroIdentificacion: null,
                fechaNacimiento: null,
                direccion: null,
                telefono: null,
                telefonoAlternativo: null,
                mail: null,
                club: null,
                posicionHabitual: null,
                posicionAlternativa: null,
                segundaPosicionAlternativa: null,
                sexos: [],
                tiposIdentificacion: [],
                clubs: [],
                posiciones: [],
                disableFields: true,
                cargando: false,
                estadoFichaje: []
            }
        },
        validations() {
            if (this.finalModel.categoria !== 'referee') {
                return {
                    apellido: {required},
                    nombre: {required},
                    sexo: {required},
                    tipoIdentificacion: {required},
                    numeroIdentificacion: {required},
                    fechaNacimiento: {required},
                    direccion: {required},
                    telefono: {required},
                    mail: {required, email},
                    club: {required},
                    posicionHabitual: {required},

                    form: [
                        'apellido',
                        'nombre',
                        'sexo',
                        'tipoIdentificacion',
                        'numeroIdentificacion',
                        'fechaNacimiento',
                        'direccion',
                        'telefono',
                        'mail',
                        'club',
                        'posicionHabitual',
                    ]
                }
            } else {
                return {
                    apellido: {required},
                    nombre: {required},
                    sexo: {required},
                    tipoIdentificacion: {required},
                    numeroIdentificacion: {required},
                    fechaNacimiento: {required},
                    direccion: {required},
                    telefono: {required},
                    mail: {required, email},

                    form: [
                        'apellido',
                        'nombre',
                        'sexo',
                        'tipoIdentificacion',
                        'numeroIdentificacion',
                        'fechaNacimiento',
                        'direccion',
                        'telefono',
                        'mail',
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
                axios.get(baseUrl + '/ajax-public/sexos').then(response => {

                    this.sexos = response.data;

                });

                axios.get(baseUrl + '/ajax-public/tipos-identificacion').then(response => {

                    this.tiposIdentificacion = response.data;

                });

                axios.get(baseUrl + '/ajax-public/club').then(response => {

                    this.clubs = response.data;

                });

                axios.get(baseUrl + '/ajax-public/posicion').then(response => {

                    this.posiciones = response.data;

                });
            },
            buscarPersona() {
                console.log('buscando', this.numeroIdentificacion);
                if (this.numeroIdentificacion == '' || !this.numeroIdentificacion) {
                    return false;
                }
                this.cargando = true;
                if (this.numeroIdentificacion) {
                    let params = {
                        params: {
                            tipo: this.tipoIdentificacion,
                            numero: this.numeroIdentificacion
                        }
                    }
                    axios.get(baseUrl + '/ajax-public/search-persona', params).then(response => {
                        console.log('response', response);

                        this.disableFields = false;

                        this.apellido = response.data.apellido;
                        this.nombre = response.data.nombre;
                        this.sexo = {
                            'id': response.data.sexo.id,
                            'nombre': response.data.sexo.nombre
                        };
                        this.fechaNacimiento = response.data.fechaNacimiento;
                        this.direccion = response.data.direccion;
                        this.telefono = response.data.telefono;
                        this.telefonoAlternativo = response.data.telefonoAlternativo;
                        this.mail = response.data.mail;
                        this.estadoFichaje = response.data.estadoFichaje;

                        if (this.estadoFichaje) {
                            window.$('#modal-alert').modal('toggle');
                            let mensaje = 'Ya completaste tu ficha este año. <br>' +
                                'Si cargaste mal alguno de tus datos, comunicate con la Unión'
                            window.$('#modal-alert .modal-body').html(mensaje);
                            this.$emit('show-next', false);
                        }

                        this.cargando = false;


                    }).catch(error => {
                        console.error(error);

                        this.apellido = null;
                        this.nombre = null;
                        this.sexo = null;
                        this.fechaNacimiento = null;
                        this.direccion = null;
                        this.telefono = null;
                        this.telefonoAlternativo = null;
                        this.mail = null;

                        this.disableFields = false;
                        this.cargando = false;
                        this.$emit('show-next', true);

                    });
                }
            }
        },
        mounted() {
            console.log('Component ready.')
            this.initialize();
        }
    }
</script>
