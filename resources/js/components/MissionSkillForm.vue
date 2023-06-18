<template>
    <div class="ms-5 me-5 mt-5">
        <h2 v-if="isNewMissionSkill">Add</h2>
        <h2 v-else>Edit Mission Skill</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input class="form-control" type="text" id="name" v-model="missionskill.skill_name"/>
            </div>
            <div v-if="formErrors.skill_name" class="alert alert-danger" role="alert">
                {{ formErrors.skill_name[0] }}
            </div>
            <div class="w-100">
                <label for="status">Status:</label>
                <select v-model="missionskill.status" id="status" class="w-75 mt-5 h-100">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div v-if="formErrors.status" class="alert alert-danger" role="alert">
                {{ formErrors.status[0] }}
            </div>
            <button type="submit" v-if="isNewMissionSkill" class="btn btn-primary">Add</button>
            <button type="submit" v-else class="btn btn-primary">Update</button>
            <div v-if="successMessage" class="alert alert-success mt-5" role="alert">
                {{ successMessage }}
            </div>
            <!-- <div v-if="errorMessage" class="alert alert-danger mt-5" role="alert">
                {{ errorMessage }}
            </div> -->
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
            errorMessage:'',
            missionskill: {
                skill_name: '',
                status: 1,
            }
        }
    },
    computed: {
        isNewMissionSkill() {
            return !this.$route.path.includes('edit');
        }
    },
    async created() {
        if (!this.isNewMissionSkill) {
            const response = await axios.get(`/api/missionskill/${this.$route.params.id}`);
            console.log(response);
            this.missionskill = response.data;
            console.log(this.missionskill);
        }
    },
    methods: {
        async submitForm() {
            try {
                this.formErrors = {};
                this.successMessage = '';
                if (this.isNewMissionSkill) {
                    const response = await axios.post('/api/missionskill', this.missionskill);
                    this.successMessage = response.data.message;
                } else {
                    const response = await axios.put(`/api/missionskill/${this.$route.params.id}`, this.missionskill);
                    this.successMessage = response.data.message;
                }
                //this.$router.push('/missionskill');
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
