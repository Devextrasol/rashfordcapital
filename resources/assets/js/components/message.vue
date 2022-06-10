<template>
    <div v-show="!hidden" class="ui message">
        <i class="close icon" @click="hide"></i>
        <div class="header">
            <slot></slot>
        </div>
        <ul v-if="messages" v-for="item in messages" class="list">
            <li>{{ item }}</li>
        </ul>
        <p v-if="message">
            {{ message }}
        </p>
    </div>
</template>
<script type="text/babel">
    export default {
        props: ['message','messages'],
        data() {
            return {
                hidden: false
            }
        },
        methods: {
            hide() {
                this.hidden = true;
            }
        }
    }
</script>