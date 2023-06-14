<template>
    <div class="ms-5 mt-5 me-5">
      <h2 v-if="isNewBanner">Add Banner</h2>
      <h2 v-else>Edit Banner</h2>
      <div v-if="successMessage" class="alert alert-success mt-3">
        {{ successMessage }}
      </div>
      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="description" class="form-label">Banner Description:</label>
          <textarea class="form-control" type="text" id="name" v-model="banner.text"></textarea>
          <div v-if="errors.text">
            <div v-for="(error, index) in errors.text" :key="index" class="text-danger">
              {{ error }}
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="sortorder" class="form-label">Sort Order:</label>
          <input class="form-control" type="number" id="sort_order" v-model="banner.sort_order" />
        </div>
        <div v-if="errors.sort_order">
          <div v-for="(error, index) in errors.sort_order" :key="index" class="text-danger">
            {{ error }}
          </div>
        </div>
        <div class="mb-3">
          <label for="photo" class="form-label">Photo:</label>
          <input class="form-control" type="file" id="photo" @change="handleImageChange" accept="image/*" />

          <div v-if="errors.image">
            <div v-for="(error, index) in errors.image" :key="index" class="text-danger">
              {{ error }}
            </div>
          </div>
        </div>
        <button type="submit" v-if="isNewBanner" class="btn btn-primary">
          Add Banner
        </button>
        <button type="submit" v-else class="btn btn-primary">Update</button>
      </form>
    </div>
  </template>

  <script>
  import axios from "axios";
  export default {
    data() {
      return {
        banner: {
          text: "",
          sort_order: 0,
          image: null,
        },
        errors: {},
        successMessage: "",
      };
    },
    computed: {
      isNewBanner() {
        return !this.$route.path.includes("edit");
      },
    },
    async created() {
      if (!this.isNewBanner) {
        const response = await axios.get(`/api/banner/${this.$route.params.id}`);
        console.log(response);
        this.banner = response.data;
      }
    },
    methods: {
      handleImageChange(event) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = (e) => {
            const dataURL = e.target.result;
            const blob = this.dataURItoBlob(dataURL);
            this.banner.image = blob;
          };
          reader.readAsDataURL(file);
        } else {
          this.banner.image = null;
        }
      },
      dataURItoBlob(dataURI) {
        const byteString = atob(dataURI.split(",")[1]);
        const mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];
        const ab = new ArrayBuffer(byteString.length);
        const ia = new Uint8Array(ab);
        for (let i = 0; i < byteString.length; i++) {
          ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: mimeString });
      },
      async submitForm() {
        try {
          const formData = new FormData();
          formData.append("text", this.banner.text);
          formData.append("sort_order", this.banner.sort_order);
          formData.append("image", this.banner.image);

          if (this.isNewBanner) {
            axios
              .post("/api/banner", formData, {
                headers: {
                  "Content-Type": "multipart/form-data",
                },
              })
              .then((response) => {
                this.successMessage = response.data.message;
                console.log(response.data.message);
              })
              .catch((error) => {
                if (error.response.status === 422) {
                  this.errors = error.response.data.errors;
                } else {
                  // Handle other types of errors
                }
              });
          } else {
            axios
              .put(`/api/banner/${this.$route.params.id}`, formData, {
                headers: {
                  "Content-Type": "multipart/form-data",
                },
              })
              .then((response) => {
                this.successMessage = response.data.message;
                console.log(response.data.message);
              })
              .catch((error) => {
                if (error.response.status === 422) {
                  this.errors = error.response.data.errors;
                } else {
                  // Handle other types of errors
                }
              });
          }
        } catch (error) {
          console.error(error);
        }
      },
    },
  };
  </script>
