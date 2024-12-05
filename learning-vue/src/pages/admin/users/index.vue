<template>
    <h3>User page</h3>    
</template>

<script>
    import { useMenu } from "../../../stores/use-menu.js";

    export default {
        setup() {
            useMenu().onSelectedKeys(['admin-users']);
        }
    }
</script>