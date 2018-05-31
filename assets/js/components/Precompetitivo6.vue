<template>
    <div>

        <h3>Datos Personales</h3>

        <div class="row">
            <div class="col-md-6">
                <label>Nombre y apellido:</label><span> {{ finalModel.nombre }} {{ finalModel.apellido }}</span><br>
                <label>Fecha de Nacimiento:</label><span> {{ finalModel.fechaNacimiento }} </span><br>
                <label>Nº de Identificación:</label><span> {{ finalModel.tipoIdentificacion ? finalModel.tipoIdentificacion.nombre : '' }}: {{ finalModel.numeroIdentificacion }}</span><br>
                <label>Dirección:</label><span> {{ finalModel.direccion }}</span><br>
                <label>Tel:</label><span> {{ finalModel.telefono }}</span><br>
                <label>Tel Alternativo:</label><span> {{ finalModel.telefonoAlternativo }}</span><br>
                <label>Mail:</label><span> {{ finalModel.mail }}</span><br>
            </div>
        </div>
        <template v-if="finalModel.categoria == 'menor' || finalModel.categoria == 'mayor'">
            <h3>Datos Médicos</h3>

            <div class="row">
                <div class="col-md-6">
                    <label>Cobertura Médica:</label><span> {{ finalModel.prestador }}</span><br>
                    <label>Grupo sanguíneo:</label><span> {{ finalModel.grupoSanguineo ? finalModel.grupoSanguineo.nombre : '' }}</span><br>
                    <label>Peso:</label><span> {{ finalModel.peso }}</span><br>
                    <label>Altura:</label><span> {{ finalModel.altura }}</span><br>
                </div>
            </div>
        </template>

        <template v-if="finalModel.categoria !== 'referee'">
        <h3>Datos de Juego</h3>

        <div class="row">
            <div class="col-md-6">
                <label>Club:</label><span> {{ finalModel.club ? finalModel.club.nombre : '' }}</span><br>
                <label>Posición en la que juega:</label><span> {{ finalModel.posicionHabitual? finalModel.posicionHabitual.nombre: '' }} | {{ finalModel.posicionAlternativa? finalModel.posicionAlternativa.nombre:'' }} | {{ finalModel.segundaPosicionAlternativa? finalModel.segundaPosicionAlternativa.nombre:'' }}</span><br>
            </div>
        </div>
        </template>

        <template v-if="finalModel.responsableApellido">
            <h3>Responsable</h3>

            <div class="row">
                <div class="col-md-6">
                    <label>Nombre y Apellido:</label><span> {{ finalModel.responsableNombre }} {{ finalModel.responsableApellido }}</span><br>
                    <label>Documento:</label><span> {{ finalModel.responsableTipoIdentificacion ? finalModel.responsableTipoIdentificacion.nombre : '' }}: {{ finalModel.responsableNumeroIdentificacion }}</span><br>
                    <label>Relación:</label><span> {{ finalModel.responsableRelacion? finalModel.responsableRelacion.nombre: '' }} </span><br>
                    <label>Tel:</label><span> {{ finalModel.responsableTelefono }}</span><br>
                    <label>Mail:</label><span> {{ finalModel.responsableMail }}</span><br>

                </div>
            </div>
        </template>

        <p class="text-red">Antes de enviar la solicitud verificá que los datos sean correctos</p>

    </div>
</template>

<script>
    export default {
        props: [
            'finalModel'
        ],
        mounted() {
            console.log('Component ready.')
        }
    }
</script>
