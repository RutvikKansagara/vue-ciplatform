<template>
  <div
    class="container-fluid position-sticky"
    style="top: 0%; background-color: white; z-index: 999"
  >
    <button
      class="btn"
      name="header-toggle"
      id="main_header_btn"
      type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#offcanvasExample"
      aria-controls="offcanvasExample"
    >
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>
  <form @submit.prevent="updateProfile" enctype="multipart/form-data">
    <div class="container mx-auto">
      <div class="row ms-md-5">
        <div
          class="col-lg-4 mx-auto img-thumbnail mt-5 d-flex-column justify-content-center text-center"
          style="width: 330px; height: 315px"
        >
          <label for="avatar" style="cursor: pointer">
            <img
              src="../../../public/Images/user-img1.png"
              alt="profile-photo"
              class="img-fluid rounded-circle mt-5"
              style="width: 130px; height: 115px"
            />
          </label>
          <input type="file" id="avatar" style="display: none" />
          <h5 class="mt-2">{{ fullName }}</h5>

          <button
            type="button"
            data-toggle="modal"
            data-target="#passwordModal"
            class="btn btn-warning"
          >
            Change Password
          </button>
        </div>

        <div class="col-lg-8 ms-md-5 ps-md-5">
          <ul
            class="nav nav-tabs"
            id="myTab"
            role="tablist"
            style="border-bottom: 1px solid #adadad"
          >
            <li class="nav-item" role="presentation">
              <button
                class="nav-link active mt-5"
                data-bs-toggle="tab"
                data-bs-target="#tab-1"
                type="button"
                role="tab"
                aria-controls="home"
                aria-selected="true"
                style="
                  color: #443d3e;
                  font-weight: 500px;
                  border: none;
                  border-bottom: 3px solid #3b3636;
                  padding: 14px 18px;
                "
              >
                Basic Information
              </button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent" style="margin-top: 25px">
            <div
              class="tab-pane fade show active"
              id="tab-1"
              role="tabpanel"
              style="font-size: 15px; line-height: 24px; color: #3e3e3e"
            >
              <div class="row">
                <div class="col-lg-6">
                  <label for="first_name" class="form-label">Name*</label>
                  <input
                    type="text"
                    class="form-control"
                    id="first_name"
                    placeholder="Enter your name"
                    v-model="firstName"
                  />
                  <div v-if="errors.first_name" class="text-danger">
                    {{ errors.first_name[0] }}
                  </div>
                </div>
                <div class="col-lg-6">
                  <label for="last_name" class="form-label">Surname*</label>
                  <input
                    type="text"
                    class="form-control"
                    id="last_name"
                    placeholder="Enter your surname"
                    v-model="lastName"
                  />
                  <div v-if="errors.last_name" class="text-danger">
                    {{ errors.last_name[0] }}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 mt-4">
                  <label for="employee_id" class="form-label"
                    >Employee ID</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="employee_id"
                    placeholder="Enter your Employee ID"
                    v-model="employeeId"
                  />
                  <div v-if="errors.employee_id" class="text-danger">
                    {{ errors.employee_id[0] }}
                  </div>
                </div>
                <div class="col-lg-6 mt-4">
                  <label for="manager" class="form-label">Manager</label>
                  <input
                    type="text"
                    class="form-control"
                    id="manager"
                    placeholder="Enter your manager details"
                    v-model="manager"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 mt-4">
                  <label for="title" class="form-label">Title</label>
                  <input
                    type="text"
                    class="form-control"
                    id="title"
                    placeholder="Enter your title"
                    v-model="title"
                  />
                  <div v-if="errors.title" class="text-danger">
                    {{ errors.title[0] }}
                  </div>
                </div>
                <div class="col-lg-6 mt-4">
                  <label for="department" class="form-label">Department</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="department"
                    placeholder="Enter your Department"
                  />
                  <div v-if="errors.department" class="text-danger">
                    {{ errors.department[0] }}
                  </div>
                </div>

                <div class="row">
                  <div class="col mt-4">
                    <label for="profile_text">My Profile*</label>
                    <textarea
                      class="form-control mt-2"
                      v-model="profile_text"
                      placeholder="Enter your comments..."
                    ></textarea>
                    <div v-if="errors.profile_text" class="text-danger">
                      {{ errors.profile_text[0] }}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col mt-4">
                    <label for="why_i_volunteer">Why I Volunteer?</label>
                    <textarea
                      class="form-control mt-2"
                      v-model="why_i_volunteer"
                      placeholder="Enter your comments..."
                    ></textarea>
                    <div v-if="errors.why_i_volunteer" class="text-danger">
                      {{ errors.why_i_volunteer[0] }}
                    </div>
                  </div>
                </div>
                <ul
                  class="nav nav-tabs"
                  id="myTab"
                  role="tablist"
                  style="border-bottom: 1px solid #adadad"
                >
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link active mt-5"
                      data-bs-toggle="tab"
                      data-bs-target="#tab-2"
                      type="button"
                      role="tab"
                      aria-controls="home"
                      aria-selected="true"
                      style="
                        color: #443d3e;
                        font-weight: 500px;
                        border: none;
                        border-bottom: 3px solid #3b3636;
                        padding: 14px 18px;
                      "
                    >
                      Address Information
                    </button>
                  </li>
                </ul>
                <div
                  class="tab-content"
                  id="myTabContent"
                  style="margin-top: 25px"
                >
                  <div
                    class="tab-pane fade show active"
                    id="tab-2"
                    role="tabpanel"
                    style="font-size: 15px; line-height: 24px; color: #3e3e3e"
                  >
                    <div class="row">
                      <div class="col-md-6">
                        <label for="country">Country</label>
                        <select
                          name="country_id"
                          class="form-control"
                          id="country-dropdown"
                          v-model="selectedCountryId"
                          @change="fetchCities(selectedCountryId)"
                        >
                          <option value="" disabled selected>
                            Select Country
                          </option>
                          <option
                            v-for="country in countries"
                            :value="country.country_id"
                            :selected="country.country_id === selectedCountryId"
                            :key="country.country_id"
                          >
                            {{ country.name }}
                          </option>
                        </select>
                        <div v-if="errors.country_id">
                          <div
                            v-for="(error, index) in errors.country_id"
                            :key="index"
                            class="text-danger"
                          >
                            {{ error }}
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <label for="city">City</label>
                        <select
                          class="form-control"
                          name="city_id"
                          id="city-dropdown"
                          v-model="selectedCityId"
                        >
                          <option
                            v-for="city in getCitiesForSelectedCountry"
                            :value="city.city_id"
                            :selected="city.city_id === selectedCityId"
                            :key="city.city_id"
                          >
                            {{ city.name }}
                          </option>
                          <!-- Options will be dynamically populated based on selected country -->
                        </select>
                        <div v-if="errors.city_id">
                          <div
                            v-for="(error, index) in errors.city_id"
                            :key="index"
                            class="text-danger"
                          >
                            {{ error }}
                          </div>
                        </div>
                      </div>
                    </div>
                    <ul
                      class="nav nav-tabs"
                      id="myTab"
                      role="tablist"
                      style="border-bottom: 1px solid #adadad"
                    >
                      <li class="nav-item" role="presentation">
                        <button
                          class="nav-link active mt-5"
                          data-bs-toggle="tab"
                          data-bs-target="#tab-1"
                          type="button"
                          role="tab"
                          aria-controls="home"
                          aria-selected="true"
                          style="
                            color: #443d3e;
                            font-weight: 500px;
                            border: none;
                            border-bottom: 3px solid #3b3636;
                            padding: 14px 18px;
                          "
                        >
                          Professional Information
                        </button>
                      </li>
                    </ul>
                    <div
                      class="tab-content"
                      id="myTabContent"
                      style="margin-top: 25px"
                    >
                      <div
                        class="tab-pane fade show active"
                        id="tab-1"
                        role="tabpanel"
                        style="
                          font-size: 15px;
                          line-height: 24px;
                          color: #3e3e3e;
                        "
                      >
                        <div class="row">
                          <div class="col-lg-6">
                            <label for="inputAvailable" class="form-label"
                              >Availability</label
                            >
                            <select
                              id="inputAvailable"
                              class="form-select"
                              v-model="availability"
                            >
                              <option value="">Select your availability</option>
                              <option value="daily">Daily</option>
                              <option value="weekly">Weekly</option>
                              <option value="week-end">Week-end</option>
                              <option value="monthly">Monthly</option>
                            </select>
                          </div>
                          <div class="col-lg-6">
                            <label for="linked_in_url" class="form-label"
                              >LinkedIn</label
                            >
                            <input
                              type="text"
                              class="form-control"
                              v-model="linked_in_url"
                              placeholder="Enter your LinkedIn URL"
                            />
                            <div
                              v-if="errors.linked_in_url"
                              class="text-danger"
                            >
                              {{ errors.linked_in_url[0] }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary mt-4 ms-5">
      Update Profile
    </button>
  </form>
</template>

  <script>
import axios from "axios";
import App from './App.vue'
export default {
    mounted() {
    this.fetchUserData();
  },
  data() {
    return {
      avatar: null,
      firstName: "",
      lastName: "",
      employeeId: "",
      manager: "",
      title: "",
      department: "",
      why_i_volunteer: "",
      profile_text: "",
      availability: "",
      linked_in_url: "",
      errors: {},
      selectedCountryId: null,
      selectedCityId: null,
      countries: [],
      cityDropdowns: [],
      countries: [],
    };
  },
  computed: {
    fullName() {
      return this.firstName + " " + this.lastName;
    },
    getCitiesForSelectedCountry() {
      const index = this.cityDropdowns.length - 1;
      //console.log(index);
      return this.cityDropdowns[index] ? this.cityDropdowns[index].cities : [];
    },
  },
  methods: {
    updateProfile() {
      const formData = new FormData();
      formData.append("avatar", this.avatar);
      formData.append("first_name", this.firstName);
      formData.append("last_name", this.lastName);
      formData.append("employee_id", this.employeeId);
      formData.append("manager", this.manager);
      formData.append("title", this.title);

      // Send the form data to the server using Axios or any other method
      // Here, you can make an API request to your Laravel backend
      // axios.post('/api/update-profile', formData)
      //   .then(response => {
      //     // Handle success response
      //     console.log(response.data);
      //   })
      //   .catch(error => {
      //     // Handle error response
      //     if (error.response && error.response.data && error.response.data.errors) {
      //       this.errors = error.response.data.errors;
      //     } else {
      //       console.error(error);
      //     }
      //   });
    },
    fetchCities(countryId) {
      axios
        .post("/api/fetch-city", {
          country_id: countryId,
          _token: "{{ csrf_token() }}",
        })
        .then((response) => {
          const index = this.cityDropdowns.length;
          console.log(response.data);
          this.cityDropdowns.push({
            selectedCityId: null,
            cities: response.data.cities,
          });
          this.selectedCityId = null;
        })
        .catch((error) => {
          // Handle error
        });
    },
    fetchUserData() {
      axios.get(`/api/edit-profile/${this.$route.params.id}`)
        .then(response => {
          const user = response.data.user;
          console.log(response);
          console.log(response.data);

          // Use the user data in your Vue component as needed
        })
        .catch(error => {
          if (error.response && error.response.status === 401) {
            // Unauthorized, redirect to login page

             //window.location.href = '/user/login';
            // router.push('/user/login');
            // this.$router.push('/user/login');
          } else {

            console.log(error);
          }
        });
    }
  },
  async created() {
    const countriesResponse = await axios.get("/api/fetch-countries");
    this.countries = countriesResponse.data.countries;
    //console.log(this.countries);

    // Fetch cities on component mount if a country is already selected
    if (this.selectedCountryId) {
      console.log(this.selectedCountryId);
      this.fetchCities(this.selectedCountryId);
    }
  },
};
</script>
