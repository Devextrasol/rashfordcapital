<template>
    <div>
        <div id="chat-messages" ref="con">
            <div v-for="message in messages">
                <template v-if="!message.presence">
                    <a :href="'/users/' + message.user.id" target="_blank"><i class="user icon"></i></a>
                    <a href="#!" @click="copyPasteUserName(message.user.name)">{{ message.user.name }}</a>
                    <span>{{ message.message }}</span>
                </template>
                <template v-else>
                    <span class="italic">{{ message.message }}</span>
                </template>
            </div>
        </div>
        <div v-if="users.length" class="mt-1">
            <span :class="['ui label', color]">{{ __('app.online') }}</span>
            <span v-for="user in users">
                <a href="#!" @click="copyPasteUserName(user.name)">{{ user.name }}</a>&nbsp;
            </span>
        </div>
        <div class="mt-1">
            <div class="ui fluid action input">
                <input type="text" v-model="message" ref="message" class="form-control" :placeholder="__('app.your_message')" @keyup.enter="sendMessage">
                <button :class="['ui button', color]" @click="sendMessage">{{ __('app.send') }}</button>
            </div>
        </div>
    </div>
</template>
<script type="text/babel">
    import Echo from 'laravel-echo'
    import Pusher from 'pusher-js'
    import UtilsMixin from './mixins/utils.vue'

    export default {
        mixins: [UtilsMixin],
        props: ['user'],
        data() {
            return {
                message: '',
                messages: [],
                users: []
            }
        },
        computed: {
            color() {
                return this.config('settings.color');
            }
        },
        methods: {
            copyPasteUserName(name) {
                this.message += name + ' ';
                this.$refs.message.focus();
            },
            sendMessage() {
                if (!this.message)
                    return false;

                var message = {
                    message: this.message,
                    user: this.user
                };
                this.addMessage(message);

                axios.post('/chat/messages/send', {
                        message: this.message
                    })
                    .then(response => {
                        if (response.data.success) {
                            //
                        }
                    });

                this.message = '';
            },
            addMessage(message) {
                this.messages.push(message);
                this.scrollToBottom();
            },
            // automatically scroll messages area to bottom
            scrollToBottom() {
                this.$nextTick(() => {
                    // https://stackoverflow.com/a/270628/2767324
                    this.$refs.con.scrollTop = this.$refs.con.scrollHeight;
                });
            }
        },
        created() {
            var echo = new Echo({
                broadcaster:    'pusher',
                key:            this.config('broadcasting.connections.pusher.key'),
                cluster:        this.config('broadcasting.connections.pusher.options.cluster'),
                encrypted:      true
            });

            // listen for new chat messages
            echo.join('chat')
                // currently joined users
                .here(users => {
                    this.users = users;
                })
                // new user joined
                .joining(user => {
                    this.users.push(user);
                    this.addMessage({ presence: true, message: user.name + ' ' + this.__('app.joined') });
                })
                // user left
                .leaving(user => {
                    this.users = this.users.filter(u => {
                        return u.id != user.id;
                    });
                    this.addMessage({ presence: true, message: user.name + ' ' + this.__('app.left') });
                })
                // new message
                .listen('ChatMessageSent', message => {
                    this.addMessage(message);
                });

            // get initial chat messages
            axios.get('/chat/messages/get')
                .then(response => {
                    this.messages = response.data.messages;
                    this.scrollToBottom();
                });
        }
    }
</script>