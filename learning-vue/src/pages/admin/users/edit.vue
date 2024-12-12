<template>
    <form @submit.prevent="submitForm()">
        <a-card title="Edit User" style="width: 100%;">
            <div class="row">
                <div class="col-12 col-sm-4 mb-3">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mb-3">
                            <a-avatar :size="164">
                                <template #icon>
                                    <UserOutlined />
                                </template>
                            </a-avatar>
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                            <a-button type="primary">
                                <template #icon>
                                    <UploadOutlined />
                                </template>
                                <span>Upload image...</span>
                            </a-button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-8">
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{'text-danger': errors.status_id}">Status:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-select 
                                v-model:value="status_id" 
                                show-search 
                                placeholder="Select a status..." 
                                style="width: 100%"
                                :options="optionsStatuses"
                                :filter-option="filterOption"
                                :class="{'el-danger': errors.status_id}"
                            ></a-select>
                            <small v-if="errors.status_id" class="text-danger">* {{ errors.status_id[0] }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{'text-danger': errors.username}">Username:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input 
                                v-model:value="username" 
                                placeholder="Enter username..." 
                                :class="{'el-danger': errors.username}"
                                allow-clear/>
                            <small v-if="errors.username" class="text-danger">* {{ errors.username[0] }}</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{'text-danger': errors.name}">Name:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input 
                                v-model:value="name" 
                                placeholder="Enter name..." 
                                :class="{'el-danger': errors.name}"
                                allow-clear/>
                            <small v-if="errors.name" class="text-danger">* {{ errors.name[0] }}</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{'text-danger': errors.email}">Email:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input 
                                v-model:value="email" 
                                placeholder="Enter email..." 
                                :class="{'el-danger': errors.email}"
                                allow-clear/>
                            <small v-if="errors.email" class="text-danger">* {{ errors.email[0] }}</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{'text-danger': errors.department_id}">Department:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-select 
                                v-model:value="department_id" 
                                show-search 
                                placeholder="Select a department..." 
                                style="width: 100%"
                                :options="optionsDepartments"
                                :filter-option="filterOption"
                                :class="{'el-danger': errors.department_id}"
                            ></a-select>
                            <small v-if="errors.department_id" class="text-danger">* {{ errors.department_id[0] }}</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end"></div>
                        <div class="col-12 col-sm-5">
                            <a-checkbox v-model:checked="change_password">
                                Change Password?
                            </a-checkbox>
                        </div>
                    </div>
                    
                    <div class="row mb-3" v-if="change_password == true">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{'text-danger': errors.password}">Password:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password 
                                v-model:value="password" 
                                placeholder="Enter password..." 
                                :class="{'el-danger': errors.password}"
                                allow-clear />
                            <small v-if="errors.password" class="text-danger">* {{ errors.password[0] }}</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3" v-if="change_password == true">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{'text-danger': errors.password_confirmation}">Confirm Password:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password 
                                v-model:value="password_confirmation" 
                                placeholder="Enter confirm password..." 
                                :class="{'el-danger': errors.password_confirmation}"
                                allow-clear />
                            <small v-if="errors.password_confirmation" class="text-danger">* {{ errors.password_confirmation[0] }}</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Roles:</span>
                            </label>
                        </div>
                        <div class="col-2 col-sm-2">
                            <a-checkbox-group v-model:value="role_id" :options="optionsRoles" />
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span>Last login at:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5"><span>{{ (login_at == null) ? 'N/A' : login_at}}</span></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span>Last change password at:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5"><span>{{ (change_password_at == null) ? 'N/A' : change_password_at }}</span></div>
                    </div>

                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 d-none d-sm-flex"></div>
                        <div class="col-12 col-sm-5 d-grid d-sm-flex">
                            <a-button type="primary mb-2 mb-sm-0" html-type="submit">
                                <span>Submit</span>
                            </a-button>
                            <a-button type="text" class="me-sm-2">
                                <router-link :to="{ name: 'admin-users' }"><span>Cancel</span></router-link>                            
                            </a-button>
                        </div>
                    </div>
                </div>
            </div>
        </a-card>
    </form>
</template>

<script>
import { defineComponent, ref, reactive, toRefs } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useMenu } from "../../../stores/use-menu.js";
import { UserOutlined, UploadOutlined } from '@ant-design/icons-vue';
import { message } from 'ant-design-vue';

export default defineComponent({
    components: {
        UserOutlined, UploadOutlined
    },
    setup() {
        // Include left menu
        useMenu().onSelectedKeys(['admin-users']);

        // Use redirect func
        const router = useRouter();
        const route = useRoute();

        // Default value of selectboxes
        const optionsDepartments = ref([]);
        const optionsRoles = ref([]);
        const optionsStatuses = ref([]);

        // Default value of elements
        const errors = ref([]);
        const userId = 0;

        //const changePassword = ref(false);
        const user = reactive({
            username: "",
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            department_id: [],
            status_id: [],
            role_id: [],
            change_password: false,
            login_at: null,
            change_password_at: null
        });

        // Allow filter by uppercase/lowercase in selectbox
        const filterOption = (input, option) => {
            return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
        };

        // Get data from Backend
        const getStatuses = () => {
            axios.get('http://127.0.0.1:8000/api/enumerations?for=selectbox&refTable=users')
                .then(function (response) {
                    optionsStatuses.value = response.data;
                    //console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // Get data from Backend
        const getDepartments = () => {
            axios.get('http://127.0.0.1:8000/api/departments?for=selectbox')
                .then(function (response) {
                    optionsDepartments.value = response.data;
                    //console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // Get data from Backend
        const getRoles = () => {
            axios.get('http://127.0.0.1:8000/api/roles?for=selectbox')
                .then(function (response) {
                    optionsRoles.value = response.data;
                    //console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        
        // Get data from Backend
        const getUser = (userId) => {
            userId = route.params.id;
            axios.get(`http://127.0.0.1:8000/api/${userId}/users`)
                .then(function (response) {
                    const u = response.data;
                    user.username = u.username;
                    user.name = u.username;
                    user.email = u.email;
                    user.department_id = u.department_id;
                    user.status_id = u.status_id;
                    user.login_at = u.login_at;
                    user.change_password_at = u.change_password_at;
                    //console.log(response.data);
                    //console.log(user);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // Execute get data functions
        getStatuses();
        getDepartments();
        getRoles();
        getUser();

        // Submit form
        const submitForm = (userId) => {
            userId = route.params.id;
            axios.put(`http://127.0.0.1:8000/api/${userId}/users`, user)
                .then(function (response) {
                    console.log(response);
                    if(response.status == 200){
                        if(response) message.success('Request successful execution');
                        router.push({name: 'admin-users'});
                    }else{
                        message.error('Request execution failed');
                    }                    
                })
                .catch(function (error) {
                    console.log(error);
                    errors.value = error.response.data.errors;
                    message.error('Request execution failed');
                });
        }

        // Return data
        return {
            optionsDepartments,
            optionsStatuses,
            optionsRoles,
            filterOption,
            submitForm,
            ...toRefs(user),
            errors
        };
    }
})
</script>

<style>
    .el-danger {
        border: 1px solid #dc3545;
        border-radius: 7px;
    }
</style>