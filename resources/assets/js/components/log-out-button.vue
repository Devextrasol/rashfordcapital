<template>
    <a @click.prevent="logout">
        <slot></slot>
        <form ref="form" method="POST" action="/logout">
            <input type="hidden" name="_token" :value="token">
        </form>
    </a>
</template>
<script type="text/babel">
    export default {
        props: ['token'],
        methods: {
            logout() {
                this.$refs.form.submit();
            }
        }
    }
</script>