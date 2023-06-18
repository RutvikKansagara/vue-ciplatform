<template>
    <div class="ms-5 me-5 mt-5">
      <h2 v-if="isNewMissionTheme">Add</h2>
      <h2 v-else>Edit Mission Theme</h2>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label for="name" class="form-label">Title:</label>
            <input class="form-control" type="text" id="name" v-model="missiontheme.title" />
          </div>
          <div v-if="formErrors.title" class="alert alert-danger" role="alert">
            {{ formErrors.title[0] }}
        </div>
          <div>
            <label for="status">Status:</label>
            <select v-model="missiontheme.status" id="status" class="w-75 mt-5 h-100">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
          <div v-if="formErrors.status" class="alert alert-danger" role="alert">
            {{ formErrors.status[0] }}
        </div>
          <button type="submit" v-if="isNewMissionTheme" class="btn btn-primary">Add</button>
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
  export default {
    data() {
      return {
        formErrors: {}, // Object to store form field errors
            successMessage: '',
            errorMessage : '',
        missiontheme: {
          title: '',
          status:1,
        }
      }
    },
    computed: {
      isNewMissionTheme() {
        return !this.$route.path.includes('edit');
      }
    },
    async created() {
      if (!this.isNewMissionTheme) {
        const response = await axios.get(`/api/missiontheme/${this.$route.params.id}`);
        console.log(response);
        this.missiontheme = response.data;
        console.log(this.missiontheme);
      }
    },
    methods: {
      async submitForm() {
        try {
            this.formErrors = {};
                this.successMessage = '';
          if (this.isNewMissionTheme) {
          const response = await axios.post('/api/missiontheme', this.missiontheme);
          this.successMessage = response.data.message;
          } else {
           const response = await axios.put(`/api/missiontheme/${this.$route.params.id}`, this.missiontheme);
           this.successMessage = response.data.message;
          }
          //this.$router.push('/missiontheme');
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
