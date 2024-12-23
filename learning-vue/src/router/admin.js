const admin = [
    {
        path: "/admin",
        component: () => import("../layouts/admin.vue"),
        children: [
            // USERS MGMT
            {
                path: "users",
                name: "admin-users",
                component: () => import("../pages/admin/users/index.vue")
            },
            {
                path: "users/create",
                name: "admin-users-create",
                component: () => import("../pages/admin/users/create.vue")
            },
            {
                path: "users/:id/edit",
                name: "admin-users-edit",
                component: () => import("../pages/admin/users/edit.vue")
            },

            // ROLES MGMT
            {
                path: "roles",
                name: "admin-roles",
                component: () => import("../pages/admin/roles/index.vue")
            },

            // SETTINGS MGMT
            {
                path: "settings",
                name: "admin-settings",
                component: () => import("../pages/admin/settings/index.vue")
            }
        ]
    }
];

export default admin;