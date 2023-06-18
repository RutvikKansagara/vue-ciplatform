<template>
    <div class="container-fluid mt-4 px-4">
      <ul class="nav border-bottom"><span class="nav-link active fs-1"> Mission </span></ul>
      <div class="ms-5 me-5 mt-5 mb-5 w-25 rounded">

        <router-link :to="`/admin/mission/create`" class="p-2 col border btn btn-success">
            <i class="fas fa-plus me-2"></i>Add</router-link></div>
      <table class="table table-responsive border-start border-end">
        <thead class="table-light">
          <tr>
            <th class="fs-5 py-4 px-3 font-weight-light col-lg-6">Mission Title</th>
            <th class="fs-5 py-4 font-weight-light col-lg-2">Mission Type</th>
            <th class="fs-5 py-4 font-weight-light col-lg-2">Start Date</th>
            <th class="fs-5 py-4 font-weight-light col-lg-2">End Date</th>
            <th class="fs-5 py-4 font-weight-light col-lg-1">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="mission in missions" :key="mission.id">
            <td class="px-3">{{ mission.title }}</td>
            <td>{{ mission.mission_type }}</td>
            <td>{{ formatDate(mission.start_date) }}</td>
            <td>{{ formatDate(mission.end_date) }}</td>
            <td class="d-flex">
              <router-link class="btn btn-white" :to="`/admin/mission/1/edit`">
                <i class="far fa-edit" style="color:orange;"></i>
              </router-link>


              <button type="button" @click="showDeleteMission(mission.mission_id)" class="btn btn-white">
                <img src="../../../public/Images/bin.png" style="width: 16px;height:20px" alt="delete">
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        missions: [],
      };
    },
    mounted() {
      this.fetchMissions();
    },
    methods: {
      formatDate(date) {
        const options = {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
      };

      const formattedDate = new Date(date).toLocaleDateString('en-US', options);
      const [month, day, year] = formattedDate.split('/');

      return `${day}-${month}-${year.slice(-2)}`;
      },
      fetchMissions() {
        // Make an API call to fetch the missions data from Laravel backend
        axios.get('/api/admin/mission')
          .then(response => {
            this.missions = response.data;
          })
          .catch(error => {
            console.error(error);
          });
      },

      async showDeleteMission(missionId) {
        // Handle delete modal logic
        try {
        await axios.delete(`/api/admin/mission/${missionId}`);
        this.missions = this.missions.filter(mission => mission.mission_id !== missionId);

      } catch (error) {
        console.error(error);
      }
      },
    },
  };
  </script>
