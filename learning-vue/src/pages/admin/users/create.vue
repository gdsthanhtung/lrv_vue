<template>
    <form @submit.prevent="submitForm()">
        <a-card title="Users list" style="width: 100%;">
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
                                <span>Status:</span>
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
                            ></a-select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Username:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input 
                                v-model:value="username" 
                                placeholder="Enter username..." 
                                allow-clear/>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Fullname:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input 
                                v-model:value="fullname" 
                                placeholder="Enter fullname..." 
                                allow-clear/>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Email:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input 
                                v-model:value="email" 
                                placeholder="Enter email..." 
                                allow-clear/>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Department:</span>
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
                            ></a-select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Password:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password v-model:value="password" placeholder="Enter password..." allow-clear />
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span>Confirm Password:</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-5">
                            <a-input-password v-model:value="password_confirmation" placeholder="Enter confirm password..." allow-clear />
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
import { useMenu } from "../../../stores/use-menu.js";
import { UserOutlined, UploadOutlined } from '@ant-design/icons-vue';

export default defineComponent({
    components: {
        UserOutlined, UploadOutlined
    },
    setup() {
        // Include left menu
        useMenu().onSelectedKeys(['admin-users']);

        // Allow filter by uppercase/lowercase in selectbox
        const filterOption = (input, option) => {
            return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
        };

        // Default value of inputs
        const user = reactive({
            username: "",
            fullname: "",
            email: "",
            password: "",
            password_confirmation: "",
            department_id: [],
            status_id: [],
            role_id: []
        });

        // Default value of selectboxes
        const optionsDepartments = ref([]);
        const optionsRoles = ref([]);
        const optionsStatuses = ref([]);


        // Get data from Backend
        const getStatuses = () => {
            axios.get('http://127.0.0.1:8000/api/enumerations?for=selectbox&refTable=users')
                .then(function (response) {
                    optionsStatuses.value = response.data;
                    console.log(response.data);
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
                    console.log(response.data);
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
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // Execute get data functions
        getStatuses();
        getDepartments();
        getRoles();

        // Submit form
        const submitForm = () => {
            axios.post('http://127.0.0.1:8000/api/users', user)
                .then(function (response) {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // Return data
        return {
            optionsDepartments,
            optionsStatuses,
            optionsRoles,
            filterOption,
            submitForm,
            ...toRefs(user)
        };
    }
})
</script>