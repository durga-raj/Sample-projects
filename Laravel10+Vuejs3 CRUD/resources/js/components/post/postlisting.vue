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
                                <div class="card-body" style="min-height:500px">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <alert v-if="isMsgVal" :message="isMessage" :type="isMsgVal" />
                                        </div>
                                        <div class="col-md-4" style="text-align:right">
                                            <router-link to="/postadd" class="btn btn-danger rounded-pill mb-3"><i
                                                    class="mdi mdi-plus"></i> Add Post</router-link>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped table-centered mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th v-if="this.userRole == 'Admin'">Posted By</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(post, index) in posts" :key="post.id">
                                                        <td>{{ getSerialNumber(index) }}</td>
                                                        <td>{{ truncateText(post.title, 30) }}</td>
                                                        <td>{{ truncateText(post.body, 80) }}</td>
                                                        <td v-if="this.userRole == 'Admin'">{{ post.posted_by }}</td>
                                                        <td class="table-action">
                                                            <a href="javascript: void(0);" class="action-icon"
                                                                @click="openview(post.id)"> <i class="mdi mdi-eye"></i></a>
                                                            <a href="javascript: void(0);" class="action-icon"
                                                                @click="editPost(post.id)"> <i
                                                                    class="mdi mdi-pencil"></i></a>
                                                            <a href="javascript: void(0);" class="action-icon"
                                                                @click="showDeleteConfirmation(post.id)"> <i
                                                                    class="mdi mdi-delete"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="posts.length == 0">
                                                        <td colspan="5">
                                                            No records found!
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog"
                                                aria-labelledby="scrollableModalTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="scrollableModalTitle"> View Post
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body" v-if="selectedPost">
                                                            <p> <b><span v-if="this.userRole == 'Admin'"><i
                                                                            class="uil-user-circle post-view-icon"
                                                                            :style="{ color: 'blue', fontSize: '21px' }"></i>&nbsp;{{ selectedPost.posted_by
                                                                            }}&nbsp; </span> <i
                                                                        class="uil-calendar-alt post-view-icon"
                                                                        :style="{ color: 'orange', fontSize: '18px' }"></i>
                                                                    {{ selectedPost.created_at }}</b></p>
                                                            <p><b>Title:</b> {{ selectedPost.title }}</p>
                                                            <p><b>Description:</b> {{ selectedPost.body }}</p>
                                                        </div>
                                                        <div class="modal-body text-center" v-else>
                                                            <div class="spinner-border" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
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


export default {
    setup() {

        const truncateText = (text, charCount) => {
            if (text.length <= charCount) {
                return text;
            }
            return text.slice(0, charCount) + '...';
        };

        return {
            truncateText,
        };
    },
    data() {
        return {
            formTitle: 'All Posts',
            posts: [],
            selectedPost: [],
            getMsgInfo: {
                message: '',
                type: ''
            },
            ALertmsg: false,
            userRole: localStorage.getItem("userrole"),
            userId: localStorage.getItem("userid")
        };
    },
    components: {
        Layout
    },
    beforeMount() {
        this.fetchPosts();
    },
    methods: {
        fetchPosts() {
            const params = {
                userrole: this.userRole,
                userid: this.userId,
            };
            axios
                .get('/api/post', {
                    params,
                })
                .then((response) => {
                    this.posts = response.data.data;
                });
        },
        openview(postId) {
            this.selectedPost = null;
            $('#scrollable-modal').modal('show');

            axios.get(`/api/post/${postId}`)
                .then((response) => {
                    this.selectedPost = response.data.data;
                });
        },
        editPost(postId) {
            const encryptedText = this.$encrypt(postId, 'edit-post-page');
            this.$router.push({
                path: '/postedit',
                query: { id: encryptedText }
            });
        },
        showDeleteConfirmation(deletePostId) {
            this.$swal({
                text: "Are you sure you want to delete this post?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                reverseButtons: true,
                customClass: {
                    popup: 'custom-swal-popup',
                },
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/api/post/${deletePostId}`)
                        .then((response) => {
                            this.$swal({
                                text: response.data.message,
                                icon: response.data.type,
                                customClass: {
                                    popup: 'custom-swal-popup',
                                },
                            }).then(() => {
                                this.fetchPosts();
                            })
                        })
                        .catch((error) => {
                            this.$swal({
                                text: error.response.data.message,
                                icon: error.response.data.type,
                                customClass: {
                                    popup: 'custom-swal-popup',
                                },
                            }).then(() => {
                                this.fetchPosts();
                            })
                        });

                }
            });
        }
    },
    computed: {
        getSerialNumber() {
            return (index) => index + 1;
        },
        isMsgVal() {
            return this.$store.state.alertMsg.isMsgVal;
        },
        isMessage() {
            return this.$store.state.alertMsg.isMessage;
        },
    },
};
</script>
       
  