<script type="text/babel">
    export default {
        props: [],
        data() {
            return {
                submitted: false
            }
        },
        methods: {
            disableButton() {
                this.submitted = true;
            }
        }
    }
</script>