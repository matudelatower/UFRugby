<template>
    <div>
        <slot name="textoPresentacion"></slot>
    </div>
</template>

<script>
    export default {
        props:{

        },
        methods:{
        },
        mounted() {
            console.log('Component ready.')
        }
    }
</script>
