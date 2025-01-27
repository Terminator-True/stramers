<template>

<div class="">

</div>


</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        },
        notificaciones: {
            type: Array,
            required: true
        },
        selected: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            message: 'Hello World'
        }
    }
}
</script>
