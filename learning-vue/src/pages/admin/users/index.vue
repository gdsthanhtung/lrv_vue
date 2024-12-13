<template>
    <a-card title="User List" style="width: 100%;">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <a-button type="primary">
                    <router-link :to="{ name: 'admin-users-create' }"><PlusOutlined /></router-link>
                </a-button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <a-table :dataSource="dataSource" :columns="columns" :scroll="{ x: 576 }">
                    <template #bodyCell="{ column, index, record }">
                        <template v-if="column.key === 'index'">
                            <span>{{ index + 1 }}</span>
                        </template>

                        <template v-if="column.key === 'avatar'">
                            <a-image :src="`http://localhost:5173/public/images/user/default/user-avatar.jpg`" :preview="false" :height="50" :width="50" class="rounded-circle" />
                        </template>

                        <template v-if="column.key === 'status'">
                            <span v-if="record.status.id == 3" class="text-primary">{{ record.status.value }}</span>
                            <span v-else-if="record.status.id == 4" class="text-danger">{{ record.status.value }}</span>
                        </template>

                        <template v-if="column.key === 'action'">
                            <a-button class="p-1 me-1" type="link">
                                <router-link :to="{ name: 'admin-users-edit', params:{id: record.id} }"><EditOutlined /></router-link>
                            </a-button>
                            <a-button class="p-1" type="link"><span class="text-danger"><DeleteOutlined @click="showModalDeleteUser(record.id)"/></span></a-button>
                        </template>
                    </template>
                </a-table>
            </div>
        </div>
    </a-card>
    <a-modal v-model:open="deleteUserModal" title="Delete User Confirmation" ok-text="Yes" cancel-text="No" @ok="hideModal">
      <p>Are you sure?</p>
    </a-modal>
</template>

<script>
import { defineComponent, ref, createVNode } from "vue";
import { useMenu } from "../../../stores/use-menu.js";
import { PlusOutlined, EditOutlined, DeleteOutlined, ExclamationCircleOutlined } from '@ant-design/icons-vue';
import { message, Modal } from "ant-design-vue";

export default defineComponent({
    components: {
        PlusOutlined, EditOutlined, DeleteOutlined, ExclamationCircleOutlined //icon
    },
    setup() {
        useMenu().onSelectedKeys(['admin-users']);

        // Handle data-table
        const dataSource = ref([]);
        const columns = [
            {
                title: '#',
                dataIndex: 'index',
                key: 'index',
                fixed: "left"
            },
            {
                title: 'Username',
                dataIndex: 'username',
                key: 'username',
                fixed: "left"
            },
            {
                title: 'Avatar',
                dataIndex: 'avatar',
                key: 'avatar',
            },
            {
                title: 'Fullname',
                dataIndex: 'name',
                key: 'name',
            },
            {
                title: 'Email',
                dataIndex: 'email',
                key: 'email',
            },
            {
                title: 'Department',
                dataIndex: ['department', 'name'],
                key: 'department.name',
            },
            {
                title: 'Roles',
                dataIndex: 'roles.name',
                key: 'roles.name',
            },
            {
                title: 'Status',
                dataIndex: ['status', 'value'],
                key: 'status',
            },
            {
                title: 'Action',
                fixed: "right",
                key: 'action',
            }
        ]

        // Execute get list data
        const getData = () => {
            axios.get('http://127.0.0.1:8000/api/users')
                .then(function (response) {
                    dataSource.value = response.data;
                    //console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // Execute delete user
        const deleteUser = (userId) => {
            axios.delete(`http://127.0.0.1:8000/api/users/${userId}`)
                .then(function (response) {
                    //console.log(response);
                    if(response.status == 200){
                        if(response) message.success('Request successful execution');
                        getData();
                    }else{
                        message.error('Request execution failed');
                    }                    
                })
                .catch(function (error) {
                    console.log(error);
                    message.error('Request execution failed');
                });
        }

        // Handle delete user modal
        const deleteUserModal = ref(false);
        const showModalDeleteUser = (userId) => {
            deleteUserModal.value = true; // Open modal
            deleteUserModal.userId = userId;
        };
        const hideModal = () => {
            deleteUserModal.value = false; // Close modal
            deleteUser(deleteUserModal.userId);
        };

        // Execute functions
        getData();

        // Export data / functions ...
        return {
            dataSource, columns, deleteUser, showModalDeleteUser, hideModal, deleteUserModal
        };
    }
})
</script>