
<template><!-- ========== Topbar Start ========== -->
<div class="navbar-custom topnav-navbar">
    <div class="container-fluid detached-nav">

        <!-- Topbar Logo -->
        <div class="logo-topbar">
            <!-- Logo light -->
            <a href="index.html" class="logo-light">
                <span class="logo-lg">
                    <img :src="imageUrl+'images/logo.png'" alt="logo" height="22">
                </span>
                <span class="logo-sm">
                    <img :src="imageUrl+'images/logo-sm.png'" alt="small logo" height="22">
                </span>
            </a>

            <!-- Logo Dark -->
            <a href="index.html" class="logo-dark">
                <span class="logo-lg">
                    <img :src="imageUrl+'images/logo-dark.png'" alt="dark logo" height="22">
                </span>
                <span class="logo-sm">
                    <img :src="imageUrl+'images/logo-dark-sm.png'" alt="small logo" height="22">
                </span>
            </a>
        </div>

        <!-- Sidebar Menu Toggle Button -->
        <button class="button-toggle-menu">
            <i class="mdi mdi-menu"></i>
        </button>

        <!-- Horizontal Menu Toggle Button -->
        <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <ul class="list-unstyled topbar-menu mb-0">

<li class="dropdown notification-list topbar-dropdown">
    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <span class="align-middle d-none d-lg-inline-block"><h3>Role: {{ userRole }}</h3></span>
    </a>
</li>
</ul>
        <ul class="list-unstyled topbar-menu float-end mb-0">

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                    aria-expanded="false">
                    <span class="account-user-avatar"> 
                        <img :src="getImage" alt="user-image" class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name">{{ userName }}</span>
                        <span class="account-position">{{userEmail}}</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <router-link to="/myaccount" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-circle me-1"></i>
                    <span>My Account</span>
                    </router-link>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item" @click="logout()">
                        <i class="mdi mdi-logout me-1"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>

    </div>
</div>
<!-- ========== Topbar End ========== -->
</template>

<script>
import axios from "../../intercept";
export default {
  data() {
    return {
      token: localStorage.getItem("token"),
      userName: localStorage.getItem("username"),
      userEmail: localStorage.getItem("useremail"),
      userRole: localStorage.getItem("userrole"),
      userImage: localStorage.getItem("userimage"),
      imageUrl: import.meta.env.VITE_BASE_URL
    };
  },
  methods: {
    logout() {
      axios
        .get("logout")
        .then(() => {
          localStorage.removeItem("token");
          localStorage.removeItem("username");
          localStorage.removeItem("useremail");
          localStorage.removeItem("userid");
          localStorage.removeItem("userrole");
          localStorage.removeItem("userimage");
          localStorage.clear();
          this.$router.push("/login");
        });
    },
  },
  computed:{
  getImage(){
    if(this.userImage !=='' && this.userImage != "null"){
        return this.imageUrl+'storage/images/'+this.userImage;
    }else{
        return this.imageUrl+'images/users/default-avatar.jpg';
    }
  }
}
};
</script>