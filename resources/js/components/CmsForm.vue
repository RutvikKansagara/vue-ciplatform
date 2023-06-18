<template>
    <div class="ms-5 me-5 mt-5">
        <h2 v-if="isNewCms">Add</h2>
        <h2 v-else>Edit cmspage</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="title" class="form-label">title</label>
                <input class="form-control" type="text" id="name" v-model="cmspage.title"  />
            </div>
            <div v-if="formErrors.title" class="alert alert-danger" role="alert">
                {{ formErrors.title[0] }}
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <!-- <textarea class="form-control" id="description" v-model="cmspage.text" required></textarea> -->
                <ckeditor :editor="editor" v-model="cmspage.text" :config="editorConfig" :disabled="isEditorDisabled">
                </ckeditor>
            </div>
            <div v-if="formErrors.text" class="alert alert-danger" role="alert">
                {{ formErrors.text[0] }}
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">slug:</label>
                <input class="form-control" type="text" id="slug" v-model="cmspage.slug"  />
            </div>
            <div v-if="formErrors.slug" class="alert alert-danger" role="alert">
                {{ formErrors.slug[0] }}
            </div>
            <div>
                <label for="status">Status:</label>
                <select v-model="cmspage.status" id="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div v-if="formErrors.status" class="alert alert-danger" role="alert">
                {{ formErrors.status[0] }}
            </div>
            <button type="submit" v-if="isNewCms" class="btn btn-primary w-25">Add</button>

            <router-link to="/cmspage" v-if="isNewCms" class="p-2 col border btn btn-success w-25">Cancel</router-link>

            <button type="submit" v-else class="btn btn-primary">Update</button>
            <div v-if="successMessage" class="alert alert-success mt-5" role="alert">
                {{ successMessage }}
            </div>
            <div v-if="errorMessage" class="alert alert-danger mt-5" role="alert">
                {{ errorMessage }}
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import CKEditor from "@ckeditor/ckeditor5-vue";
export default {
    components: {
        // Use the <ckeditor> component in this view.
        ckeditor: CKEditor.component,
    },
    data() {
        return {
            formErrors: {}, // Object to store form field errors
            successMessage: '',
            errorMessage : '',
            editor: ClassicEditor,

            editorConfig: {
                // The configuration of the editor.
            },
            isEditorDisabled: false,
            cmspage: {
                title: '',
                text: '<p>Content of the editor.</p>',
                slug: '',
                description: '',
                status: '1',
            }
        }
    },
    computed: {
        isNewCms() {
            return !this.$route.path.includes('edit');
        }
    },
    async created() {
        if (!this.isNewCms) {
            const response = await axios.get(`/api/cmspage/${this.$route.params.id}`);
            console.log(response);
            this.cmspage = response.data;
            console.log(this.cmspage);
        }

    },
    methods: {
        async submitForm() {
            try {
                this.formErrors = {};
                this.successMessage = '';
                if (this.isNewCms) {
                    const response = await axios.post('/api/cmspage', this.cmspage);
                    this.successMessage = response.data.message;
                } else {
                    const response = await axios.put(`/api/cmspage/${this.$route.params.id}`, this.cmspage);
                    this.successMessage = response.data.message;
                }
                //this.$router.push('/cmspage');
            } catch (error) {
                console.error(error);
                if (error.response && error.response.data && error.response.data.errors) {
                    this.formErrors = error.response.data.errors; // Set form field errors from response
                } else {
                    this.errorMessage = 'An error occurred'; // Default error message
                }
            }
        }
    }
}
</script>
