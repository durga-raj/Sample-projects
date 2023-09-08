<template>
    <Layout>
        <div>
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                        </div>
                        <h4 class="page-title">Post Management <span><small> &nbsp; >> {{ formTitle }}</small></span></h4>
                        <div class="row">
                            <div class="card">
                                <div class="card-body" style="height: 65vh!important;">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <alert v-if="alertMessage" :message="getMsgInfo.message"
                                                :type="getMsgInfo.type" />
                                        </div>
                                        <div class="col-md-4" style="text-align:right">
                                            <router-link to="/postlisting" class="btn btn-danger rounded-pill mb-3"><i
                                                    class="mdi mdi-arrow-left-bold"></i> Back</router-link>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form @submit.prevent="submitForm">
                                                <div class="mb-3 col-md-7">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" id="post_title" name="post-title"
                                                        v-model="post.title" class="form-control form-control-sm"
                                                        :class="{ 'is-invalid': submitted && v$.post.title.$error }">
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.post.title.$errors" :key="index"
                                                        autocomplete="off">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-7">
                                                    <label for="example-textarea" class="form-label">Description</label>
                                                    <textarea class="form-control" id="post_body" rows="5"
                                                        v-model="post.body"
                                                        :class="{ 'is-invalid': submitted && v$.post.body.$error }"></textarea>
                                                    <div class="invalid-feedback"
                                                        v-for="(error, index) of v$.post.body.$errors" :key="index"
                                                        autocomplete="off">
                                                        <div class="error-msg">{{ error.$message }}</div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary mb-2">Save</button>
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
        </div>
    </Layout>
</template>
  
  
<script>
import axios from "../../intercept";
import Layout from "../layouts/main.vue";
import { useVuelidate } from '@vuelidate/core';
import { required, helpers } from '@vuelidate/validators';
export default {
    setup() {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            formTitle: '',
            post: {
                title: '',
                body: '',
                created_by: '',
            },
            alertMessage: false,
            getMsgInfo: [],
            submitted: false
        };
    },
    validations() {
        return {
            post: {
                title: {
                    required: helpers.withMessage('Please enter title', required),
                },
                body: {
                    required: helpers.withMessage('Please enter description', required),
                },
            }
        }
    },
    components: {
        Layout,
    },
    mounted() {
        if (this.$route.query.id) {
            const postId = this.$decrypt(this.$route.query.id, 'edit-post-page');
            this.formTitle = 'Edit Post';

            axios
                .get(`/api/post/${postId}`)
                .then((response) => {
                    this.post = response.data.data;
                });
        } else {
            this.formTitle = 'Add Post';
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

            if (this.$route.query.id) {
                const postId = this.$decrypt(this.$route.query.id, 'edit-post-page');
                axios
                    .put(`/api/post/${postId}`, this.post)
                    .then((response) => {
                        if (response.data.type == "success") {
                            this.$store.commit('setPassedValues', { isMsgVal: response.data.type, isMessage: response.data.message });
                            this.$router.push('/postlisting');
                        } else {
                            this.alertMessage = true;
                            this.getMsgInfo.message = response.data.message;
                            this.getMsgInfo.type = response.data.type;
                        }
                    })
                    .catch((error) => {
                        this.alertMessage = true;
                        this.getMsgInfo.message = error.response.data.message;
                        this.getMsgInfo.type = error.response.data.type;
                    });
            } else {
                this.post.created_by = localStorage.getItem("userid");
                axios
                    .post('/api/post', this.post)
                    .then((response) => {
                        if (response.data.type == "success") {
                            this.$store.commit('setPassedValues', { isMsgVal: response.data.type, isMessage: response.data.message });
                            this.$router.push('/postlisting');
                        } else {
                            this.alertMessage = true;
                            this.getMsgInfo.message = response.data.message;
                            this.getMsgInfo.type = response.data.type;
                        }
                    })
                    .catch((error) => {
                        this.alertMessage = true;
                        this.getMsgInfo.message = error.response.data.message;
                        this.getMsgInfo.type = error.response.data.type;
                    });
            }
        },
    },
};
</script>
  