<template>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <a>
                                <span><img :src="imageUrl+'images/logo.png'" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                            </div>
                            <div v-if="isAlertMessage !== ''" :class="['alert', 'alert-' + isMsg]" role="alert">
                                {{ isAlertMessage }}
                            </div>

                            <form @submit.prevent="submitForm">

                                <div class="mb-2">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="text" id="emailaddress" placeholder="Enter your email"
                                        v-model="form.email" :class="{ 'is-invalid': submitted && v$.form.email.$error }">
                                    <div class="invalid-feedback" v-for="(error, index) of v$.form.email.$errors"
                                        :key="index" autocomplete="off">
                                        <div class="error-msg">{{ error.$message }}</div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input :type="showPassword ? 'text' : 'password'" id="password" class="form-control"
                                            v-model="form.password" placeholder="Enter your password"
                                            :class="{ 'is-invalid': submitted && v$.form.password.$error }">
                                        <div class="input-group-text" @click="showPassword = !showPassword"
                                            :data-password="showPassword.toString()">
                                            <span class="password-eye" :class="{ 'show-password': showPassword }"></span>
                                        </div>
                                        <div class="invalid-feedback" v-for="(error, index) of v$.form.password.$errors"
                                            :key="index" autocomplete="off">
                                            <div class="error-msg">{{ error.$message }}</div>
                                        </div>
                                    </div>

                                </div>


                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Don't have an account? <a href="/registration"
                                    class="text-muted ms-1"><b>Sign Up</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
</template>


<script>
import axios from 'axios';
import { useVuelidate } from '@vuelidate/core';
import { required, email, helpers } from '@vuelidate/validators';
export default {
    setup() {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            showPassword: false,
            isAlertMessage: '',
            isMsg: '',
            submitted: false,
            imageUrl: import.meta.env.VITE_BASE_URL
        };
    },
    validations() {
        return {
            form: {
                email: {
                    required: helpers.withMessage('Please enter email', required),
                    email: helpers.withMessage('Please enter a valid email', email),
                },
                password: {
                    required: helpers.withMessage('Please enter password', required),
                },
            }
        }
    },
    methods: {
        submitForm() {
            this.submitted = true;
            this.v$.$touch();
            if (this.v$.$invalid) {
                return;
            }
            this.submitted = false;
            this.isMsg = "danger";
            axios.post('/api/login', this.form).then(response => {
                if (response.data.type == "success") {
                    this.isMsg = response.data.type;
                    this.isAlertMessage = response.data.message;
                    localStorage.setItem("token", response.data.token);
                    localStorage.setItem("username", response.data.user.name);
                    localStorage.setItem("useremail", response.data.user.email);
                    localStorage.setItem("userid", response.data.user.id);
                    localStorage.setItem("userrole", response.data.user.role);
                    localStorage.setItem("userimage", response.data.user.profile_image);
                    setTimeout(() => {
                        this.$router.push('/dashboard');
                    }, 1000);

                } else {
                    this.isAlertMessage = response.data.message;
                }
            }).catch((error) => {
                this.isAlertMessage = error.response.data.message;
            });
        }
    }
}
</script>