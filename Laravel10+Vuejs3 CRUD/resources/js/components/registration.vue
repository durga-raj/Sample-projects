<template>
    <div class="account-pages pt-2 pt-sm-3 pb-4 pb-sm-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <!-- Logo-->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <a>
                                <span><img :src="imageUrl+'images/logo.png'" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">Sign Up</h4>
                            </div>
                            <div v-if="isSuccessMsg !== ''" :class="['alert', 'alert-' + isMsg]" role="alert">
                                {{ isSuccessMsg }}
                            </div>
                            <form ref="regForm" @submit.prevent="submitForm">

                                <div class="mb-2">
                                    <label for="fullname" class="form-label">Name</label>
                                    <input class="form-control" type="text" id="fullname" v-model="form.name"
                                        placeholder="Enter your name"
                                        :class="{ 'is-invalid': submitted && v$.form.name.$error }">
                                    <div class="invalid-feedback" v-for="(error, index) of v$.form.name.$errors"
                                        :key="index" autocomplete="off">
                                        <div class="error-msg">{{ error.$message }}</div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="emailaddress" class="form-label">Email </label>
                                    <input class="form-control" type="text" v-model="form.email" id="emailaddress"
                                        placeholder="Enter your email"
                                        :class="{ 'is-invalid': submitted && v$.form.email.$error }">
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

                                <div class="mb-2">
                                    <label for="password" class="form-label">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <input :type="cshowPassword ? 'text' : 'password'" id="cpassword"
                                            class="form-control" v-model="form.cpassword" placeholder="Enter your password"
                                            :class="{ 'is-invalid': submitted && v$.form.cpassword.$error }">
                                        <div class="input-group-text" @click="cshowPassword = !cshowPassword"
                                            :data-cpassword="cshowPassword.toString()">
                                            <span class="password-eye" :class="{ 'show-password': cshowPassword }"></span>
                                        </div>
                                        <div class="invalid-feedback" v-for="(error, index) of v$.form.cpassword.$errors"
                                            :key="index" autocomplete="off">
                                            <div class="error-msg">{{ error.$message }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="emailaddress" class="form-label">Role </label>
                                    <select v-model="form.role" class="form-select" :class="{ 'is-invalid': submitted && v$.form.role.$error }">
                                                        <option value="">Select an option</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Agent">Agent</option>
                                                    </select>
                                    <div class="invalid-feedback" v-for="(error, index) of v$.form.role.$errors"
                                        :key="index" autocomplete="off">
                                        <div class="error-msg">{{ error.$message }}</div>
                                    </div>
                                </div>

                                <div class="mb-2 text-center">
                                    <button class="btn btn-primary" type="submit"> Sign Up </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Already have account? <a href="/login" class="text-muted ms-1"><b>Log
                                        In</b></a></p>
                        </div> <!-- end col-->
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
                name: '',
                email: '',
                password: '',
                cpassword: '',
                role:'',
                profile_image:null
            },
            showPassword: false,
            cshowPassword: false,
            isSuccessMsg: '',
            isMsg: '',
            submitted: false,
            imageUrl: import.meta.env.VITE_BASE_URL
        };
    },
    validations() {
        return {
            form: {
                name: {
                    required: helpers.withMessage('Please enter name', required),
                },
                email: {
                    required: helpers.withMessage('Please enter email', required),
                    email: helpers.withMessage('Please enter a valid email', email),
                },
                password: {
                    required: helpers.withMessage('Please enter password', required),
                },
                cpassword: {
                    required: helpers.withMessage('Please enter confirm password', required),
                    match: helpers.withMessage('Passwords do not match', function () {
                        if (this.form.cpassword !== '') {
                            return this.form.password === this.form.cpassword;
                        }
                        return true;
                    }),
                },
                role: {
                    required: helpers.withMessage('Please select role', required),
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
            axios
                .post('/api/register', this.form)
                .then((response) => {
                    if (response.data.type == "success") {
                        this.isMsg = response.data.type;
                        this.isSuccessMsg = response.data.message;
                        this.form = {};
                    } else {
                        this.isMsg = "danger";
                        this.isSuccessMsg = response.data.message;
                    }
                })
                .catch((error) => {
                    this.isMsg = "danger";
                    this.isSuccessMsg = error.response.data.message;
                });
        },
    },
}
</script>