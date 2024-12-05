<template>        
    <a-menu
      v-model:openKeys="openKeys"
      v-model:selectedKeys="selectedKeys"
      mode="inline"
    >
        <a-menu-item key="admin-users">            
            <router-link :to="{ name: 'admin-users' }"><TeamOutlined /> <span>Users</span></router-link>
        </a-menu-item>
        <a-menu-item key="admin-roles">
            <router-link :to="{ name: 'admin-roles' }"><TagsOutlined /> <span>Roles</span></router-link>
        </a-menu-item>
        <a-menu-item key="admin-settings">
            <router-link :to="{ name: 'admin-settings' }"><SettingOutlined /> <span>Settings</span></router-link>
        </a-menu-item>
    </a-menu>
</template>

<script>
	import { defineComponent } from 'vue';
    import { storeToRefs } from 'pinia';
    import { useMenu } from "../stores/use-menu.js";
    import { TeamOutlined, TagsOutlined, SettingOutlined } from '@ant-design/icons-vue';

	export default defineComponent({
        components: {
            TeamOutlined, 
            TagsOutlined,
            SettingOutlined
        },
		setup() {
            const store = useMenu();

			return {
                ...storeToRefs(store)
			}
		}
	})
</script>