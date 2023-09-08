import { createWebHistory, createRouter } from "vue-router";
import Dashboard from './components/dashboard/dashboard.vue';
import Login from './components/login.vue';
import Registration from './components/registration.vue';
import PostListing from './components/post/postlisting.vue';
import PostForm from './components/post/postform.vue';
import MyAccount from './components/myaccount.vue';

const routes = [
  {
    path: "/",
    redirect: '/login',
  },
  {
    path: '/dashboard',
    name: "dashboard",
    component: Dashboard,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/postadd",
    name: "Post Add",
    component: PostForm,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/postedit",
    name: "Post Edit",
    component: PostForm,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/postlisting',
    name: 'postlisting',
    component: PostListing,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/login",
    name: "login",
    component: Login,
  },
  {
    path: "/registration",
    name: "registration",
    component: Registration,
  },
  {
    path: "/myaccount",
    name: "myaccount",
    component: MyAccount,
    meta: {
      requiresAuth: true,
    },
  },

];

const routers = createRouter({
  history: createWebHistory(),
  routes,
});


routers.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !isAuthenticated()) {
    next('/login');
  } else {
    next();
  }
});

function isAuthenticated() {
  const token = localStorage.getItem('token');
  return !!token;
}

export default routers;