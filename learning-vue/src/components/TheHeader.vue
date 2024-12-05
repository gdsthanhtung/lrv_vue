<template>
	<div class="container-fluid px-0">
		<div class="row text-white" style="background-color: #298459; padding: 1rem;">
			<div class="col-1 d-flex d-sm-none align-items-center justify-content-center">
				<span @click="showDrawerMenu()"><MenuOutlined /></span>
			</div>

			<div class="col-10 col-sm-9 d-flex align-items-center justify-content-center justify-content-sm-start">
				<img src="../assets/logo.svg" alt="Logo" height="32" width="34" class="ms-3 me-3">
				<span class="d-none d-sm-flex">ADMIN PAGE</span>
			</div>

			<div class="col-sm-3 d-none d-sm-flex align-items-center justify-content-sm-end">
				Hi bro!
			</div>

			<div class="col-1 d-flex d-sm-none align-items-center justify-content-center">
				<span @click="showDrawerUser()"><UserOutlined /></span>
			</div>
		</div>
	</div>

	<a-drawer v-model:open="openMenu" title="MENU" placement="left">
		<TheMenu />
	</a-drawer>

	<a-drawer v-model:open="openUser" title="ADMIN" placement="right">
		<p>Some contents user...</p>
		<p>Some contents user...</p>
		<p>Some contents user...</p>
	</a-drawer>
</template>

<script>
	import TheMenu from "../components/TheMenu.vue";
	import { defineComponent, ref } from 'vue';
	import { MenuOutlined, UserOutlined } from '@ant-design/icons-vue';

	export default defineComponent({
		components: {
			TheMenu,
			MenuOutlined,
			UserOutlined,
		},
		setup() {
			const openMenu = ref(false);
			const openUser = ref(false);

			const showDrawerMenu = () => {
				openMenu.value = true;
			};

			const showDrawerUser = () => {
				openUser.value = true;
			};

			return {
				openMenu, openUser, showDrawerMenu, showDrawerUser
			}
		}
	})
</script>