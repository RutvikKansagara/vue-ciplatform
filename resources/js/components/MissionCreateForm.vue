<template>
    <div class="container-fluid mt-4 px-4">
        <ul class="nav border-bottom">
            <span class="nav-link active fs-1">Add Mission</span>
        </ul>
        <div v-if="successMessage" class="alert alert-success mt-3">
            {{ successMessage }}
        </div>
        <form class="mt-3" @submit.prevent="submitForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <label for="missionTitle" class="form-label">Mission Title</label>
                    <input type="text" class="form-control" id="missionTitle" v-model="mission.title">
                    <div v-if="errors.title">
                        <div v-for="(error, index) in errors.title" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="missionDesc" class="form-label">Mission Short Description</label>
                    <input type="text" class="form-control" id="missionDesc" v-model="mission.short_description">
                    <div v-if="errors.short_description">
                        <div v-for="(error, index) in errors.short_description" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="inputAddress" class="form-label">Mission Description</label>
                    <!-- <textarea name="description" class="mt-5" type="text" v-model="mission.description"></textarea> -->
                    <ckeditor :editor="editor" v-model="mission.description" :config="editorConfig"
                        :disabled="isEditorDisabled"></ckeditor>

                </div>
                <div v-if="errors.description">
                    <div v-for="(error, index) in errors.description" :key="index" class="text-danger">
                        {{ error }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="country">Country</label>
                    <select name="country_id" class="form-control" id="country-dropdown" v-model="selectedCountryId"
                        @change="fetchCities(selectedCountryId)">
                        <option value="" disabled selected>Select Country</option>
                        <option v-for="country in countries" :value="country.country_id"
                            :selected="country.country_id === selectedCountryId" :key="country.country_id">
                            {{ country.name }}
                        </option>
                    </select>
                    <div v-if="errors.country_id">
                        <div v-for="(error, index) in errors.country_id" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="city">City</label>
                    <select class="form-control" name="city_id" id="city-dropdown" v-model="selectedCityId">
                        <option v-for="city in getCitiesForSelectedCountry" :value="city.city_id"
                            :selected="city.city_id === selectedCityId" :key="city.city_id">
                            {{ city.name }}
                        </option>
                        <!-- Options will be dynamically populated based on selected country -->
                    </select>
                    <div v-if="errors.city_id">
                        <div v-for="(error, index) in errors.city_id" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>

                <!-- ... Existing code above ... -->

                <div class="row">
                    <div class="col-md-6">
                        <label for="orgName" class="form-label">Mission Organisation Name</label>
                        <input type="text" class="form-control" id="orgName" v-model="mission.organization_name">
                    </div>
                    <div v-if="errors.organization_name">
                        <div v-for="(error, index) in errors.organization_name" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Mission Organisation Detail</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                            v-model="mission.organization_detail"></textarea>
                    </div>
                    <div v-if="errors.organization_detail">
                        <div v-for="(error, index) in errors.organization_detail" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputdate" class="form-label">Mission Start Date</label>
                        <div class="input-group date" id="datetimepicker1">
                            <input type="date" class="form-control" v-model="mission.start_date">
                        </div>
                        <div v-if="errors.start_date">
                            <div v-for="(error, index) in errors.start_date" :key="index" class="text-danger">
                                {{ error }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Mission End Date</label>
                        <div class="input-group date" id="datetimepicker1">
                            <input type="date" class="form-control" v-model="mission.end_date">
                        </div>
                        <div v-if="errors.end_date">
                            <div v-for="(error, index) in errors.end_date" :key="index" class="text-danger">
                                {{ error }}
                            </div>
                        </div>
                    </div>


                </div>



                <div class="row">
                    <div class="col-md-6">
                        <label for="inputType" class="form-label">Mission Type</label>
                        <select id="inputType" class="form-select" v-model="mission.mission_type">
                            <option value="none" selected disabled hidden>select mission type</option>
                            <option value="TIME">Time</option>
                            <option value="GOAL">Goal</option>
                        </select>
                    </div>
                    <div v-if="errors.mission_type">
                        <div v-for="(error, index) in errors.mission_type" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="text" class="form-label">Total Seats</label>
                        <input type="text" class="form-control" id="text" v-model="mission.total_seats"
                            :disabled="mission.mission_type !== 'TIME'">
                    </div>
                    <div v-if="errors.total_seats">
                        <div v-for="(error, index) in errors.total_seats" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="missionRegDeadline" class="form-label">Mission Registration Deadline</label>
                        <input type="date" class="form-control" id="missionRegDeadline"
                            v-model="mission.registration_deadline" :disabled="mission.mission_type !== 'TIME'">
                    </div>
                    <div v-if="errors.registration_deadline">
                        <div v-for="(error, index) in errors.registration_deadline" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="goal_objective_text" class="form-label">Goal Objective Text</label>
                        <input type="text" class="form-control" id="goal_objective_text"
                            v-model="mission.goal_objective_text" :disabled="mission.mission_type !== 'GOAL'">
                    </div>
                    <div v-if="errors.goal_objective_text">
                        <div v-for="(error, index) in errors.objective_text" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="goal_value" class="form-label">Goal Value</label>
                        <input type="text" class="form-control" id="goal_value" v-model="mission.goal_value"
                            :disabled="mission.mission_type !== 'GOAL'">
                    </div>
                    <div v-if="errors.goal_value">
                        <div v-for="(error, index) in errors.goal_value" :key="index" class="text-danger">
                            {{ error }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="inputTheme" class="form-label">Mission Theme</label>
                    <select class="form-control" id="country-dropdown" v-model="mission.theme_id">
                        <option value="none" selected disabled hidden>select mission theme</option>
                        <option v-for="theme in missionthemes" :value="theme.mission_theme_id"
                            :selected="theme.mission_theme_id === mission.theme_id">
                            {{ theme.title }}
                        </option>

                    </select>
                </div>
                <div v-if="errors.theme_id">
                    <div v-for="(error, index) in errors.theme_id" :key="index" class="text-danger">
                        {{ error }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="mission_skills">Mission Skills</label>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle col-md-6 mb-5" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Select Skills
                        </button>
                        <div class="dropdown-menu col-md-6" aria-labelledby="dropdownMenuButton"
                            style="max-height: 200px; overflow-y: auto;">
                            <div v-for="skill in missionskills" class="form-check">
                                <input class="form-check-input" style="margin-left: 10px;" type="checkbox"
                                    :value="skill.skill_id" :id="`skill-${skill.skill_id}`"
                                    :checked="selectedSkills.includes(skill.skill_id)" v-model="selectedSkills">
                                <label class="form-check-label" style="margin-left: 50px;" :for="`skill-${skill.skill_id}`">
                                    {{ skill.skill_name }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="errors.skill_id">
                    <div v-for="(error, index) in errors.skill_id" :key="index" class="text-danger">
                        {{ error }}
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="customFile">Mission Images</label>
                    <input type="file" class="form-control" id="customFile" multiple v-on:change="handleFileUpload" />
                </div>
                <div v-if="errors.media_name">
                    <div v-for="(error, index) in errors.media_name" :key="index" class="text-danger">
                        {{ error }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label" for="customFile">Mission Documents</label>
                    <input type="file" class="form-control" id="customFile" multiple v-on:change="handleDocumentUpload" />
                </div>
                <div v-if="errors.document_name">
                    <div v-for="(error, index) in errors.document_name" :key="index" class="text-danger">
                        {{ error }}
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="inputAvailable" class="form-label">Mission Availability</label>
                    <select id="inputAvailable" class="form-select" name="availability" v-model="mission.availability">
                        <option value="daily" :selected="mission.availability === 'daily'">Daily</option>
                        <option value="weekly" :selected="mission.availability === 'weekly'">Weekly</option>
                        <option value="week-end" :selected="mission.availability === 'week-end'">Week-end</option>
                        <option value="monthly" :selected="mission.availability === 'monthly'">Monthly</option>
                    </select>
                </div>
                <div v-if="errors.availability">
                    <div v-for="(error, index) in errors.availability" :key="index" class="text-danger">
                        {{ error }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="missionVideo" class="form-label">Mission Video</label>
                    <input type="text" class="form-control" id="orgVideo" v-model="mission.media_names">
                </div>
                <div v-if="errors.media_names">
                    <div v-for="(error, index) in errors.media_names" :key="index" class="text-danger">
                        {{ error }}
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" v-model="mission.status">
                        <option value="0" :selected="mission.status === '0'">Inactive</option>
                        <option value="1" :selected="mission.status === '1'">Active</option>
                    </select>
                </div>
                <div v-if="errors.status">
                    <div v-for="(error, index) in errors.status" :key="index" class="text-danger">
                        {{ error }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 py-4">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                <div class="col-6 py-4">
                    <a class="btn btn-primary pull-right float-end" href="/admin/mission">cancel</a>
                </div>




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
            errors: {},
            successMessage: '',

            selectedFiles: [],
            selectedDocFiles: [],
            formData: new FormData(),
            selectedCountryId: null,
            selectedCityId: null,
            selectedSkills: [],
            // selectedSkills: '',
            countries: [],
            cityDropdowns: [],
            editor: ClassicEditor,

            editorConfig: {
                // The configuration of the editor.
            },
            isEditorDisabled: false,
            missionType: '',
            totalSeats: '',
            registrationDeadline: '',
            goalObjectiveText: '',
            goalValue: '',
            mission: {
                title: '',
                short_description: '',
                description: '',
                organization_name: '',
                organization_detail: '',
                start_date: '',
                end_date: '',
                mission_type: '',
                theme_id: '',
                availability: '',
                media_names: '',
                status: '',
                total_seats: '',
                registration_deadline: '',
                goal_value: '',
                goal_objective_text: '',
                description: "<p>Content of the editor.</p>",
            },
            countries: [],
            missionskills: [],
            missionthemes: [],
        };
    },

    methods: {
        handleFileUpload(event) {
            this.selectedFiles = event.target.files;
        },
        handleDocumentUpload(event) {
            this.selectedDocFiles = event.target.files;
        },
        async submitForm() {
            this.errors = {};
            console.log(this.mission);
            for (let i = 0; i < this.selectedFiles.length; i++) {
                this.formData.append('media_name[]', this.selectedFiles[i], this.selectedFiles[i].name);
            }

            for (let i = 0; i < this.selectedDocFiles.length; i++) {
                this.formData.append('document_name[]', this.selectedDocFiles[i], this.selectedDocFiles[i].name);
            }
            this.formData.append('title', this.mission.title);
            this.formData.append('short_description', this.mission.short_description);
            this.formData.append('description', this.mission.description);
            this.formData.append('organization_name', this.mission.organization_name);
            this.formData.append('organization_detail', this.mission.organization_detail);
            this.formData.append('start_date', this.mission.start_date);
            this.formData.append('end_date', this.mission.end_date);
            this.formData.append('mission_type', this.mission.mission_type);
            this.formData.append('theme_id', this.mission.theme_id);
            this.formData.append('availability', this.mission.availability);
            this.formData.append('media_names', this.mission.media_names);
            this.formData.append('status', this.mission.status);
            if (this.mission.mission_type === 'TIME') {
                this.formData.append('total_seats', this.mission.total_seats);
                this.formData.append('registration_deadline', this.mission.registration_deadline);
            }
            if (this.mission.mission_type === 'GOAL') {
                this.formData.append('goal_value', this.mission.goal_value);
                this.formData.append('goal_objective_text', this.mission.goal_objective_text);
            }
            this.formData.append('description', this.mission.description);
            this.formData.append('country_id', this.selectedCountryId);
            this.formData.append('city_id', this.selectedCityId);
            this.selectedSkills.forEach(skillId => {
                this.formData.append('skill_id[]', skillId);
            });
            console.log('FormData fields and values:');
            for (const pair of this.formData.entries()) {
                console.log(pair[0] + ':', pair[1]);
            }

            console.log('Image Files:');
            for (let pair of this.formData.entries()) {
                if (pair[0] === 'media_name[]') {
                    console.log(pair[0], pair[1]);
                }
            }

            console.log('Document Files:');
            for (let pair of this.formData.entries()) {
                if (pair[0] === 'document_name[]') {
                    console.log(pair[0], pair[1]);
                }
            }
            axios
                .post("/api/admin/mission", this.formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }

                )
                .then((response) => {
                    this.successMessage = response.data.message;
                    console.log(this.successMessage);
                })
                .catch((error) => {

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        // Handle other types of errors
                    }
                    // Handle error
                });

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


    },
    computed: {
        getCitiesForSelectedCountry() {
            const index = this.cityDropdowns.length - 1;
            //console.log(index);
            return this.cityDropdowns[index] ? this.cityDropdowns[index].cities : [];
        },
    },
    async created() {
        try {
            const countriesResponse = await axios.get("/api/fetch-countries");
            this.countries = countriesResponse.data.countries;
            //console.log(this.countries);


            // Fetch cities on component mount if a country is already selected
            if (this.selectedCountryId) {
                console.log(this.selectedCountryId);
                this.fetchCities(this.selectedCountryId);
            }

            const themesResponse = await axios.get("/api/fetch-themes");
            this.missionthemes = themesResponse.data.missionthemes;
            //console.log(this.missionthemes);

            const skillsResponse = await axios.get("/api/fetch-skills");
            this.missionskills = skillsResponse.data.missionskills;
            //console.log(this.missionskills);
        } catch (error) {
            console.log(error);
        }


    },
    watch: {
        'mission.mission_type': function (newMissionType) {
            if (newMissionType === 'GOAL') {
                this.mission.total_seats = '';
                this.mission.registration_deadline = '';
            }
            if (newMissionType === 'TIME') {
                this.mission.goal_value = '';
                this.mission.goal_objective_text = '';
            }
        },
    },
};
</script>
