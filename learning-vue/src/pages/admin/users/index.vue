<template>
    <h3 class="mt-1">User page</h3>
    <a-list bordered :data-source="data">
        <template #renderItem="{ item }">
            <a-list-item>{{ item }}</a-list-item>
        </template>
        <template #header>
            <div>Header</div>
        </template>
        <template #footer>
            <div>Footer</div>
        </template>
    </a-list>
</template>

<script setup>
const data = [
    'Racing car sprays burning fuel into crowd.',
    'Japanese princess to wed commoner.',
    'Australian walks 100km after outback crash.',
    'Man charged over missing wedding girl.',
    'Los Angeles battles huge wildfires.',
];
</script>