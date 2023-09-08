<template>
    <Layout>
        <div>
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                        </div>
                        <h4 class="page-title">My Account</h4>
                        <div class="row">
                            <div class="col-md-8">
                                <alert v-if="isMsgVal" :message="isMessage" :type="isMsgVal" />
                            </div>
                            <div class="col-md-4" style="text-align:right">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" v-if="profileImage && profileImage !== null">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="mt-3 text-center">
                                            <img :src="imageUrl + 'storage/images/' + profileImage" alt="User Profile Image"
                                                class="img-thumbnail avatar-lg rounded-circle">
                                            <h4>{{ user.name }}</h4>
                                        </div>
                                        <img />
                                        <div class="mt-3">
                                            <hr class="" />

                                            <p class="mt-4 mb-1"><strong><i class='uil uil-at'></i> Email:</strong></p>
                                            <p>{{ user.email }}</p>

                                            <p class="mt-3 mb-1"><strong><i class='uil uil-phone'></i> Phone
                                                    Number:</strong></p>
                                            <p>{{ user.phone }}</p>

                                            <p class="mt-3 mb-1"><strong><i class='uil uil-location'></i> Location:</strong>
                                            </p>
                                            <p>{{ user.location }}</p>

                                            <p class="mt-3 mb-1"><strong><i class='uil uil-globe'></i> Languages:</strong>
                                            </p>
                                            <p>{{ user.languages.join(', ') }}</p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>

                            <div :class="profileImage && profileImage !== null ? 'col-md-8' : 'col-md-12'">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>Edit Info</h3>
                                        <br>
                                        <form enctype="multipart/form-data" @submit.prevent="submitForm">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Name<span
                                                            class="error-message">*</span></label>
                                                    <input type="text" v-model="user.name"
                                                        class="form-control form-control-sm"
                                                        :class="{ 'is-invalid': submitted && v$.user.name.$error }">
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.user.name.$errors" :key="index"
                                                        autocomplete="off">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Phone Number<span
                                                            class="error-message">*</span> <small>(ex:+31612345678)</small>
                                                    </label>
                                                    <input type="tel" v-model="user.phone"
                                                        class="form-control form-control-sm" @input="handleInput"
                                                        @paste="handlePaste"
                                                        :class="{ 'is-invalid': submitted && v$.user.phone.$error }">
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.user.phone.$errors" :key="index"
                                                        autocomplete="off">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="example-select" class="form-label">Education Level<span
                                                            class="error-message">*</span></label>
                                                    <select v-model="user.education_level" class="form-select"
                                                        :class="{ 'is-invalid': submitted && v$.user.education_level.$error }">
                                                        <option value="">Select an option</option>
                                                        <option value="Bachelor">Bachelor</option>
                                                        <option value="Master">Master</option>
                                                        <option value="Doctorate">Doctorate</option>
                                                    </select>
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.user.education_level.$errors"
                                                        :key="index" autocomplete="off">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Location<span
                                                            class="error-message">*</span></label>
                                                    <input type="text" v-model="user.location"
                                                        class="form-control form-control-sm"
                                                        :class="{ 'is-invalid': submitted && v$.user.location.$error }">
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.user.location.$errors" :key="index"
                                                        autocomplete="off">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Gender<span
                                                            class="error-message">*</span></label>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="customRadio1" name="gender"
                                                                class="form-check-input" value="male" v-model="user.gender">
                                                            <label class="form-check-label" for="customRadio1">Male</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="customRadio2" name="gender"
                                                                class="form-check-input" value="female"
                                                                v-model="user.gender">
                                                            <label class="form-check-label"
                                                                for="customRadio2">Female</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="customRadio3" name="gender"
                                                                class="form-check-input" value="others"
                                                                v-model="user.gender">
                                                            <label class="form-check-label"
                                                                for="customRadio3">Others</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.user.gender.$errors" :key="index"
                                                        autocomplete="off"
                                                        :style="{ display: submitted && v$.user.gender.$error ? 'block' : 'none' }">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Languages<span
                                                            class="error-message">*</span></label>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check form-check-inline"
                                                            v-for="(language, index) in languageOptions" :key="index">
                                                            <input type="checkbox" class="form-check-input"
                                                                v-model="user.languages" :value="language"
                                                                :checked="user.languages && user.languages.includes(language)">
                                                            <label class="form-check-label">{{ language }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.user.languages.$errors" :key="index"
                                                        autocomplete="off"
                                                        :style="{ display: submitted && v$.user.languages.$error ? 'block' : 'none' }">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-2 col-md-6">
                                                    <label class="form-label">Date of Birth<span
                                                            class="error-message">*</span></label>
                                                    <input class="form-control" v-model="user.dob" type="date" name="date"
                                                        :class="{ 'is-invalid': submitted && v$.user.dob.$error }">
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.user.dob.$errors" :key="index"
                                                        autocomplete="off">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <label class="form-label">Profile<span
                                                            class="error-message">*</span><small></small></label>
                                                    <input type="file" name="profile_image" class="form-control"
                                                        v-on:change="onChange" accept="image/*">
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.user.profile_image.$errors" :key="index"
                                                        autocomplete="off"
                                                        :style="{ display: submitted && v$.user.profile_image.$error ? 'block' : 'none' }">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                    <img v-if="profileImage && profileImage !== null"
                                                        :src="imageUrl + 'storage/images/' + profileImage"
                                                        alt="User Profile Image" class="img-thumbnail avatar-lg ">
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary mb-2">Save</button>&nbsp;
                                                <button type="button" class="btn btn-secondary mb-2"
                                                    @click="refreshPage">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
  
<script>
import axios from "../intercept";
import Layout from "./layouts/main.vue";
import { useVuelidate } from '@vuelidate/core';
import { required, maxLength, helpers } from '@vuelidate/validators';
export default {
    setup() {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            user: {
                name: '',
                phone: '',
                education_level: '',
                location: '',
                gender: '',
                languages: [],
                dob: '',
                profile_image: '',
            },
            languageOptions: ['English', 'French', 'Spanish', 'German'],
            submitted: false,
            isMessage: '',
            isMsgVal: '',
            profileImage: null,
            imageUrl: import.meta.env.VITE_BASE_URL
        };
    },
    validations() {
        return {
            user: {
                name: {
                    required: helpers.withMessage('Please enter name', required),
                },
                phone: {
                    required: helpers.withMessage('Please enter phone', required),
                    regex: helpers.withMessage('Invalid phone number', function () {
                        if (this.user.phone != null && this.user.phone != '') {
                            return /^(?:\+31|0)(?:[1-9]\d{8}|\d{2}-\d{7})$/.test(this.user.phone);
                        } else {
                            return true;
                        }

                    }),
                },
                education_level: {
                    required: helpers.withMessage('Please select education level', required),
                },
                location: {
                    required: helpers.withMessage('Please enter location', required),
                    minLength: helpers.withMessage('location must be max 15 characters long', maxLength(15)),
                },
                gender: {
                    required: helpers.withMessage('Please choose a gender', required),
                },
                languages: {
                    required: helpers.withMessage('Please select language(s)', required),
                },
                dob: {
                    required: helpers.withMessage('Please select date of birth', required),
                },
                profile_image: {
                    required: helpers.withMessage('Profile photo is required', required),
                }
            }
        }
    },
    components: {
        Layout,
    },
    mounted() {
        this.fetchDetails();
    },
    methods: {
        fetchDetails() {
            const userid = localStorage.getItem("userid");
            this.user.languages = [];
            axios
                .get(`/api/fetchUserDetail/${userid}`)
                .then((response) => {
                    this.user = response.data.user;
                    this.profileImage = response.data.user.profile_image;
                    const lang = JSON.parse(response.data.user.languages);
                    if (lang == null) {
                        this.user.languages = [];
                    } else {
                        this.user.languages = lang;
                    }
                });
        },
        submitForm() {

            this.v$.$touch();
            this.submitted = true;
            if (this.v$.$invalid) {
                return;
            }
            this.submitted = false;
            const userId = localStorage.getItem("userid");
            if (userId) {
                const formData = new FormData();
                formData.append('user_data', JSON.stringify(this.user));
                formData.append('profile_image', this.user.profile_image);
                axios
                    .post(`/api/saveUserDetail/${userId}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'Accept': 'application/json',
                        },
                    })
                    .then((response) => {
                        if (response.data.type == "success") {
                            localStorage.setItem("username", response.data.data.name);
                            localStorage.setItem("userimage", response.data.data.profile_image);
                            this.$swal({
                                text: response.data.message,
                                icon: response.data.type,
                                customClass: {
                                    popup: 'custom-swal-popup',
                                },
                            }).then(() => {
                                this.refreshPage();
                            });
                        } else {
                            this.isMsgVal = "danger";
                            this.isMessage = response.data.message;
                        }
                    })
                    .catch((error) => {
                        this.isMsgVal = "danger";
                        this.isMessage = error.response.data.message;
                    });
            }
        },
        handleInput(event) {
            const inputValue = event.target.value;
            this.user.phone = inputValue.replace(/[^\d+]/g, '');
        },
        handlePaste(event) {
            event.preventDefault();
            const clipboardData = event.clipboardData;
            const pastedText = clipboardData.getData('text/plain');
            const sanitizedText = pastedText.replace(/[^\d+]/g, '');
            this.user.phone = sanitizedText;
        },
        refreshPage() {
            this.$router.go();
        },
        onChange(e) {
            const file = e.target.files[0];
            this.user.profile_image = file;
        },
    },

};
</script>